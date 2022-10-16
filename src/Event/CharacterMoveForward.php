<?php

namespace Root\BackendChallenge\Event;

use Root\BackendChallenge\Character\Character;

/**
 * Triggers the character to move forward in the rooms.
 */
class CharacterMoveForward implements EventInterface {

  /**
   * {@inheritdoc}
   */
  public function resolveEvent(): void {
    // Retreive character instance.
    $character = Character::getInstance();

    $character->moveForward();
  }

}
