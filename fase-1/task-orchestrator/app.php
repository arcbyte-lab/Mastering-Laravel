<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Models\Task;
use App\Enums\TaskStatus;

$myTask = new Task(
    id: 1,
    title: "Belajar PHP Modern",
    description: "Memahami Enum dan Property Promotion",
    status: TaskStatus::IN_PROGRESS,
);

echo "Tugas: " . $myTask->title . PHP_EOL;
echo "Status: " . $myTask->status->getLabel() . PHP_EOL;
