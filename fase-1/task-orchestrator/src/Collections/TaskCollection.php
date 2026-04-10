<?php

namespace App\Collections;

use App\Models\Task;

class TaskCollection
{
    private array $tasks = [];

    public function __construct(array $tasks = [])
    {
        $this->tasks = $tasks;
    }

    public function add(Task $task): void
    {
        $this->tasks[] = $task;
    }

    public function all(): array
    {
        return $this->tasks;
    }
}