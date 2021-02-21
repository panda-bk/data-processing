<?php

$loader = include __DIR__ . '/vendor/autoload.php';
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

$app = new Application;

$command = new \App\Command\ImportFileCommand();

$app->add($command);

$app->run();