<?php

use app\bot\VkBot;
use app\command\CommandManager;
use app\core\Application;
use app\user\CommonUser;

# Токен доступа
define('ACCES_TOKEN', '');

$totalTime = time();

require_once 'vendor/autoload.php';

if (empty(ACCES_TOKEN)) {
    echo 'Access token is required'.PHP_EOL;
    exit;
}

Application::createInstance();

$vkBot = new VkBot();
$userEmulation = new CommonUser(0, '', 'vk', '', '');
$commandManager = new CommandManager($userEmulation, '');

$getConversations = function (int $count, int $offset = 0) use ($vkBot): array {
    return $vkBot->getVkApiClient()->messages()->getConversations(ACCES_TOKEN, [
        'count'  => $count,
        'offset' => $offset,
    ]);
};

$result = $getConversations(1);
$allCount = (int)$result['count'];
$handledCount = 0;
$peerIdList = [];

while ($handledCount < $allCount) {
    $result = $getConversations(200, $handledCount);
    foreach ($result['items'] as $item) {
        if ($item['conversation']['peer']['type'] !== 'user') {
            continue;
        }

        $peerIdList[] = $item['conversation']['peer']['id'];
    }
    $handledCount += 200;
}

echo "Users count: {$allCount}".PHP_EOL;

$peerIdList = array_chunk($peerIdList, 100);
$message = $commandManager->renderTemplate('mass_mail.message');

if (empty($message)) {
    echo "Message is empty".PHP_EOL;
    exit;
}

echo "Chunks: ".count($peerIdList).PHP_EOL.PHP_EOL;

foreach ($peerIdList as $peerIdChunk) {
    $localTime = time();

    $vkBot->getVkApiClient()->messages()->send(ACCES_TOKEN, [
        'peer_ids' => $peerIdChunk,
        'message' => $message,
        'dont_parse_links' => 1,
        'random_id' => random_int(1, 99999999),
    ]);

    echo "Chunk [size: ".count($peerIdChunk)."] sent, time: ".(time() - $localTime).'s'.PHP_EOL;

    sleep(1);
}

echo PHP_EOL;
echo "Send successfully finished, total time: ".(time() - $totalTime).'s'.PHP_EOL;
