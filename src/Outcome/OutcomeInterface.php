<?php

namespace Root\BackendChallenge\Outcome;

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
   * Gets the consequences of the outcome in form of events.
   *
   * @return \Root\BackendChallenge\Events\EventInterface[]
   *   The events that will trigger as consequences of this outcome.
   */
  public function consequences(): array;

}
