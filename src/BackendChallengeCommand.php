<?php

namespace Root\BackendChallenge;

use Root\BackendChallenge\Character\Character;
use Root\BackendChallenge\Event\CharacterEvent\CharacterDies;
use Root\BackendChallenge\Event\CharacterEvent\CharacterExitSuccess;
use Root\BackendChallenge\Event\CharacterEvent\CharacterGainHealthPoint;
use Root\BackendChallenge\Event\CharacterEvent\CharacterLoseHealthPoint;
use Root\BackendChallenge\Event\CharacterEvent\CharacterMoveForward;
use Root\BackendChallenge\Event\GameEvent\GameExit;
use Root\BackendChallenge\Event\GameEvent\GameSave;
use Root\BackendChallenge\Event\GameEvent\GameStatus;
use Root\BackendChallenge\Exceptions\BackendChallengeException;
use Root\BackendChallenge\Outcome\Outcome;
use Root\BackendChallenge\Outcome\OutcomeInterface;
use Root\BackendChallenge\Room\Room;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;

/**
 * Main symfony command of the Backend Challenge game.
 */
class BackendChallengeCommand extends Command {

  /**
   * {@inheritdoc}
   */
  protected static $defaultName = 'start';

  /**
   * {@inheritdoc}
   */
  protected static $defaultDescription = 'Start the Backend Challenge game';

  /**
   * The main character of the game.
   *
   * @var \Root\BackendChallenge\Character\CharacterInterface
   */
  private $character;

  /**
   * The succession of rooms the character can go through, in order.
   *
   * @var \Root\BackendChallenge\Room\RoomInterface[]
   */
  private $map;

  /**
   * {@inheritdoc}
   */
  protected function execute(InputInterface $input, OutputInterface $output): int {
    /** @var \Symfony\Component\Console\Helper\QuestionHelper $questionHelper */
    $questionHelper = $this->getHelper('question');

    try {
      // For each room the player goes through, do the following.
      do {
        $progress = $this->character->getProgress();
        $room = $this->map[$progress];

        // Present the flavour text to the player.
        $output->writeln($room->introduction());

        // Generate the different outcomes of the room.
        $outcomes = $room->outcomes();

        // Generate the different outcome answers.
        $answers = array_map(function (OutcomeInterface $outcome) {
          return $outcome->choice();
        }, $outcomes);

        // Present the room's question with its different answers.
        $question = new ChoiceQuestion(
          $room->question(),
          $answers,
        );

        // Prompt the player with the question and get the answer from stdin.
        $answer = $questionHelper->ask($input, $output, $question);

        // Display the result of the chosen outcome.
        $chosenOutcome = $outcomes[$answer];
        $output->writeln($chosenOutcome->result());

        // Resolve the consequences of the chosen outcome.
        foreach ($chosenOutcome->consequences() as $consequence) {
          $consequence->resolveEvent();
        }

        $output->writeln('');
      } while ($progress < count($this->map));
    }
    catch (BackendChallengeException $e) {
      // In case of a win or a loss, there is a BackendChallengeException thrown
      // with the relevant message, we just need to catch it and display it.
      $output->writeln($e->getMessage());

      return $e->getCode();
    }

    // The game should never reach this point, but we still need to return
    // something in this unlikely event.
    return Command::SUCCESS;
  }

  /**
   * {@inheritdoc}
   */
  protected function initialize(InputInterface $input, OutputInterface $output): void {
    /** @var \Symfony\Component\Console\Helper\QuestionHelper $questionHelper */
    $questionHelper = $this->getHelper('question');

    // Ask the player if they want to load game if a save game exists.
    if (file_exists(GAME_SAVE_FILE)) {
      $question = new ChoiceQuestion(
        'A saved game exists, do you want to load it or start a new one?',
        [
          'load' => 'Load existing game save',
          'new' => 'Start new game',
        ],
      );

      if ($questionHelper->ask($input, $output, $question) == 'load') {
        $content = file_get_contents(GAME_SAVE_FILE);
        $data = json_decode($content, TRUE);

        // Initialise game character.
        $this->character = new Character($data['name'] ?? NULL, $data['health'] ?? NULL, $data['progress'] ?? NULL);
      }
      else {
        // Ask the player for the character name.
        $question = new Question("What is your name?\n");

        // Get name answer from player and assign it to character.
        $name = $questionHelper->ask($input, $output, $question);

        // Initialise game character.
        $this->character = new Character($name);

        $output->writeln(sprintf('Your name is %s', $this->character->getName()));
      }

      $output->writeln('');
    }

    // Initialise game rooms.
    $this->map = $this->prepareRooms();
  }

  /**
   * Prepares the rooms that the character will go through during the game.
   *
   * This method statically prepares a list of rooms with their flavour texts,
   * questions, answers and outcomes. This list will then be used by the
   * execute() method to make the character go through them.
   *
   * @return \Root\BackendChallenge\Room\RoomInterface[]
   *   An array of rooms.
   *
   * @see \Root\BackendChallenge\Room\RoomInterface
   * @see \Root\BackendChallenge\Outcome\OutcomeInterface
   * @see \Root\BackendChallenge\Event\EventInterface
   */
  private function prepareRooms(): array {
    $rooms = [
      new Room(
        'You are in a dungeon. A goblin stares at you menacingly.',
        'The goblin charges toward you, blade drawn. Do you:',
        [
          'attack' => new Outcome(
            'Attack the goblin',
            "You parry the goblin's strike, and cleave it in two, but not before it nicks you with a hidden blade. You lose one heart.",
            [new CharacterLoseHealthPoint($this->character), new CharacterMoveForward($this->character)],
          ),
          'run' => new Outcome(
            'Run away',
            'You sprint towards the nearest exit, outpacing the goblin easily.',
            [new CharacterMoveForward($this->character)],
          ),
        ],
      ),

      new Room(
        'You pass through the exit and run down a corridor…',
        'At the end of the corridor, you find two doors and must pass through one of them. Do you:',
        [
          'right_door' => new Outcome(
            'Go through the right hand door',
            'You fall down a 3 meter drop on the other side, slightly injuring your ankle. You climb out of the hole and into an open courtyard. You lose one heart.',
            [new CharacterLoseHealthPoint($this->character), new CharacterMoveForward($this->character)],
          ),
          'left_door' => new Outcome(
            'Go through the left hand door',
            'The door locks behind you and you are in an open courtyard.',
            [new CharacterMoveForward($this->character)],
          ),
        ],
      ),

      new Room(
        'You see a table with food and drink.',
        'You are tired, hungry and thirsty. Do you:',
        [
          'enjoy' => new Outcome(
            'Eat, drink and rest',
            'You recover from your injuries and you are ready to move to the next room. You gain one heart.',
            [new CharacterGainHealthPoint($this->character), new CharacterMoveForward($this->character)],
          ),
          'ignore' => new Outcome(
            'Ignore the table of refreshments, fearing poison and move on to the next room',
            'Your injuries and fatigue cause you to fall into a bed of hemlock.',
            [new CharacterDies($this->character), new CharacterMoveForward($this->character)],
          ),
        ],
      ),

      new Room(
        'You are now in a beer cellar. You are tempted to try the merchandise.',
        'The barkeep offers you a beer. Do you:',
        [
          'accept' => new Outcome(
            'Accept the offer',
            'One beer is never enough and you get horribly drunk, in your haze, you stagger off. You lose one heart.',
            [new CharacterLoseHealthPoint($this->character), new CharacterMoveForward($this->character)],
          ),
          'decline' => new Outcome(
            'Decline and ask for directions to the W.C.',
            'You reach the W.C. and have a wash.',
            [new CharacterMoveForward($this->character)],
          ),
        ],
      ),

      new Room(
        'You reach a library. You see the librarian, who is an orangutan, hanging around the desk.',
        "The librarian says 'OOOK?' Do you:",
        [
          'return' => new Outcome(
            'Return the book you borrowed last time you were here and apologise for being late',
            'Your apology is accepted, so you live, but there is no excuse for your tardiness and you are fined 10 Splodges. You lose one heart.',
            [new CharacterLoseHealthPoint($this->character), new CharacterExitSuccess($this->character)],
          ),
          'borrow' => new Outcome(
            'Borrow the book eagerly recommended by the librarian, as this is your first visit and you wish to impress',
            'You put the book in your bag and walk towards the exit.',
            [new CharacterExitSuccess($this->character)],
          ),
        ],
      ),
    ];

    // Add global outcomes like "status" and "save".
    foreach ($rooms as $room) {
      $room
        ->addOutcome('status', new Outcome('Check my status', '', [new GameStatus($this->character)]))
        ->addOutcome('save', new Outcome('Save game and exit', '', [new GameSave($this->character)]))
        ->addOutcome('exit', new Outcome('Exit without saving', '', [new GameExit($this->character)]));
    }

    return $rooms;
  }

}
