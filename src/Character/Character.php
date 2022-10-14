<?php

namespace Root\BackendChallenge\Character;

/**
 * A class describing the character of the game.
 */
class Character implements CharacterInterface {

  /**
   * The number of hearts the character has.
   *
   * @var int
   */
  protected $healthPoints;

  /**
   * Creates a new Character object.
   */
  public function __construct() {
    $this->healthPoints = self::STARTING_HEALTH_POINTS;
  }

  /**
   * {@inheritdoc}
   */
  public function setHealthPoints(int $healthPoints): static {
    if ($healthPoints < self::MINIMUM_HEALTH_POINTS) {
      $healthPoints = self::MINIMUM_HEALTH_POINTS;
    }

    $this->healthPoints = $healthPoints;

    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getHealthPoints(): int {
    return $this->healthPoints;
  }

  /**
   * {@inheritdoc}
   */
  public function gainHealthPoint(): static {
    $healthPoints = $this->getHealthPoints();
    $healthPoints++;
    $this->setHealthPoints($healthPoints);

    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function loseHealthPoint(): static {
    $healthPoints = $this->getHealthPoints();
    $healthPoints--;
    $this->setHealthPoints($healthPoints);

    return $this;
  }

}
