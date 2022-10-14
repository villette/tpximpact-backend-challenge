<?php

/**
 * @file
 * Entrypoint of the TPXimpact Backend Challenge application.
 */

require __DIR__ . '/vendor/autoload.php';

use Root\BackendChallenge\BackendChallengeCommand;
use Symfony\Component\Console\Application;

$application = new Application();

$application->add(new BackendChallengeCommand());

$application->run();
