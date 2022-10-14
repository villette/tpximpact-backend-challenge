<?php

namespace Root\BackendChallenge\Outcome;

use Root\BackendChallenge\Events\EventInterface;

/**
 * Defines the different outcomes of the rooms.
 */
interface OutcomeInterface {

  /**
   * Gets the choice of the outcome.
   *
   * @return string
   *   The choice to display to the player to chose this outcome.
   */
  public function choice(): string;

  /**
   * Gets the result of the outcome.
   *
   * @return string
   *   The result to display to the player when choosing this outcome.
   */
  public function result(): string;

  /**
   * Gets the consequence of the outcome in form of event.
   *
   * @return \Root\BackendChallenge\Events\EventInterface|null
   *   The event that will trigger as a consequence of this outcome.
   */
  public function consequence(): EventInterface|null;

}
