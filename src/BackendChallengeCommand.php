<?php

namespace Root\BackendChallenge;

use Root\BackendChallenge\Character\Character;
use Root\BackendChallenge\Event\GameExit;
use Root\BackendChallenge\Event\GameSave;
use Root\BackendChallenge\Event\GameStatus;
use Root\BackendChallenge\Exceptions\BackendChallengeException;
use Root\BackendChallenge\Outcome\Outcome;
use Root\BackendChallenge\Outcome\OutcomeInterface;
use Root\BackendChallenge\Room\Room;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Yaml\Yaml;

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
        // Retreive character instance.
        $character = Character::getInstance();

        // Initialise character progress.
        $progress = $character->getProgress();
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
    // Initialise game character.
    $character = Character::getInstance();

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

        // Set character data.
        $character->setName($data['name'] ?? NULL);
        $character->setHealth($data['health'] ?? NULL);
        $character->setProgress($data['progress'] ?? NULL);
      }
      else {
        // Ask the player for the character name.
        $question = new Question("What is your name?\n");

        // Get name answer from player and assign it to character.
        $name = $questionHelper->ask($input, $output, $question);

        // Set character data.
        $character->setName($name);

        $output->writeln(sprintf('Your name is %s', $character->getName()));
      }

      $output->writeln('');
    }

    // Initialise game rooms.
    $this->map = $this->prepareRooms();
  }

  /**
   * Prepares the rooms that the character will go through during the game.
   *
   * This method loads data from a YAML file to prepare a list of rooms with
   * their flavour texts, questions, answers and outcomes. This list will then
   * be used by the execute() method to make the character go through them.
   *
   * @return \Root\BackendChallenge\Room\RoomInterface[]
   *   An array of rooms.
   *
   * @see \Root\BackendChallenge\Room\RoomInterface
   * @see \Root\BackendChallenge\Outcome\OutcomeInterface
   * @see \Root\BackendChallenge\Event\EventInterface
   */
  private function prepareRooms(): array {
    $rooms = [];

    // Load all rooms from the data YAML file.
    $data = Yaml::parseFile(DATA_FILE);
    foreach ($data['rooms'] ?? [] as $room) {
      $rooms[] = new Room(
        $room['introduction'],
        $room['question'],
        array_map(function (array $outcome) {
          return new Outcome(
            $outcome['choice'],
            $outcome['result'],
            array_map(function (string $consequence) {
              return new $consequence;
            }, $outcome['consequences'])
          );
        }, $room['outcomes'])
      );
    }

    // Add global outcomes like "status" and "save" to each room.
    foreach ($rooms as $room) {
      $room
        ->addOutcome('status', new Outcome('Check my status', '', [new GameStatus()]))
        ->addOutcome('save', new Outcome('Save game and exit', '', [new GameSave()]))
        ->addOutcome('exit', new Outcome('Exit without saving', '', [new GameExit()]));
    }

    return $rooms;
  }

}
