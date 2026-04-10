<?php

namespace App\Repositories;

use App\Contracts\TaskRepositoryInterface;
use App\Models\Task;

class InMemoryTaskRepository implements TaskRepositoryInterface
{
    private array $tasks = [];

    public function save(Task $task): void
    {
        $this->tasks[$task->id] = $task;
    }

    public function getAll(): array
    {
        return $this->tasks;
    }
}
