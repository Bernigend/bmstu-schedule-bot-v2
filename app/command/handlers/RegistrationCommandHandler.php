<?php

namespace app\command\handlers;

use app\command\CommandResult;
use app\user\CommonUser;

class RegistrationCommandHandler extends ACommandHandler
{
    /** @var string */
    public const EXPECTED_INPUT_REGISTRATION = 'start.registration';

    protected function proxyRun(): CommandResult
    {
        $this->commonUser->setExpectedInput(GroupCommandHandler::EXPECTED_INPUT_GROUP_NAME)->save();
        return (new CommandResult())->setMessage($this->renderTemplate('start.registration'));
    }
}