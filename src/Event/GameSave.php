<?php

namespace Root\BackendChallenge\Event;

use Root\BackendChallenge\Character\Character;
use Root\BackendChallenge\Exceptions\GameExitException;
use Symfony\Component\Console\Command\Command;

/**
 * Triggers game save and exit.
 */
class GameSave implements EventInterface{

  /**
   * {@inheritdoc}
   *
   * @throws \Root\BackendChallenge\Exception\GameExitException
   */
  public function resolveEvent(): void {
    // Retreive character instance.
    $character = Character::getInstance();

    $data = [
      'name' => $character->getName(),
      'health' => $character->getHealth(),
      'progress' => $character->getProgress(),
    ];

    // If an error occurs, do not exit the game.
    if (file_put_contents(GAME_SAVE_FILE, json_encode($data))) {
      throw new GameExitException('Game saved, good bye.', Command::SUCCESS);
    }
  }

}
