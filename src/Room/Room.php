<?php

namespace Root\BackendChallenge\Room;

use Root\BackendChallenge\Outcome\OutcomeInterface;

/**
 * An class describing a room of the game.
 */
class Room implements RoomInterface {

  /**
   * The introduction to display when the character enters the room.
   *
   * @var string
   */
  protected $introduction;

  /**
   * The question to display when the character enters the room.
   *
   * @var string
   */
  protected $question;

  /**
   * The different outcomes of the room.
   *
   * @var \Root\BackendChallenge\Outcome\OutcomeInterface[]
   */
  protected $outcomes;

  /**
   * Creates a new Room object.
   *
   * @param string $introduction
   *   The introduction to display when the character enters the room.
   * @param string $question
   *   The question to display when the character enters the room.
   * @param \Root\BackendChallenge\Outcome\OutcomeInterface[] $outcomes
   *   The different outcomes of the room.
   */
  public function __construct(string $introduction, string $question, array $outcomes = []) {
    $this->introduction = $introduction;
    $this->question = $question;
    $this->outcomes = $outcomes;
  }

  /**
   * {@inheritdoc}
   */
  public function introduction(): string {
    return $this->introduction;
  }

  /**
   * {@inheritdoc}
   */
  public function question(): string {
    return $this->question;
  }

  /**
   * {@inheritdoc}
   */
  public function outcomes(): array {
    return $this->outcomes;
  }

  /**
   * Add an outcome to the list.
   *
   * @param string $name
   *   The name of the outcome.
   * @param \Root\BackendChallenge\Outcome\OutcomeInterface $outcome
   *   The outcome to add.
   *
   * @return static
   *   The current Room object.
   */
  public function addOutcome(string $name, OutcomeInterface $outcome): static {
    $this->outcomes[$name] = $outcome;

    return $this;
  }

}
