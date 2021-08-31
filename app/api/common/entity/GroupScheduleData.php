<?php

namespace app\api\common\entity;

use DateTime;

class GroupScheduleData
{
    /** @var \app\api\common\entity\ScheduleLesson[] */
    public array $scheduleLessonList = [];

    /** @var string */
    public string $semesterStartAt = '';

    /** @var string */
    public string $semesterEndAt = '';

    /** @var bool */
    public bool $isNumeratorFirst = false;

    /** @var string */
    public string $groupName = '';

    /**
     * @return \DateTime
     * @throws \Exception
     */
    public function getSemesterStartAtDateTime(): DateTime
    {
        return (new DateTime($this->semesterStartAt))->setTimezone(new \DateTimeZone('+0300'));
    }

    /**
     * @return \app\api\common\entity\ScheduleLesson[]
     */
    public function getScheduleLessonList(): array
    {
        return $this->scheduleLessonList;
    }

    /**
     * @param \app\api\common\entity\ScheduleLesson[] $scheduleLessonList
     *
     * @return GroupScheduleData
     */
    public function setScheduleLessonList(array $scheduleLessonList): GroupScheduleData
    {
        $this->scheduleLessonList = $scheduleLessonList;
        return $this;
    }

    /**
     * @return string
     */
    public function getSemesterStartAt(): string
    {
        return $this->semesterStartAt;
    }

    /**
     * @param string $semesterStartAt
     *
     * @return GroupScheduleData
     */
    public function setSemesterStartAt(string $semesterStartAt): GroupScheduleData
    {
        $this->semesterStartAt = $semesterStartAt;
        return $this;
    }

    /**
     * @return string
     */
    public function getSemesterEndAt(): string
    {
        return $this->semesterEndAt;
    }

    /**
     * @param string $semesterEndAt
     *
     * @return GroupScheduleData
     */
    public function setSemesterEndAt(string $semesterEndAt): GroupScheduleData
    {
        $this->semesterEndAt = $semesterEndAt;
        return $this;
    }

    /**
     * @return bool
     */
    public function isNumeratorFirst(): bool
    {
        return $this->isNumeratorFirst;
    }

    /**
     * @param bool $isNumeratorFirst
     *
     * @return GroupScheduleData
     */
    public function setIsNumeratorFirst(bool $isNumeratorFirst): GroupScheduleData
    {
        $this->isNumeratorFirst = $isNumeratorFirst;
        return $this;
    }

    /**
     * @return string
     */
    public function getGroupName(): string
    {
        return $this->groupName;
    }

    /**
     * @param string $groupName
     *
     * @return GroupScheduleData
     */
    public function setGroupName(string $groupName): GroupScheduleData
    {
        $this->groupName = $groupName;
        return $this;
    }
}