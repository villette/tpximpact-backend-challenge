<?php

namespace Root\BackendChallenge\Event\GameEvent;

use Root\BackendChallenge\Exceptions\GameExitException;
use Symfony\Component\Console\Command\Command;

/**
 * Triggers game save and exit.
 */
class GameSave extends BaseGameEvent {

  /**
   * {@inheritdoc}
   *
   * @throws \Root\BackendChallenge\Exception\GameExitException
   */
  public function resolveEvent(): void {
    $data = [
      'name' => $this->character->getName(),
      'health' => $this->character->getHealth(),
      'progress' => $this->character->getProgress(),
    ];

    // If an error occurs, do not exit the game.
    if (file_put_contents(GAME_SAVE_FILE, json_encode($data))) {
      throw new GameExitException('Game saved, good bye.', Command::SUCCESS);
    }
  }

}
