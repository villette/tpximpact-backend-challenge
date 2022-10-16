<?php

namespace Root\BackendChallenge\Event;

use Root\BackendChallenge\Character\Character;
use Root\BackendChallenge\Character\CharacterInterface;
use Root\BackendChallenge\Exceptions\GameOverException;
use Symfony\Component\Console\Command\Command;

/**
 * Triggers the loss of one point for the character.
 */
class CharacterLoseHealthPoint implements EventInterface {

  /**
   * {@inheritdoc}
   *
   * @throws \Root\BackendChallenge\Exception\GameOverException
   */
  public function resolveEvent(): void {
    // Retreive character instance.
    $character = Character::getInstance();

    $character->loseHealthPoint();

    if ($character->getHealth() <= CharacterInterface::MINIMUM_HEALTH) {
      throw new GameOverException('You ran out of hearts, you die.', Command::FAILURE);
    }
  }

}
