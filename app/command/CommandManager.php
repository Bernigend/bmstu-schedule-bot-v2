<?php

namespace app\command;

use app\command\handlers\ACommandHandler;
use app\command\handlers\GroupCommandHandler;
use app\command\handlers\HelpCommandHandler;
use app\command\handlers\RegistrationCommandHandler;
use app\command\handlers\ScheduleCommandHandler;
use app\core\Application;
use app\user\CommonUser;
use Throwable;

class CommandManager
{
    /** @var class-string<ACommandHandler>[] */
    protected static array $commandClasses = [
        RegistrationCommandHandler::class,
        HelpCommandHandler::class,
        GroupCommandHandler::class,
        ScheduleCommandHandler::class,
    ];

    /** @var array<string, callable> */
    protected array $expectedInputHandlers = [];

    /** @var array<string, callable> */
    protected array $commandHandlers = [];

    /** @var \app\user\CommonUser */
    protected CommonUser $commonUser;

    /** @var string */
    protected string $userInput;

    /**
     * @param \app\user\CommonUser $commonUser
     * @param string $userInput
     */
    public function __construct(CommonUser $commonUser, string $userInput)
    {
        $this->commonUser = $commonUser;

        $userInput = preg_replace('/\s+/', ' ', $userInput);
        $this->userInput = trim($userInput);

        foreach (static::$commandClasses as $commandClass) {
            /** @var ACommandHandler $handlerInstance */
            $handlerInstance = new $commandClass($this);

            $this->expectedInputHandlers = array_merge(
                $this->expectedInputHandlers,
                $handlerInstance->getExpectedInputHandlers()
            );

            $this->commandHandlers = array_merge(
                $this->commandHandlers,
                $handlerInstance->getCommandHandlers()
            );
        }
    }

    /**
     * @return \app\command\CommandResult
     * @throws \Exception
     */
    public function handle(): CommandResult
    {
        try {
            if (!empty($this->commonUser->getExpectedInput())) {
                return $this->handleByExpectedInput();
            }

            return $this->handleByUserInput();
        } catch (Throwable $e) {
            Application::getInstance()->getLogger()->exception($e);
            \Sentry\captureException($e);
            return (new CommandResult())->setError("Произошла какая-то ошибка, попробуйте ещё. \n Пришлите /help для справки");
        }
    }

    /**
     * Запускает обработчик команды по ожидаемому вводу от пользователя.
     *
     * @return CommandResult
     * @throws \Exception
     */
    protected function handleByExpectedInput(): CommandResult
    {
        if (!isset($this->expectedInputHandlers[$this->commonUser->getExpectedInput()])) {
            $this->commonUser->setExpectedInput('');

            return (new CommandResult())->setError($this->renderTemplate('main.error.not_found_expected_handler'));
        }

        return call_user_func($this->expectedInputHandlers[$this->commonUser->getExpectedInput()]);
    }

    /**
     * Запускает обработчик команды по вводу пользователя.
     *
     * @return \app\command\CommandResult
     */
    protected function handleByUserInput(): CommandResult
    {
        $userCommand = static::getCommandFromUserInput($this->userInput);

        if (!isset($this->commandHandlers[$userCommand])) {
            return (new CommandResult())->setMessage('');
        }

        return call_user_func($this->commandHandlers[$userCommand]);
    }

    /**
     * @param string $userInput
     *
     * @return string
     */
    public static function getCommandFromUserInput(string $userInput): string
    {
        return explode(' ', $userInput)[0];
    }

    /**
     * @param string $templateName
     * @param array $vars
     *
     * @return string
     */
    public function renderTemplate(string $templateName, array $vars = []): string
    {
        $templatesDir = implode(DIRECTORY_SEPARATOR, [
            Application::getInstance()->getAbsRootDirectory(),
            'templates',
            $this->commonUser->getNamespace()
        ]);

        $templatePath = $templatesDir .DIRECTORY_SEPARATOR . $templateName . '.php';

        if (!is_readable($templatePath)) {
            return '';
        }

        $vars = array_merge($vars, [
            'commonUser' => $this->commonUser,
            'userInput' => $this->userInput,
            'commandManager' => $this,
        ]);
        extract($vars);

        ob_start();
        include $templatePath;

        return ob_get_clean();
    }

    /**
     * @return \app\user\CommonUser
     */
    public function getCommonUser(): CommonUser
    {
        return $this->commonUser;
    }

    /**
     * @return string
     */
    public function getUserInput(): string
    {
        return $this->userInput;
    }

    /**
     * Эмулирует ввод пользователя, запуская выполнение команды.
     *
     * @param string $userInput
     *
     * @return \app\command\CommandResult
     * @throws \Exception
     */
    public function emulateUserInput(string $userInput): CommandResult
    {
        $this->userInput = $userInput;

        return $this->handle();
    }
}