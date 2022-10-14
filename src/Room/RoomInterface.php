<?php

namespace Root\BackendChallenge\Room;

/**
 * An interface describing a room of the game.
 */
interface RoomInterface {

  /**
   * Gets the introduction text for the room.
   *
   * @return string
   *   The introduction text for the room.
   */
  public function introduction(): string;

  /**
   * Gets the question text for the room.
   *
   * @return string
   *   The question text for the room.
   */
  public function question(): string;

  /**
   * Gets the outcomes of the room.
   *
   * @return \Root\BackendChallenge\Outcome\OutcomeInterface[]
   *   The different outcomes of the room.
   */
  public function outcomes(): array;

}
