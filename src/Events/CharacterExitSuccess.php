<?php

namespace Root\BackendChallenge\Events;

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
    throw new GameWonException('You successfully exited the dungeon, congratulations!', Command::SUCCESS);
  }

}
