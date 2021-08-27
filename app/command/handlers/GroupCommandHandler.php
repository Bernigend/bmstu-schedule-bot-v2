<?php

namespace app\command\handlers;

use app\api\common\CommonApi;
use app\command\CommandKeyboard;
use app\command\CommandResult;

class GroupCommandHandler extends ACommandHandler
{
    /** @var string ожидание ввода названия группы */
    public const INPUT_GROUP_NAME = 'group.input_group_name';

    /** @var string команда изменения группы */
    public const CHANGE_GROUP_COMMAND = '/group';

    /** @inheritDoc */
    public function getExpectedInputHandlers(): array
    {
        return [
            static::INPUT_GROUP_NAME => [$this, 'changeUserGroupCommand'],
        ];
    }

    /** @inheritDoc */
    public function getCommandHandlers(): array
    {
        return [
            static::CHANGE_GROUP_COMMAND => [$this, 'groupCommandHandler'],
        ];
    }

    /**
     * @return \app\command\CommandResult
     * @throws \app\core\database\exception\SqlException
     */
    public function groupCommandHandler(): CommandResult
    {
        $this->commandManager->getCommonUser()->setExpectedInput(static::INPUT_GROUP_NAME)->save();
        return (new CommandResult())->setMessage($this->renderTemplate('group.send_me_group_name'));
    }

    /**
     * @return \app\command\CommandResult
     * @throws \app\core\database\exception\SqlException
     * @throws \Exception
     */
    public function changeUserGroupCommand(): CommandResult
    {
        $groupUuid = CommonApi::getGroupUuid($this->commandManager->getUserInput());
        if (empty($groupUuid)) {
            return (new CommandResult())->setError($this->renderTemplate('group.cannot_find_group'));
        }

        $this->commandManager->getCommonUser()->setCurrentGroupId($groupUuid)->setExpectedInput('')->save();
        return (new CommandResult())
            ->setMessage($this->renderTemplate('group.group_change_success'))
            ->setKeyboard(CommandKeyboard::getDefault());
    }
}