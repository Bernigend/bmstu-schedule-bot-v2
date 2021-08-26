<?php

namespace app\command\handlers;

use app\command\CommandResult;

class HelpCommandHandler extends ACommandHandler
{
    /** @inheritDoc */
    protected function proxyRun(): CommandResult
    {
        return (new CommandResult())->setMessage($this->renderTemplate('help.help'));
    }
}