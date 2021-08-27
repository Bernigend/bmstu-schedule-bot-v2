<?php

namespace app\command\handlers;

use app\command\CommandManager;
use app\user\CommonUser;

abstract class ACommandHandler
{
    /** @var \app\command\CommandManager */
    protected CommandManager $commandManager;

    /**
     * @param \app\command\CommandManager $commandManager
     */
    public function __construct(CommandManager $commandManager)
    {
        $this->commandManager = $commandManager;
    }

    /**
     * Алиас метода рендеринга шаблона.
     *
     * @param string $templateName
     * @param array $params
     *
     * @return string
     */
    public function renderTemplate(string $templateName, array $params = []): string
    {
        return $this->commandManager->renderTemplate($templateName, $params);
    }

    /**
     * Возвращает массив обработчиков ожидаемого ввода.
     * В качестве ключа используется уникальный идентификатор ожидаемого ввода.
     * В качестве значения - callback, который будет вызван для обработки.
     *
     * На вход callback передаётся CommonUser $commonUser и string $userInput.
     *
     * @return array<string, callable>
     * @see CommonUser
     */
    abstract public function getExpectedInputHandlers(): array;

    /**
     * Возвращает массив обработчиков команд.
     * В качестве ключа используется уникальный идентификатор команды.
     * В качестве значения - callback, который будет вызван для обработки.
     *
     * На вход callback передаётся CommonUser $commonUser и string $userInput.
     *
     * @return array<string, callable>
     * @see CommonUser
     */
    abstract public function getCommandHandlers(): array;
}
