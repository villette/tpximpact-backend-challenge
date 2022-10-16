<?php

namespace Root\BackendChallenge\Event\CharacterEvent;

/**
 * Triggers the character to move backwards in the rooms.
 */
class CharacterMoveBackwards extends BaseCharacterEvent {

  /**
   * {@inheritdoc}
   */
  public function resolveEvent(): void {
    $this->character->moveBackwards();
  }

}
