<?php

namespace app\bot;

use app\command\CommandManager;
use app\core\Application;
use app\user\CommonUser;
use Exception;
use VK\CallbackApi\Server\VKCallbackApiServerHandler;
use VK\Client\VKApiClient;

/**
 * Требуемые ENV переменные:
 * - VK_API_GROUP_<group_id>_ACCESSED
 * - VK_API_GROUP_<group_id>_CONFIRMATION_TOKEN
 * - VK_API_GROUP_<group_id>_SECRET_KEY
 * - VK_API_GROUP_<group_id>_ACCESS_TOKEN
 */
class VkBot extends VKCallbackApiServerHandler
{
    /** @var VKApiClient */
    protected VKApiClient $vkApiClient;

    /** @var string */
    protected string $groupId = '';

    public function __construct()
    {
        $this->initVKApiClient();
    }

    /**
     * Инициализирует подключение к VK API
     */
    protected function initVKApiClient(): void
    {
        $this->vkApiClient = new VKApiClient();
    }

    /**
     * Передаёт полученное событие соответствующему обработчику события.
     *
     * @param array $event - полученное событие
     *
     * @throws \Exception
     */
    public function handle(array $event): void
    {
        if (!isset($event['type'])) {
            throw new Exception('Required parameter "type" is not passed: ' . print_r($event, true));
        }

        if (!isset($event['group_id'])) {
            throw new Exception('Required parameter "group_id" is not passed: ' . print_r($event, true));
        }

        $this->groupId = (string)$event['group_id'];

        if ($event['type'] == 'confirmation') {
            $this->confirmation($event['group_id'], $event['secret'] ?? null);
        } else {
            parent::parseObject($event['group_id'], $event['secret'] ?? null, $event['type'], $event['object']);
        }
    }

    /**
     * Выводит подтверждающий владение сервером токен,
     * если переданные group_id и secret соответствуют указанным в конфигурации бота.
     *
     * @param int $group_id - ID группы VK
     * @param null|string $secret - секретный ключ группы (если тот установлен)
     */
    public function confirmation(int $group_id, ?string $secret): void
    {
        if (!$this->checkSenderServer($group_id, $secret)) {
            Application::getInstance()->getLogger()->info("[VK] confirmation: {$group_id}, {$secret} access denied");
            die ('Access denied');
        }

        die ($this->getEnv('CONFIRMATION_TOKEN'));
    }

    /**
     * Передаёт команду полученного события соответствующему обработчику.
     *
     * @param int $group_id
     * @param string|null $secret
     * @param array $eventData
     *
     * @return bool
     * @throws Exception
     */
    public function messageNew(int $group_id, ?string $secret, array $eventData): bool
    {
        if (!$this->checkSenderServer($group_id, $secret)) {
            Application::getInstance()->getLogger()->info("[VK] message new: {$group_id}, {$secret} access denied");
            die ('Access denied');
        }

        if (!isset($eventData['id'])) {
            throw new Exception('Required parameter "id" is not passed: ' . print_r($eventData, true));
        }

        if (!isset($eventData['peer_id'])) {
            throw new Exception('Required parameter "peer_id" is not passed: ' . print_r($eventData, true));
        }

        if (!isset($eventData['text'])) {
            throw new Exception('Required parameter "text" is not passed: ' . print_r($eventData, true));
        }

        Application::getInstance()->getResponse()->sendAndContinueScript('ok');

        $requestCacheKey = md5($eventData['id'].$eventData['peer_id']);
        if (!empty(Application::getInstance()->getCache()->get($requestCacheKey, ''))) {
            return true;
        }
        Application::getInstance()->getCache()->set($requestCacheKey, 'Y', 5*86000);

        $user = CommonUser::findByExternalId($eventData['peer_id'], 'vk');
        if (!$user) {
            $user = CommonUser::register($eventData['peer_id'], 'vk');
        }

        if (!empty($eventData['payload'])) {
            $eventData['payload'] = json_decode($eventData['payload'], JSON_OBJECT_AS_ARRAY);
        }

        $commandManager = new CommandManager($user, $eventData['payload']['command'] ?? $eventData['text']);
        $result = $commandManager->handle();

        $message = $result->getError() ?: $result->getMessage();
        if (!empty($message)) {
            $this->sendMessage($user->getExternalId(), $message, $result->getKeyboard());
        }

        return true;
    }

    /**
     * Проверяет отправителя события
     * Если совпадает ID группы и секретный ключ - событие пришло от сервера VK
     *
     * @param int $groupId - ID группы VK
     * @param null|string $secret - секретный ключ группы (если тот установлен)
     * @return bool
     */
    protected function checkSenderServer(int $groupId, ?string $secret): bool
    {
        if (empty($this->getEnv('ACCESSED'))) {
            return false;
        }

        $secretKey = $this->getEnv('SECRET_KEY');

        if (!empty($secretKey) && strcmp($secret, $secretKey) === 0) {
            return true;
        }

        return false;
    }

    /**
     * @param string $key
     *
     * @return string
     */
    protected function getEnv(string $key): string
    {
        return Application::getInstance()->getEnvironment()->get('VK_API_GROUP_'.$this->groupId.'_'.$key, '');
    }

    /**
     * @throws \VK\Exceptions\Api\VKApiMessagesPrivacyException
     * @throws \VK\Exceptions\Api\VKApiMessagesDenySendException
     * @throws \VK\Exceptions\Api\VKApiMessagesTooLongMessageException
     * @throws \VK\Exceptions\Api\VKApiMessagesChatUserNoAccessException
     * @throws \VK\Exceptions\Api\VKApiMessagesTooManyPostsException
     * @throws \VK\Exceptions\Api\VKApiMessagesChatBotFeatureException
     * @throws \VK\Exceptions\VKClientException
     * @throws \VK\Exceptions\Api\VKApiMessagesCantFwdException
     * @throws \VK\Exceptions\Api\VKApiMessagesUserBlockedException
     * @throws \VK\Exceptions\VKApiException
     * @throws \VK\Exceptions\Api\VKApiMessagesKeyboardInvalidException
     * @throws \VK\Exceptions\Api\VKApiMessagesTooLongForwardsException
     * @throws \VK\Exceptions\Api\VKApiMessagesContactNotFoundException
     * @throws \Exception
     */
    protected function sendMessage(string $peerID, string $message, string $keyboard = null): void
    {
        if (is_null($keyboard)) {
            $keyboard = json_encode(array (
                'one_time' => true,
                'buttons'  => array ()
            ));
        }

        $this->vkApiClient->messages()->send($this->getEnv('ACCESS_TOKEN'), array (
            'peer_id'  => $peerID,
            'message'  => $message,
            'keyboard' => $keyboard,
            'dont_parse_links' => 1,
            'random_id' => random_int(1, 999999999999)
        ));
    }

    /**
     * @return \VK\Client\VKApiClient
     */
    public function getVkApiClient(): VKApiClient
    {
        return $this->vkApiClient;
    }
}