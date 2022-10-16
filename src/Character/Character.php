<?php

namespace Root\BackendChallenge\Character;

/**
 * A class describing the character of the game.
 */
class Character implements CharacterInterface {

  /**
   * The name of the character.
   *
   * @var string
   */
  protected $name;

  /**
   * The number of hearts the character has.
   *
   * @var int
   */
  protected $health;

  /**
   * Used to track to progress of the character through the rooms.
   *
   * @var int
   */
  protected $progress;

  /**
   * Creates a new Character object.
   */
  public function __construct(string $name = NULL, int $health = NULL, int $progress = NULL) {
    $this->setName($name ?? self::DEFAULT_NAME);
    $this->setHealth($health ?? self::DEFAULT_HEALTH);
    $this->setProgress($progress ?? self::DEFAULT_PROGRESS);
  }

  /**
   * {@inheritdoc}
   */
  public function setName(string $name): static {
    $this->name = $name;

    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getName(): string {
    return $this->name;
  }

  /**
   * {@inheritdoc}
   */
  public function setHealth(int $health): static {
    if ($health < self::MINIMUM_HEALTH) {
      $health = self::MINIMUM_HEALTH;
    }

    $this->health = $health;

    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getHealth(): int {
    return $this->health;
  }

  /**
   * {@inheritdoc}
   */
  public function gainHealthPoint(): static {
    $health = $this->getHealth();
    $health++;
    $this->setHealth($health);

    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function loseHealthPoint(): static {
    $health = $this->getHealth();
    $health--;
    $this->setHealth($health);

    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setProgress(int $progress): static {
    $this->progress = $progress;

    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getProgress(): int {
    return $this->progress;
  }

  /**
   * {@inheritdoc}
   */
  public function moveForward(): static {
    $this->progress++;

    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function moveBackwards(): static {
    $this->progress--;

    if ($this->progress < 0) {
      $this->progress = 0;
    }

    return $this;
  }

}
