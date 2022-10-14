<?php

namespace Root\BackendChallenge\Event;

use Root\BackendChallenge\Character\CharacterInterface;
use Root\BackendChallenge\Exceptions\GameWonException;
use Symfony\Component\Console\Command\Command;

/**
 * Triggers game over from exiting dungeon successfully.
 */
class CharacterExitSuccess implements EventInterface {

  /**
   * The character who will gain a health point.
   *
   * @var \Root\BackendChallenge\Character\CharacterInterface
   */
  private $character;

  /**
   * Creates a new CharacterGainHealthPoint object.
   *
   * @param \Root\BackendChallenge\Character\CharacterInterface $character
   *   The character who will gain a health point.
   */
  public function __construct(CharacterInterface $character) {
    $this->character = $character;
  }

  /**
   * {@inheritdoc}
   *
   * @throws \Root\BackendChallenge\Exception\GameWonException
   */
  public function resolveEvent(): void {
    $name = $this->character->getName();
    $hearts = $this->character->getHealthPoints();

    $message = sprintf(
      'Congratulation %s! You successfully exited the dungeon with %s.',
      $name,
      $hearts == 1 ? sprintf('1 heart') : sprintf('%d hearts', $hearts),
    );

    throw new GameWonException($message, Command::SUCCESS);
  }

}
