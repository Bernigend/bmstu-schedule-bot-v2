<?php

namespace app\api\common;

use app\api\bitop\BitopApi;
use app\api\common\entity\GroupScheduleData;

class CommonApi
{
    /**
     * @param string $groupName
     *
     * @return string
     * @throws \Exception
     */
    public static function getGroupUuid(string $groupName): string
    {
        return BitopApi::getInstance()->getGroupUuid($groupName);
    }

    /**
     * @param string $groupId
     *
     * @return \app\api\common\entity\GroupScheduleData
     * @throws \Exception
     */
    public static function getScheduleForGroup(string $groupId): GroupScheduleData
    {
        return BitopApi::getInstance()->getSchedule($groupId);
    }
}