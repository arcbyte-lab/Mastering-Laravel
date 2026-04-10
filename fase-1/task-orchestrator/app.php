<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Models\Task;
use App\Enums\TaskStatus;
use App\Repositories\JsonTaskRepository;
use App\Contracts\TaskRepositoryInterface;

function renderTasks(TaskRepositoryInterface $repository): void
{
    $tasks = $repository->getAll();

    foreach ($tasks as $task) {
        echo "Tugas: " . $task->title . PHP_EOL;
        echo "Status: " . $task->status->getLabel() . PHP_EOL;
        echo "------------------" . PHP_EOL;
    }
}

$repository = new JsonTaskRepository(__DIR__ . '/tasks.json');

$repository->save(new Task(1, "Belajar PHP Modern", "Memahami Enum dan Property Promotion", TaskStatus::IN_PROGRESS));
$repository->save(new Task(2, "Belajar Interface", "Latihan Milestone 2", TaskStatus::IN_PROGRESS));
$repository->save(new Task(3, "Review Code", "Mengecek standarisasi PSR", TaskStatus::PENDING));

renderTasks($repository);