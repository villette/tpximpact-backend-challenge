<?php

namespace Root\BackendChallenge\Character;

/**
 * An interface describing the character of the game.
 */
interface CharacterInterface {

  /**
   * The number of hearts the character starts the game with.
   */
  const STARTING_HEALTH_POINTS = 3;

  /**
   * The minimum number of hearts the character can have.
   */
  const MINIMUM_HEALTH_POINTS = 0;

  /**
   * Sets hearts to a character.
   *
   * @param int $healthPoints
   *   The number of hearts to assign to the character.
   *
   * @return static
   *   The current character object.
   */
  public function setHealthPoints(int $healthPoints): static;

  /**
   * Gets the number of hearts the character has.
   *
   * @return int
   *   The number of hearts the character has.
   */
  public function getHealthPoints(): int;

  /**
   * Add one heart to the number of hearts.
   *
   * @return static
   */
  public function gainHealthPoint(): static;

  /**
   * Remove one heart to the number of hearts.
   *
   * @return static
   */
  public function loseHealthPoint(): static;

}
