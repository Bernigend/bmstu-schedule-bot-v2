<?php

require_once '../vendor/autoload.php';

\app\core\Application::createInstance();

$commandHandler = new \app\command\CommandHandler();

$user = \app\user\CommonUser::findByExternalId('1234', 'test');
if (!$user) {
    echo 'reg';
    $user = \app\user\CommonUser::register('1234', 'test');
}

$result = $commandHandler->handle($user, '/today');

var_dump($result);
