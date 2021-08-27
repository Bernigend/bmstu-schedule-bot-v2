<?php

namespace app\api\bitop;

use app\api\common\entity\GroupScheduleData;
use app\api\common\entity\ScheduleLesson;
use app\core\Application;
use GuzzleHttp\Client;
use Swagger\Client\Api\ScheduleApi;
use Swagger\Client\Api\SearchApi;
use Swagger\Client\Configuration;
use Swagger\Client\Model\SearchUnitRequest;

class BitopApi
{
    /** @var \app\api\bitop\BitopApi|null */
    protected static ?self $instance = null;

    /** @var \Swagger\Client\Configuration */
    protected Configuration $swaggerConfig;

    /**
     * @return static
     */
    public static function getInstance(): self
    {
        if (is_null(static::$instance)) {
            static::$instance = new static();
            static::$instance->init();
        }

        return static::$instance;
    }

    /**
     * Инициализирует swagger API.
     */
    protected function init(): void
    {
        $env = Application::getInstance()->getEnvironment();

        $this->swaggerConfig =
            \Swagger\Client\Configuration::getDefaultConfiguration()
                ->setApiKey('x-bb-token', $env->getBitopAccessToken());
    }

    /**
     * Возвращает UUID группы по её имени.
     *
     * @param string $groupName
     *
     * @return string
     * @throws \Swagger\Client\ApiException
     */
    public function getGroupUuid(string $groupName): string
    {
        $apiInstance = new SearchApi(new Client(), $this->swaggerConfig);
        $payload = (new SearchUnitRequest())->setType('group')->setQuery($groupName);

        $apiResponse = $apiInstance->searchUnitPost($payload);
        if ($apiResponse->getTotal() !== 1) {
            return '';
        }

        return $apiResponse->getItems()[0]->getUuid();
    }

    /**
     * @param string $groupUuid
     *
     * @return \app\api\common\entity\GroupScheduleData
     * @throws \Swagger\Client\ApiException
     */
    public function getSchedule(string $groupUuid): GroupScheduleData
    {
        $apiInstance = new ScheduleApi(new Client(), $this->swaggerConfig);
        $schedule = $apiInstance->scheduleUuidGet($groupUuid);

        $internalSchedule = (new GroupScheduleData())
            ->setSemesterStartAt($schedule->getSemesterStart())
            ->setSemesterEndAt($schedule->getSemesterEnd())
            ->setIsNumeratorFirst($schedule->getIsNumeratorFirst())
            ->setGroupName($schedule->getGroup()->getName())
        ;

        $scheduleLessonsList = [];
        foreach ($schedule->getLessons() as $lesson) {
            $scheduleLessonsList[] = (new ScheduleLesson())
                ->setType($lesson->getType())
                ->setName($lesson->getName())
                ->setCabinet($lesson->getCabinet())
                ->setDay($lesson->getDay())
                ->setEndAt($lesson->getEndAt())
                ->setStartAt($lesson->getStartAt())
                ->setIsNumerator($lesson->getIsNumerator())
                ->setUuid($lesson->getUuid())
                ->setTeacher(!empty($lesson->getTeachers()[0]) ? $lesson->getTeachers()[0]->getName() : '')
            ;
        }

        usort($scheduleLessonsList, static function ($left, $right) {
            /**
             * @var \app\api\common\entity\ScheduleLesson $left
             * @var \app\api\common\entity\ScheduleLesson $right
             */

            $leftSortKey = $left->getDay() . $left->getStartAt();
            $rightSortKey = $right->getDay() . $right->getStartAt();

            if ($leftSortKey === $rightSortKey) {
                return 0;
            }

            return $leftSortKey < $rightSortKey ? -1 : 1;
        });

        return $internalSchedule->setScheduleLessonList($scheduleLessonsList);
    }

    final protected function __construct()
    {
    }

    final public function __clone()
    {
    }

    final public function __wakeup()
    {
    }
}