<?php

namespace Root\BackendChallenge\Events;

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
    $message = sprintf('You successfully exited the dungeon with %d hearts, congratulations!', $this->character->getHealthPoints());

    throw new GameWonException($message, Command::SUCCESS);
  }

}
