<?php

/**
 * @var bool $isNumerator
 * @var \app\api\common\entity\GroupScheduleData $schedule
 * @var \app\command\CommandManager $commandManager
 */

$weekdayStart = new DateTime("next monday");
$weekdayEnd = new DateTime("last sunday of next week");

?>

📅 Дата: <?= $weekdayStart->format('d.m.Y') ?> - <?= $weekdayEnd->format('d.m.Y') ?> (<?= $isNumerator ? 'числитель' : 'знаменатель' ?>)
Группа: <?= $schedule->getGroupName() ?>

<? for ($i = 1; $i < 7; $i++) {
    echo "-- -- \n\n";
    echo $commandManager->renderTemplate('schedule.template.schedule_day', [
        'isNumerator' => $isNumerator,
        'lessonsList' => array_filter($schedule->getScheduleLessonList(), static function ($arLesson) use ($isNumerator, $i) {
            return (int)$arLesson->getDay() === $i && $arLesson->isNumerator() === $isNumerator;
        }),
        'weekday' => $i,
    ]);
} ?>

-- --

Пришлите /help для подсказки
