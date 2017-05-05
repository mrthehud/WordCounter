#!/usr/bin/env php
<?php

require __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Console\Application;
use Command\CountFrequentWordsCommand;

$application = new Application();
$command     = new CountFrequentWordsCommand();

$application->add($command);
$application->setDefaultCommand($command->getName(), true);
$application->run();
