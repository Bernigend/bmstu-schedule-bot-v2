<?php

namespace app\command\handlers;

use app\command\CommandHandler;
use app\command\CommandResult;
use app\core\Application;
use app\user\CommonUser;

abstract class ACommandHandler
{
    /** @var \app\command\CommandHandler */
    protected CommandHandler $commandHandler;

    /** @var \app\user\CommonUser */
    protected CommonUser $commonUser;

    /** @var string */
    protected string $userInput;

    /** @var array|string[] */
    protected array $expectedInput = [];

    /** @var array|string[] */
    protected array $commandHandlers = [];

    /**
     * @param \app\command\CommandHandler $commandHandler
     */
    public function __construct(CommandHandler $commandHandler)
    {
        $this->commandHandler = $commandHandler;
    }

    /**
     * @param string $expectedInput
     *
     * @return string
     */
    public static function getExpectedInputType(string $expectedInput): string
    {
        return explode('.', $expectedInput)[0] ?? '';
    }

    /**
     * @param string $expectedInput
     *
     * @return string
     */
    public static function getExpectedInputKey(string $expectedInput): string
    {
        return explode('.', $expectedInput)[1] ?? '';
    }

    /**
     * @param string $userInput
     *
     * @return string
     */
    public static function getCommandFromUserInput(string $userInput): string
    {
        $userInput = preg_replace('/\s+/', ' ', $userInput);

        return explode(' ', $userInput)[0];
    }

    /**
     * @param \app\user\CommonUser $commonUser
     * @param string $userInput
     *
     * @return \app\command\CommandResult
     */
    public function run(CommonUser $commonUser, string $userInput): CommandResult
    {
        $this->commonUser = $commonUser;
        $this->userInput = $userInput;

        return $this->proxyRun();
    }

    /**
     * @param string $templateName
     * @param array $vars
     *
     * @return string
     */
    protected function renderTemplate(string $templateName, array $vars = []): string
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
        ]);
        extract($vars);

        ob_start();
        include $templatePath;

        return ob_get_clean();
    }

    /**
     * @return \app\command\CommandResult
     * @throws \app\core\database\exception\SqlException
     */
    protected function defaultRun(): CommandResult
    {
        $expectedInput = static::getExpectedInputKey($this->commonUser->getExpectedInput());
        if (!empty($expectedInput)) {
            if (!isset($this->expectedInput[$expectedInput])) {
                $this->commonUser->setExpectedInput('')->save();

                return (new CommandResult())->setError(
                    $this->renderTemplate('main.error.not_found_expected_handler')
                );
            }

            return $this->{$this->expectedInput[$expectedInput]}();
        }

        $inputCommand = static::getCommandFromUserInput($this->userInput);
        if (!empty($this->commandHandlers[$inputCommand])) {
            return $this->{$this->commandHandlers[$inputCommand]}();
        }

        return (new CommandResult())->setError($this->renderTemplate('main.error.undefined_command'));
    }

    /**
     * @return \app\command\CommandResult
     * @throws \Exception
     */
    abstract protected function proxyRun(): CommandResult;
}