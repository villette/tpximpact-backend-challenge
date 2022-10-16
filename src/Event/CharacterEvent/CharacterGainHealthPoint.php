<?php

namespace Root\BackendChallenge\Event\CharacterEvent;

/**
 * Triggers the gain of one point for the character.
 */
class CharacterGainHealthPoint extends BaseCharacterEvent {

  /**
   * {@inheritdoc}
   */
  public function resolveEvent(): void {
    $this->character->gainHealthPoint();
  }

}
