<?php

/**
 * @var \app\api\common\entity\ScheduleLesson[] $lessonsList
 * @var string|int $weekday
 */

$dayName = [
    '1' => 'Понедельник',
    '2' => 'Вторник',
    '3' => 'Среда',
    '4' => 'Четверг',
    '5' => 'Пятница',
    '6' => 'Суббота',
    '7' => 'Воскресенье',
][(string)$weekday];
?>
📌 <?= $dayName ?>

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