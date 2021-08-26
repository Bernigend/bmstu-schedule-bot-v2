<?php

namespace app\api\common\entity;

class ScheduleLesson
{
    /** @var string */
    public string $uuid = '';

    /** @var string */
    public string $type = '';

    /** @var string */
    public string $name = '';

    /** @var string */
    public string $startAt = '';

    /** @var string */
    public string $endAt = '';

    /** @var bool */
    public bool $isNumerator = false;

    /** @var int */
    public int $day = 1;

    /** @var string */
    public string $cabinet = '';

    /** @var string */
    public string $teacher = '';

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * @param string $uuid
     *
     * @return ScheduleLesson
     */
    public function setUuid(string $uuid): ScheduleLesson
    {
        $this->uuid = $uuid;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return ScheduleLesson
     */
    public function setType(string $type): ScheduleLesson
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return ScheduleLesson
     */
    public function setName(string $name): ScheduleLesson
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getStartAt(): string
    {
        return $this->startAt;
    }

    /**
     * @param string $startAt
     *
     * @return ScheduleLesson
     */
    public function setStartAt(string $startAt): ScheduleLesson
    {
        $this->startAt = $startAt;
        return $this;
    }

    /**
     * @return string
     */
    public function getEndAt(): string
    {
        return $this->endAt;
    }

    /**
     * @param string $endAt
     *
     * @return ScheduleLesson
     */
    public function setEndAt(string $endAt): ScheduleLesson
    {
        $this->endAt = $endAt;
        return $this;
    }

    /**
     * @return bool
     */
    public function isNumerator(): bool
    {
        return $this->isNumerator;
    }

    /**
     * @param bool $isNumerator
     *
     * @return ScheduleLesson
     */
    public function setIsNumerator(bool $isNumerator): ScheduleLesson
    {
        $this->isNumerator = $isNumerator;
        return $this;
    }

    /**
     * @return int
     */
    public function getDay(): int
    {
        return $this->day;
    }

    /**
     * @param int $day
     *
     * @return ScheduleLesson
     */
    public function setDay(int $day): ScheduleLesson
    {
        $this->day = $day;
        return $this;
    }

    /**
     * @return string
     */
    public function getCabinet(): string
    {
        return $this->cabinet;
    }

    /**
     * @param string $cabinet
     *
     * @return ScheduleLesson
     */
    public function setCabinet(string $cabinet): ScheduleLesson
    {
        $this->cabinet = $cabinet;
        return $this;
    }

    /**
     * @return string
     */
    public function getTeacher(): string
    {
        return $this->teacher;
    }

    /**
     * @param string $teacher
     *
     * @return ScheduleLesson
     */
    public function setTeacher(string $teacher): ScheduleLesson
    {
        $this->teacher = $teacher;
        return $this;
    }


}