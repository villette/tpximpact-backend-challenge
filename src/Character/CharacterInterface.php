<?php

namespace Root\BackendChallenge\Character;

/**
 * An interface describing the character of the game.
 */
interface CharacterInterface {

  /**
   * The default name of the character if the player doesn't give any.
   */
  const DEFAULT_NAME = 'Maximilian';

  /**
   * The number of hearts the character starts the game with.
   */
  const DEFAULT_HEALTH = 3;

  /**
   * The room progress the character starts the game with.
   */
  const DEFAULT_PROGRESS = 0;

  /**
   * The minimum number of hearts the character can have.
   */
  const MINIMUM_HEALTH = 0;

  /**
   * Sets the name of the character.
   *
   * @param string $name
   *   The name to assign the character.
   *
   * @return static
   *   The current character object.
   */
  public function setName(string $name): static;

  /**
   * Gets the name of the character.
   *
   * @return string
   *   The name of the character.
   */
  public function getName(): string;

  /**
   * Sets hearts to a character.
   *
   * @param int $health
   *   The number of hearts to assign to the character.
   *
   * @return static
   *   The current character object.
   */
  public function setHealth(int $health): static;

  /**
   * Gets the number of hearts the character has.
   *
   * @return int
   *   The number of hearts the character has.
   */
  public function getHealth(): int;

  /**
   * Adds one heart to the number of hearts.
   *
   * @return static
   *   The current character object.
   */
  public function gainHealthPoint(): static;

  /**
   * Removes one heart to the number of hearts.
   *
   * @return static
   *   The current character object.
   */
  public function loseHealthPoint(): static;

  /**
   * Sets the progress of the character.
   *
   * @param int $progress
   *   The progress of the character through the rooms.
   *
   * @return static
   *   The current character object.
   */
  public function setProgress(int $progress): static;

  /**
   * Gets the progress of the character.
   *
   * @return int
   *   The progress of the character through the rooms.
   */
  public function getProgress(): int;

  /**
   * Makes the character move forward one room.
   *
   * @return static
   *   The current character object.
   */
  public function moveForward(): static;

  /**
   * Makes the character move backward one room.
   *
   * @return static
   *   The current character object.
   */
  public function moveBackwards(): static;

}
