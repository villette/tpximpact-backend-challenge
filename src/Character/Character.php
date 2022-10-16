<?php

namespace Root\BackendChallenge\Character;

/**
 * A class describing the character of the game.
 */
final class Character implements CharacterInterface {

  /**
   * The unique instance of Character in the application.
   *
   * @var static
   */
  private static $instance;

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
  private function __construct() {
    $this->setName($name ?? self::DEFAULT_NAME);
    $this->setHealth($health ?? self::DEFAULT_HEALTH);
    $this->setProgress($progress ?? self::DEFAULT_PROGRESS);
  }

  /**
   * The unique way of retrieving the Character object.
   *
   * @return static
   *   The game's character object.
   */
  public static function getInstance(): static {
    if (empty(self::$instance)) {
      self::$instance = new static();
    }

    return self::$instance;
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
