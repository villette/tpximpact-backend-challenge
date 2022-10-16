<?php

namespace Root\BackendChallenge\Event\CharacterEvent;

use Root\BackendChallenge\Exceptions\GameWonException;
use Symfony\Component\Console\Command\Command;

/**
 * Triggers game over from exiting dungeon successfully.
 */
class CharacterExitSuccess extends BaseCharacterEvent {

  /**
   * {@inheritdoc}
   *
   * @throws \Root\BackendChallenge\Exception\GameWonException
   */
  public function resolveEvent(): void {
    $name = $this->character->getName();
    $hearts = $this->character->getHealth();

    $message = sprintf(
      'Congratulation %s! You successfully exited the dungeon with %s.',
      $name,
      $hearts == 1 ? sprintf('1 heart') : sprintf('%d hearts', $hearts),
    );

    throw new GameWonException($message, Command::SUCCESS);
  }

}
