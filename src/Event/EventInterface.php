<?php

namespace Root\BackendChallenge\Event;

/**
 * Used to describe a unique event that can occur once or multiple times.
 */
interface EventInterface {

  /**
   * Resolve the event.
   */
  public function resolveEvent(): void;

}
