<?php

namespace app\command\handlers;

use app\command\CommandResult;

class HelpCommandHandler extends ACommandHandler
{
    /** @var string команда вывода справки */
    public const HELP_COMMAND = '/help';

    /** @inheritDoc */
    public function getExpectedInputHandlers(): array
    {
        return [];
    }

    /** @inheritDoc */
    public function getCommandHandlers(): array
    {
        return [
            static::HELP_COMMAND => [$this, 'sendHelpInformation'],
        ];
    }

    /**
     * @return \app\command\CommandResult
     */
    public function sendHelpInformation(): CommandResult
    {
        return (new CommandResult())->setMessage($this->renderTemplate('help.help'));
    }
}