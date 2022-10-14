<?php

namespace Root\BackendChallenge\Outcome;

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
   * The consequences of the outcome.
   *
   * @var \Root\BackendChallenge\Events\EventInterface[]
   */
  protected $consequences;

  /**
   * Creates a new Outcome object.
   *
   * @param string $choice
   *   The choice of the outcome.
   * @param string $result
   *   The result of the outcome.
   * @param \Root\BackendChallenge\Events\EventInterface[] $consequences
   *   The consequences of the outcome.
   */
  public function __construct(string $choice, string $result, array $consequences) {
    $this->choice = $choice;
    $this->result = $result;
    $this->consequences = $consequences;
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
  public function consequences(): array {
    return $this->consequences;
  }

}
