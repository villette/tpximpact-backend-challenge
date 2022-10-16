<?php

namespace Root\BackendChallenge\Event\CharacterEvent;

use Root\BackendChallenge\Exceptions\GameOverException;
use Symfony\Component\Console\Command\Command;

/**
 * Triggers game over from death of character.
 */
class CharacterDies extends BaseCharacterEvent {

  /**
   * {@inheritdoc}
   *
   * @throws \Root\BackendChallenge\Exception\GameOverException
   */
  public function resolveEvent(): void {
    throw new GameOverException('You die. Horribly. Ouch!.', Command::FAILURE);
  }

}
