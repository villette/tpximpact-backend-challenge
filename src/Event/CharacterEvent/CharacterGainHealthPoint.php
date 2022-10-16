<?php

namespace Root\BackendChallenge\Event\CharacterEvent;

use Root\BackendChallenge\Character\Character;

/**
 * Triggers the gain of one point for the character.
 */
class CharacterGainHealthPoint extends BaseCharacterEvent {

  /**
   * {@inheritdoc}
   */
  public function resolveEvent(): void {
    // Retreive character instance.
    $character = Character::getInstance();

    $character->gainHealthPoint();
  }

}
