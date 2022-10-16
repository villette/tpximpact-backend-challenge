<?php

namespace Root\BackendChallenge\Event\CharacterEvent;

use Root\BackendChallenge\Character\Character;

/**
 * Triggers the character to move forward in the rooms.
 */
class CharacterMoveForward extends BaseCharacterEvent {

  /**
   * {@inheritdoc}
   */
  public function resolveEvent(): void {
    // Retreive character instance.
    $character = Character::getInstance();

    $character->moveForward();
  }

}
