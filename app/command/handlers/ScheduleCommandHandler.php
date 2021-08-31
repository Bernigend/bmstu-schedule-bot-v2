<?php

namespace app\command\handlers;

use app\api\common\CommonApi;
use app\api\common\entity\GroupScheduleData;
use app\command\CommandKeyboard;
use app\command\CommandResult;
use DateInterval;
use DateTime;
use DateTimeZone;

class ScheduleCommandHandler extends ACommandHandler
{
    /** @var string команда расписания на сегодня */
    public const TODAY_COMMAND = '/today';

    /** @var string команда расписания на завтра */
    public const TOMORROW_COMMAND = '/tomorrow';

    /** @var string команда расписания на неделю */
    public const WEEK_COMMAND = '/week';

    /** @var string команда расписания на следующую неделю */
    public const NEXT_WEEK_COMMAND = '/nextweek';

    /**
     * @inheritDoc
     */
    public function getExpectedInputHandlers(): array
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function getCommandHandlers(): array
    {
        return [
            static::TODAY_COMMAND => [$this, 'loadScheduleForTodayCommand'],
            static::TOMORROW_COMMAND => [$this, 'loadScheduleForTomorrowCommand'],
            static::WEEK_COMMAND => [$this, 'loadScheduleForWeekCommand'],
            static::NEXT_WEEK_COMMAND => [$this, 'loadScheduleForNextWeekCommand'],
        ];
    }

    /**
     * @return \app\command\CommandResult
     * @throws \app\core\database\exception\SqlException
     */
    public function loadScheduleForTodayCommand(): CommandResult
    {
        return $this->renderScheduleTemplate('schedule.today', [$this, 'getTodayIsNumerator']);
    }

    /**
     * @return \app\command\CommandResult
     * @throws \app\core\database\exception\SqlException
     */
    public function loadScheduleForTomorrowCommand(): CommandResult
    {
        return $this->renderScheduleTemplate('schedule.tomorrow', [$this, 'getTomorrowIsNumerator']);
    }

    /**
     * @return \app\command\CommandResult
     * @throws \app\core\database\exception\SqlException
     */
    public function loadScheduleForWeekCommand(): CommandResult
    {
        return $this->renderScheduleTemplate('schedule.week', [$this, 'getCurrentWeekIsNumerator']);
    }

    /**
     * @return \app\command\CommandResult
     * @throws \app\core\database\exception\SqlException
     */
    public function loadScheduleForNextWeekCommand(): CommandResult
    {
        return $this->renderScheduleTemplate('schedule.next_week', [$this, 'getNextWeekIsNumerator']);
    }

    /**
     * @param string $template
     * @param callable $numeratorCheck
     *
     * @return \app\command\CommandResult
     * @throws \app\core\database\exception\SqlException
     * @throws \Exception
     */
    protected function renderScheduleTemplate(string $template, callable $numeratorCheck): CommandResult
    {
        if (empty($this->commandManager->getCommonUser()->getCurrentGroupId())) {
            $this->commandManager->getCommonUser()->setExpectedInput(GroupCommandHandler::INPUT_GROUP_NAME)->save();

            return (new CommandResult())->setError($this->renderTemplate('main.error.group_is_required'));
        }

        $schedule = CommonApi::getScheduleForGroup($this->commandManager->getCommonUser()->getCurrentGroupId());

        return (new CommandResult())->setMessage($this->renderTemplate($template, [
            'isNumerator' => call_user_func($numeratorCheck, $schedule),
            'schedule' => $schedule,
        ]))->setKeyboard(CommandKeyboard::getDefault());
    }

    /**
     * @param \app\api\common\entity\GroupScheduleData $scheduleData
     *
     * @return bool
     * @throws \Exception
     */
    protected function getTodayIsNumerator(GroupScheduleData $scheduleData): bool
    {
        return $this->getWeekIsNumerator($scheduleData, new DateTime());
    }

    /**
     * @param \app\api\common\entity\GroupScheduleData $scheduleData
     *
     * @return bool
     * @throws \Exception
     */
    protected function getTomorrowIsNumerator(GroupScheduleData $scheduleData): bool
    {
        return $this->getWeekIsNumerator($scheduleData, (new DateTime())->add(new DateInterval('P1D')));
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
        return $this->getWeekIsNumerator($scheduleData, (new DateTime())->add(new DateInterval('P1W')));
    }

    /**
     * Определяет нумератор или нет неделя.
     *
     * @param \app\api\common\entity\GroupScheduleData $scheduleData
     * @param \DateTime|null $localDateTime
     *
     * @return bool
     * @throws \Exception
     */
    protected function getWeekIsNumerator(GroupScheduleData $scheduleData, ?DateTime $localDateTime = null): bool
    {
        $apiDateTime = $scheduleData->getSemesterStartAtDateTime();
        $localDateTime = ($localDateTime ?? (new DateTime()))->setTimezone($apiDateTime->getTimezone());

        $weekDifference = abs($apiDateTime->format('W') - $localDateTime->format('W')) % 2;

        if ($weekDifference === 0) {
            return $scheduleData->isNumeratorFirst();
        }

        return !$scheduleData->isNumeratorFirst();
    }
}
