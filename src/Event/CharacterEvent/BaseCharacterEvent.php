<?php

namespace Root\BackendChallenge\Event\CharacterEvent;

use Root\BackendChallenge\Character\CharacterInterface;
use Root\BackendChallenge\Event\EventInterface;

/**
 * Base character event class.
 */
abstract class BaseCharacterEvent implements EventInterface {

  /**
   * The character who will be affected by the event.
   *
   * @var \Root\BackendChallenge\Character\CharacterInterface
   */
  protected $character;

  /**
   * Creates a new BaseCharacterEvent object.
   *
   * @param \Root\BackendChallenge\Character\CharacterInterface $character
   *   The character who will be affected by the event.
   */
  public function __construct(CharacterInterface $character) {
    $this->character = $character;
  }

}
