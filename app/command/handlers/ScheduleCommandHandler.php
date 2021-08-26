<?php

namespace app\command\handlers;

use app\api\common\CommonApi;
use app\api\common\entity\GroupScheduleData;
use app\command\CommandResult;

class ScheduleCommandHandler extends ACommandHandler
{
    /** @inheritdoc */
    protected array $commandHandlers = [
        '/today' => 'loadScheduleForTodayCommand',
        '/tomorrow' => 'loadScheduleForTomorrowCommand',
        '/week' => 'loadScheduleForWeekCommand',
        '/nextweek' => 'loadScheduleForNextWeekCommand',
    ];

    /** @inheritDoc */
    protected function proxyRun(): CommandResult
    {
        return $this->defaultRun();
    }

    /**
     * @return \app\command\CommandResult
     * @throws \app\core\database\exception\SqlException
     */
    protected function loadScheduleForTodayCommand(): CommandResult
    {
        return $this->renderScheduleTemplate('schedule.today', [$this, 'getTodayIsNumerator']);
    }

    /**
     * @return \app\command\CommandResult
     * @throws \app\core\database\exception\SqlException
     */
    protected function loadScheduleForTomorrowCommand(): CommandResult
    {
        return $this->renderScheduleTemplate('schedule.tomorrow', [$this, 'getTomorrowIsNumerator']);
    }

    /**
     * @return \app\command\CommandResult
     * @throws \app\core\database\exception\SqlException
     */
    protected function loadScheduleForWeekCommand(): CommandResult
    {
        return $this->renderScheduleTemplate('schedule.week', [$this, 'getCurrentWeekIsNumerator']);
    }

    /**
     * @return \app\command\CommandResult
     * @throws \app\core\database\exception\SqlException
     */
    protected function loadScheduleForNextWeekCommand(): CommandResult
    {
        return $this->renderScheduleTemplate('schedule.next_week', [$this, 'getNextWeekIsNumerator']);
    }

    /**
     * @param string $template
     * @param callable $numeratorCheck
     *
     * @return \app\command\CommandResult
     * @throws \app\core\database\exception\SqlException
     */
    protected function renderScheduleTemplate(string $template, callable $numeratorCheck): CommandResult
    {
        if (empty($this->commonUser->getCurrentGroupId())) {
            $this->commonUser->setExpectedInput(GroupCommandHandler::EXPECTED_INPUT_GROUP_NAME)->save();

            return (new CommandResult())->setError($this->renderTemplate('main.error.group_is_required'));
        }

        $schedule = CommonApi::getScheduleForGroup($this->commonUser->getCurrentGroupId());

        return (new CommandResult())->setMessage($this->renderTemplate($template, [
            'isNumerator' => call_user_func($numeratorCheck, $schedule),
            'schedule' => $schedule,
        ]));
    }

    /**
     * @param \app\api\common\entity\GroupScheduleData $scheduleData
     *
     * @return bool
     * @throws \Exception
     */
    protected function getTodayIsNumerator(GroupScheduleData $scheduleData): bool
    {
        return $this->getWeekIsNumerator($scheduleData, (new \DateTime())->format('W'));
    }

    /**
     * @param \app\api\common\entity\GroupScheduleData $scheduleData
     *
     * @return bool
     * @throws \Exception
     */
    protected function getTomorrowIsNumerator(GroupScheduleData $scheduleData): bool
    {
        return $this->getWeekIsNumerator($scheduleData, (new \DateTime())->add(new \DateInterval('P1D'))->format('W'));
    }

    /**
     * @param \app\api\common\entity\GroupScheduleData $scheduleData
     *
     * @return bool
     * @throws \Exception
     */
    protected function getCurrentWeekIsNumerator(GroupScheduleData $scheduleData): bool
    {
        return $this->getWeekIsNumerator($scheduleData);
    }

    /**
     * @param \app\api\common\entity\GroupScheduleData $scheduleData
     *
     * @return bool
     * @throws \Exception
     */
    protected function getNextWeekIsNumerator(GroupScheduleData $scheduleData): bool
    {
        return $this->getWeekIsNumerator($scheduleData, (new \DateTime())->add(new \DateInterval('P1W'))->format('W'));
    }

    /**
     * Определяет нумератор или нет неделя.
     *
     * @param \app\api\common\entity\GroupScheduleData $scheduleData
     * @param int|null $currentWeekNumber
     *
     * @return bool
     * @throws \Exception
     */
    protected function getWeekIsNumerator(GroupScheduleData $scheduleData, int $currentWeekNumber = null): bool
    {
        $semesterStartWeek = (new \DateTime($scheduleData->getSemesterStartAt()))->format('W');

        if (is_null($currentWeekNumber)) {
            $currentWeekNumber = (new \DateTime())->format('W');
        }

        $weekDifference = abs(($currentWeekNumber - $semesterStartWeek) % 2);

        if ($weekDifference === 0 && $scheduleData->isNumeratorFirst()) {
            return true;
        }

        if ($weekDifference === 1 && !$scheduleData->isNumeratorFirst()) {
            return true;
        }

        return false;
    }
}