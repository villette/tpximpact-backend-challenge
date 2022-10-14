<?php

namespace Root\BackendChallenge;

use Root\BackendChallenge\Character\Character;
use Root\BackendChallenge\Events\CharacterDies;
use Root\BackendChallenge\Events\CharacterExitSuccess;
use Root\BackendChallenge\Events\CharacterGainHealthPoint;
use Root\BackendChallenge\Events\CharacterLoseHealthPoint;
use Root\BackendChallenge\Exceptions\BackendChallengeException;
use Root\BackendChallenge\Exceptions\GameWonException;
use Root\BackendChallenge\Outcome\Outcome;
use Root\BackendChallenge\Outcome\OutcomeInterface;
use Root\BackendChallenge\Room\Room;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

#[AsCommand(name: 'start', description: 'Start the Backend Challenge game')]
class BackendChallengeCommand extends Command {

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
    $helper = $this->getHelper('question');

    try {
      foreach ($this->map as $room) {
        $output->writeln($room->introduction());

        $outcomes = $room->outcomes();
        $answers = array_map(function (OutcomeInterface $outcome) {
          return $outcome->choice();
        }, $outcomes);

        $question = new ChoiceQuestion(
          $room->question(),
          $answers,
        );

        $answer = $helper->ask($input, $output, $question);

        $chosenOutcome = $outcomes[$answer];
        $output->writeln($chosenOutcome->result());

        if ($consequence = $chosenOutcome->consequence()) {
          $consequence->resolveEvent();
        }

        $output->writeln('');
      }

      // If we go through all the rooms without throwing exception, then we win.
      throw new GameWonException('You successfully exited the dungeon, congratulations!', Command::SUCCESS);
    }
    catch (BackendChallengeException $e) {
      $output->writeln($e->getMessage());

      return $e->getCode();
    }
  }

  /**
   * {@inheritdoc}
   */
  protected function initialize(InputInterface $input, OutputInterface $output): void {
    $this->character = new Character();
    $this->map = $this->prepareRooms();
  }

  /**
   * Prepares the rooms that the character will go through during the game.
   *
   * @return \Root\BackendChallenge\Room\RoomInterface[]
   *   An array of rooms.
   */
  private function prepareRooms(): array {
    return [
      new Room(
        'You are in a dungeon. A goblin stares at you menacingly.',
        'The goblin charges toward you, blade drawn. Do you:',
        [
          'attack' => new Outcome(
            'Attack the goblin',
            "You parry the goblin's strike, and cleave it in two, but not before it nicks you with a hidden blade. You lose one heart.",
            new CharacterLoseHealthPoint($this->character),
          ),
          'run' => new Outcome(
            'Run away',
            'You sprint towards the nearest exit, outpacing the goblin easily.',
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
            new CharacterLoseHealthPoint($this->character),
          ),
          'left_door' => new Outcome(
            'Go through the left hand door',
            'The door locks behind you and you are in an open courtyard.',
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
            new CharacterGainHealthPoint($this->character),
          ),
          'ignore' => new Outcome(
            'Ignore the table of refreshments, fearing poison and move on to the next room',
            'Your injuries and fatigue cause you to fall into a bed of hemlock.',
            new CharacterDies($this->character),
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
            new CharacterLoseHealthPoint($this->character),
          ),
          'decline' => new Outcome(
            'Decline and ask for directions to the W.C.',
            'You reach the W.C. and have a wash.'
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
            new CharacterLoseHealthPoint($this->character),
          ),
          'borrow' => new Outcome(
            'Borrow the book eagerly recommended by the librarian, as this is your first visit and you wish to impress',
            'You put the book in your bag and walk towards the exit.',
            new CharacterExitSuccess(),
          ),
        ],
      ),
    ];
  }

}
