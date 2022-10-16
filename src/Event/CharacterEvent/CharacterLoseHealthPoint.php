<?php

namespace Root\BackendChallenge\Event\CharacterEvent;

use Root\BackendChallenge\Character\CharacterInterface;
use Root\BackendChallenge\Exceptions\GameOverException;
use Symfony\Component\Console\Command\Command;

/**
 * Triggers the loss of one point for the character.
 */
class CharacterLoseHealthPoint extends BaseCharacterEvent {

  /**
   * {@inheritdoc}
   *
   * @throws \Root\BackendChallenge\Exception\GameOverException
   */
  public function resolveEvent(): void {
    $this->character->loseHealthPoint();

    if ($this->character->getHealth() <= CharacterInterface::MINIMUM_HEALTH) {
      throw new GameOverException('You ran out of hearts, you die.', Command::FAILURE);
    }
  }

}
