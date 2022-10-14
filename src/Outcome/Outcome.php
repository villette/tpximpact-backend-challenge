<?php

namespace Root\BackendChallenge\Outcome;

use Root\BackendChallenge\Events\EventInterface;

/**
 * A class describing a choice outcome.
 */
class Outcome implements OutcomeInterface {

  /**
   * The choice of the outcome.
   *
   * @var string
   */
  protected $choice;

  /**
   * The result of the outcome.
   *
   * @var string
   */
  protected $result;

  /**
   * The consequence of the outcome.
   *
   * @var \Root\BackendChallenge\Events\EventInterface
   */
  protected $consequence;

  /**
   * Creates a new Outcome object.
   *
   * @param string $choice
   *   The choice of the outcome.
   * @param string $result
   *   The result of the outcome.
   * @param \Root\BackendChallenge\Events\EventInterface $consequence
   *   The consequence of the outcome.
   */
  public function __construct(string $choice, string $result, EventInterface $consequence = NULL) {
    $this->choice = $choice;
    $this->result = $result;
    $this->consequence = $consequence;
  }

  /**
   * {@inheritdoc}
   */
  public function choice(): string {
    return $this->choice;
  }

  /**
   * {@inheritdoc}
   */
  public function result(): string {
    return $this->result;
  }

  /**
   * {@inheritdoc}
   */
  public function consequence(): EventInterface|null {
    return $this->consequence;
  }

}
