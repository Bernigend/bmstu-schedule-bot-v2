<?php

/**
 * @var bool $isNumerator
 * @var \app\api\common\entity\GroupScheduleData $schedule
 * @var \app\command\CommandManager $commandManager
 */

$datetime = (new DateTime())->add(new DateInterval('P1D'));
$weekday = (int)$datetime->format('N');

$lessonsList = array_filter($schedule->getScheduleLessonList(), static function ($arLesson) use ($weekday, $isNumerator) {
    return $arLesson->getDay() === $weekday && $arLesson->isNumerator() === $isNumerator;
});

?>

📅 Дата: <?= $datetime->format('d.m.y') ?> (<?= $isNumerator ? 'числитель' : 'знаменатель' ?>)
Группа: <?= $schedule->getGroupName() ?>

<? if ($schedule->getSemesterStartAtDateTime()->diff(new DateTime())->days < 14) {
    echo "\n-- --\n\n";
    echo $commandManager->renderTemplate('schedule.warn.schedule_can_be_updated');
    echo "\n";
} ?>

-- --

<?= $commandManager->renderTemplate('schedule.template.schedule_day', [
    'lessonsList' => $lessonsList,
    'weekday' => $weekday,
]) ?>

-- --

Пришлите /help для подсказки