<?php

namespace Root\BackendChallenge\Event;

use Root\BackendChallenge\Character\Character;
use Root\BackendChallenge\Exceptions\GameWonException;
use Symfony\Component\Console\Command\Command;

/**
 * Triggers game over from exiting dungeon successfully.
 */
class CharacterExitSuccess implements EventInterface {

  /**
   * {@inheritdoc}
   *
   * @throws \Root\BackendChallenge\Exception\GameWonException
   */
  public function resolveEvent(): void {
    // Retreive character instance.
    $character = Character::getInstance();

    $name = $character->getName();
    $hearts = $character->getHealth();

    $message = sprintf(
      'Congratulation %s! You successfully exited the dungeon with %s.',
      $name,
      $hearts == 1 ? sprintf('1 heart') : sprintf('%d hearts', $hearts),
    );

    throw new GameWonException($message, Command::SUCCESS);
  }

}
