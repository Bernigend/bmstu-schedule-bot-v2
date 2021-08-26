<?php

namespace app\command\handlers;

use app\api\common\CommonApi;
use app\command\CommandResult;

class GroupCommandHandler extends ACommandHandler
{
    /** @var string */
    public const EXPECTED_INPUT_GROUP_NAME = 'group.input_group_name';

    /** @var array|string[] */
    protected array $expectedInput = [
        'input_group_name' => 'changeUserGroupCommand',
    ];

    /** @var array|string[] */
    protected array $commandHandlers = [
        '/group' => 'startGroupChangingCommand',
    ];

    /**
     * @return \app\command\CommandResult
     * @throws \app\core\database\exception\SqlException
     */
    public function proxyRun(): CommandResult
    {
        return $this->defaultRun();
    }

    /**
     * @return \app\command\CommandResult
     * @throws \app\core\database\exception\SqlException
     * @throws \Exception
     */
    protected function changeUserGroupCommand(): CommandResult
    {
        $groupUuid = CommonApi::getGroupUuid($this->userInput);
        if (empty($groupUuid)) {
            return (new CommandResult())->setError($this->renderTemplate('group.cannot_find_group'));
        }

        $this->commonUser->setCurrentGroupId($groupUuid)->setExpectedInput('')->save();

        return (new CommandResult())->setMessage($this->renderTemplate('group.group_change_success'));
    }

    /**
     * @return \app\command\CommandResult
     * @throws \app\core\database\exception\SqlException
     */
    protected function startGroupChangingCommand(): CommandResult
    {
        $this->commonUser->setExpectedInput(static::EXPECTED_INPUT_GROUP_NAME)->save();

        return (new CommandResult())->setMessage($this->renderTemplate('group.send_me_group_name'));
    }
}