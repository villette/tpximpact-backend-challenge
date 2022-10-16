<?php

namespace Root\BackendChallenge\Event;

/**
 * Used to describe a unique event that can occur once or multiple times.
 *
 * @todo determine if it's necessary to keep character and game events separated
 */
interface EventInterface {

  /**
   * Resolve the event.
   */
  public function resolveEvent(): void;

}
