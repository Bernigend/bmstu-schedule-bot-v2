<?php

/**
 * @var bool $isNumerator
 * @var \app\api\common\entity\GroupScheduleData $schedule
 */

$today = (int)date('N');

$lessonsList = array_filter($schedule->getScheduleLessonList(), static function ($arLesson) use ($today, $isNumerator) {
    return $arLesson->getDay() === $today && $arLesson->isNumerator() === $isNumerator;
});

?>

📅 Дата: <?= date('d.m.y') ?> (<?= $isNumerator ? 'числитель' : 'знаменатель' ?>)
Группа: <?= $schedule->getGroupName() ?>

—— ——

<?php
foreach ($lessonsList as $lesson) {
    echo "[{$lesson->getStartAt()} - {$lesson->getEndAt()}]\n";
    echo "- {$lesson->getName()}";
    echo !empty($lesson->getType()) ? " ({$lesson->getType()})" : '';
    echo "\n";
    echo !empty($lesson->getTeacher()) ? "- {$lesson->getTeacher()}\n" : '';
    echo !empty($lesson->getCabinet()) ? "- {$lesson->getCabinet()}\n" : '';
}
?>

—— ——

Пришлите /help для подсказки