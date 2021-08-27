<?php

require_once '../vendor/autoload.php';

\app\core\Application::createInstance();

$user = \app\user\CommonUser::findByExternalId('12345', 'test');
if (!$user) {
    $user = \app\user\CommonUser::register('12345', 'test');
}

$commandHandler = new \app\command\CommandManager($user, '/nextweek');
$result = $commandHandler->handle();

var_dump($result);
