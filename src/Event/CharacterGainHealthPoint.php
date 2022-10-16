<?php

namespace Root\BackendChallenge\Event;

use Root\BackendChallenge\Character\Character;

/**
 * Triggers the gain of one point for the character.
 */
class CharacterGainHealthPoint implements EventInterface {

  /**
   * {@inheritdoc}
   */
  public function resolveEvent(): void {
    // Retreive character instance.
    $character = Character::getInstance();

    $character->gainHealthPoint();
  }

}
