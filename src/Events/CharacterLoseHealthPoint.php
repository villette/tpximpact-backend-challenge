<?php

namespace Root\BackendChallenge\Events;

use Root\BackendChallenge\Character\CharacterInterface;
use Root\BackendChallenge\Exceptions\GameOverException;
use Symfony\Component\Console\Command\Command;

/**
 * Triggers the loss of one point for the character.
 */
class CharacterLoseHealthPoint implements EventInterface {

  /**
   * The character who will lose a health point.
   *
   * @var \Root\BackendChallenge\Character\CharacterInterface
   */
  private $character;

  /**
   * Creates a new CharacterLoseHealthPoint object.
   *
   * @param \Root\BackendChallenge\Character\CharacterInterface $character
   *   The character who will lose a health point.
   */
  public function __construct(CharacterInterface $character) {
    $this->character = $character;
  }

  /**
   * {@inheritdoc}
   *
   * @throws \Root\BackendChallenge\Exception\GameOverException
   */
  public function resolveEvent(): void {
    $this->character->loseHealthPoint();

    if ($this->character->getHealthPoints() <= CharacterInterface::MINIMUM_HEALTH_POINTS) {
      throw new GameOverException('You ran out of hearts, you die.', Command::FAILURE);
    }
  }

}
