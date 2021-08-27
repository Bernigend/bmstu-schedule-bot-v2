<?php

namespace app\command\handlers;

use app\command\CommandResult;

class RegistrationCommandHandler extends ACommandHandler
{
    /** @var string отправка сообщения приветствия */
    public const SEND_GREETING = 'start.send_greeting';

    /** @var string ожидание команды /start */
    public const WAIT_START_COMMAND = 'start.wait_start_command';

    /** @var string команда регистрации пользователя */
    public const START_COMMAND = '/start';

    /** @inheritDoc */
    public function getExpectedInputHandlers(): array
    {
        return [
            static::SEND_GREETING => [$this, 'sendGreeting'],
            static::WAIT_START_COMMAND => [$this, 'waitStartCommand'],
        ];
    }

    /** @inheritDoc */
    public function getCommandHandlers(): array
    {
        return [
            static::START_COMMAND => [$this, 'startCommandHandler'],
        ];
    }

    /**
     * Отправляет сообщение приветствие.
     *
     * @return \app\command\CommandResult
     * @throws \app\core\database\exception\SqlException
     */
    public function sendGreeting(): CommandResult
    {
        $this->commandManager->getCommonUser()->setExpectedInput(static::WAIT_START_COMMAND)->save();
        return (new CommandResult())->setMessage($this->renderTemplate('start.greeting'));
    }

    /**
     * Обрабатывает весь ввод пользователя, пока тот не пришлёт /start.
     * Если пришлёт - проксирует выполнение команды.
     *
     * @return \app\command\CommandResult
     * @throws \Exception
     */
    public function waitStartCommand(): CommandResult
    {
        if ($this->commandManager->getUserInput() !== static::START_COMMAND) {
            return new CommandResult();
        }

        $this->commandManager->getCommonUser()->setExpectedInput('')->save();
        return $this->commandManager->emulateUserInput(static::START_COMMAND);
    }

    /**
     * Запрашивает у пользователя группу.
     *
     * @return \app\command\CommandResult
     * @throws \app\core\database\exception\SqlException
     */
    public function startCommandHandler(): CommandResult
    {
        $this->commandManager->getCommonUser()->setExpectedInput(GroupCommandHandler::INPUT_GROUP_NAME)->save();
        return (new CommandResult())->setMessage($this->renderTemplate('start.send_group_name'));
    }
}