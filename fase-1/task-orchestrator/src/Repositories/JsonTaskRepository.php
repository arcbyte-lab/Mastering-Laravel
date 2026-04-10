<?php

namespace App\Repositories;

use App\Contracts\TaskRepositoryInterface;
use App\Models\Task;
use App\Enums\TaskStatus;

class JsonTaskRepository implements TaskRepositoryInterface
{
    private string $filePath;

    public function __construct(string $filePath = __DIR__ . '/../../tasks.json')
    {
        $this->filePath = $filePath;

        if (!file_exists($this->filePath)) {
            file_put_contents($this->filePath, json_encode([]));
        }
    }

    public function save(Task $task): void
    {
        $tasks = $this->getAll();

        $tasks[$task->id] = $task;

        file_put_contents($this->filePath, json_encode($tasks, JSON_PRETTY_PRINT));
    }

    public function getAll(): array
    {
        if (!file_exists($this->filePath)) {
            return [];
        }
        $raw = json_decode(file_get_contents($this->filePath), true);

        $task_collection = [];
        foreach ($raw as $task) {
            $task_collection[$task['id']] = new Task($task['id'], $task['title'], $task['description'], TaskStatus::from($task['status']));
        }

        return $task_collection;
    }
}