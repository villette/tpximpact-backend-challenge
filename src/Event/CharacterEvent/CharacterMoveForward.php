<?php

namespace Root\BackendChallenge\Event\CharacterEvent;

/**
 * Triggers the character to move forward in the rooms.
 */
class CharacterMoveForward extends BaseCharacterEvent {

  /**
   * {@inheritdoc}
   */
  public function resolveEvent(): void {
    $this->character->moveForward();
  }

}
