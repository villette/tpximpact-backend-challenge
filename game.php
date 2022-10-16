#!/usr/local/bin/php
<?php

/**
 * @file
 * Entrypoint of the TPXimpact Backend Challenge application.
 */

require __DIR__ . '/vendor/autoload.php';

use Root\BackendChallenge\BackendChallengeCommand;
use Symfony\Component\Console\Application;

// Define useful constants.
const GAME_SAVE_FILE = __DIR__ . DIRECTORY_SEPARATOR . 'game.sav';
const DATA_FILE = __DIR__ . DIRECTORY_SEPARATOR . 'data.yml';

// Bootstrap application.
$application = new Application();

// Add main game command.
$application->add(new BackendChallengeCommand());

// Run application.
$application->run();
