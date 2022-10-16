<?php

namespace Root\BackendChallenge\Event;

use Root\BackendChallenge\Exceptions\GameExitException;
use Symfony\Component\Console\Command\Command;

/**
 * Triggers game exit.
 */
class GameExit implements EventInterface{

  /**
   * {@inheritdoc}
   *
   * @throws \Root\BackendChallenge\Exception\GameExitException
   */
  public function resolveEvent(): void {
    throw new GameExitException('Good bye.', Command::SUCCESS);
  }

}
