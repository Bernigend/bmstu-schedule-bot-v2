<?php

namespace app\command;

use app\command\handlers\ACommandHandler;
use app\command\handlers\GroupCommandHandler;
use app\command\handlers\HelpCommandHandler;
use app\command\handlers\RegistrationCommandHandler;
use app\command\handlers\ScheduleCommandHandler;
use app\user\CommonUser;

class CommandHandler
{
    /** @var array<string, class-string<\app\command\handlers\ACommandHandler>> */
    protected array $expectedInputHandlers = [
        'start' => RegistrationCommandHandler::class,
        'group' => GroupCommandHandler::class,
    ];

    /** @var array<string, class-string<\app\command\handlers\ACommandHandler>> */
    protected array $commandHandlers = [
        '/help' => HelpCommandHandler::class,

        '/group' => GroupCommandHandler::class,

        '/today' => ScheduleCommandHandler::class,
        '/tomorrow' => ScheduleCommandHandler::class,
        '/week' => ScheduleCommandHandler::class,
        '/nextweek' => ScheduleCommandHandler::class,
    ];

    /**
     * @param \app\user\CommonUser $commonUser
     * @param string $userInput
     *
     * @return \app\command\CommandResult
     * @throws \Exception
     */
    public function handle(CommonUser $commonUser, string $userInput): CommandResult
    {
        if (!empty($commonUser->getExpectedInput())) {
            return $this->handleByExpectedInput($commonUser, $userInput);
        }

        return $this->handleByUserInput($commonUser, $userInput);
    }

    /**
     * Запускает обработчик команды по ожидаемому вводу от пользователя.
     *
     * @param CommonUser $commonUser
     * @param string $userInput
     *
     * @return CommandResult
     * @throws \Exception
     */
    protected function handleByExpectedInput(CommonUser $commonUser, string $userInput): CommandResult
    {
        $inputHandlerType = ACommandHandler::getExpectedInputType($commonUser->getExpectedInput());

        if (!isset($this->expectedInputHandlers[$inputHandlerType])) {
            $commonUser->setExpectedInput('');

            return (new CommandResult())->setError("Извини, я ждал от тебя сообщение, но теперь не понимаю зачем... Попробуй написать ещё что-нибудь, или пришли /help для вывода списка команд");
        }

        return (new $this->expectedInputHandlers[$inputHandlerType]($this))->run($commonUser, $userInput);
    }

    /**
     * Запускает обработчик команды по вводу пользователя.
     *
     * @param \app\user\CommonUser $commonUser
     * @param string $userInput
     *
     * @return \app\command\CommandResult
     */
    protected function handleByUserInput(CommonUser $commonUser, string $userInput): CommandResult
    {
        $userCommand = ACommandHandler::getCommandFromUserInput($userInput);

        if (!isset($this->commandHandlers[$userCommand])) {
            return (new CommandResult())->setError("Извини, но я не знаю как ответить на твоё сообщение...");
        }

        return (new $this->commandHandlers[$userCommand]($this))->run($commonUser, $userInput);
    }
}