<?php

namespace Root\BackendChallenge\Event\GameEvent;

use Root\BackendChallenge\Character\Character;

/**
 * Triggers display of game status.
 */
class GameStatus extends BaseGameEvent {

  /**
   * {@inheritdoc}
   */
  public function resolveEvent(): void {
    // Retreive character instance.
    $character = Character::getInstance();

    $progress = $character->getProgress();
    $hearts = $character->getHealth();

    // This is not great, we should use OutputInterface instead of print.
    print sprintf(
      "You are in room number %d and you have %s left.\n",
      $progress + 1,
      $hearts == 1 ? sprintf('1 heart') : sprintf('%d hearts', $hearts)
    );
  }

}
