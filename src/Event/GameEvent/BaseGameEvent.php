<?php

namespace Root\BackendChallenge\Event\GameEvent;

use Root\BackendChallenge\Character\CharacterInterface;
use Root\BackendChallenge\Event\EventInterface;

/**
 * Base game event class.
 */
abstract class BaseGameEvent implements EventInterface {

  /**
   * The character of the game.
   *
   * @var \Root\BackendChallenge\Character\CharacterInterface
   */
  protected $character;

  /**
   * Creates a new BaseGameEvent object.
   *
   * @param \Root\BackendChallenge\Character\CharacterInterface $character
   *   The character of the game.
   */
  public function __construct(CharacterInterface $character) {
    $this->character = $character;
  }

}
