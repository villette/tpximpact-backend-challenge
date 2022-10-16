<?php

namespace Root\BackendChallenge\Event;

use Root\BackendChallenge\Character\Character;

/**
 * Triggers the character to move backwards in the rooms.
 */
class CharacterMoveBackwards implements EventInterface {

  /**
   * {@inheritdoc}
   */
  public function resolveEvent(): void {
    // Retreive character instance.
    $character = Character::getInstance();

    $character->moveBackwards();
  }

}
