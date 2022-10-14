<?php

namespace Root\BackendChallenge\Events;

use Root\BackendChallenge\Character\CharacterInterface;

/**
 * Triggers the gain of one point for the character.
 */
class CharacterGainHealthPoint implements EventInterface {

  /**
   * The character who will gain a health point.
   *
   * @var \Root\BackendChallenge\Character\CharacterInterface
   */
  private $character;

  /**
   * Creates a new CharacterGainHealthPoint object.
   *
   * @param \Root\BackendChallenge\Character\CharacterInterface $character
   *   The character who will gain a health point.
   */
  public function __construct(CharacterInterface $character) {
    $this->character = $character;
  }

  /**
   * {@inheritdoc}
   */
  public function resolveEvent(): void {
    $this->character->gainHealthPoint();
  }

}
