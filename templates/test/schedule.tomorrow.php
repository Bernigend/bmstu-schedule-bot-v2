<?php

/**
 * @var bool $isNumerator
 * @var \app\api\common\entity\GroupScheduleData $schedule
 */

$datetime = (new DateTime())->add(new DateInterval('P1D'));
$today = (int)$datetime->format('N');

$lessonsList = array_filter($schedule->getScheduleLessonList(), static function ($arLesson) use ($today, $isNumerator) {
    return $arLesson->getDay() === $today && $arLesson->isNumerator() === $isNumerator;
});

?>

📅 Дата: <?= $datetime->format('d.m.y') ?> (<?= $isNumerator ? 'числитель' : 'знаменатель' ?>)
Группа: <?= $schedule->getGroupName() ?>

—— ——

<?php
foreach ($lessonsList as $lesson) {
    echo "[{$lesson->getStartAt()} - {$lesson->getEndAt()}]\n";
    echo "- {$lesson->getName()}\n";
    echo !empty($lesson->getTeacher()) ? "- {$lesson->getTeacher()}\n" : '';
}
?>

—— ——

Пришлите /help для подсказки