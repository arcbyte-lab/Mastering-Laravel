<?php

namespace App\Contracts;

use App\Models\Task;

interface TaskRepositoryInterface
{
    public function save(Task $task): void;
    public function getAll(): array;
}