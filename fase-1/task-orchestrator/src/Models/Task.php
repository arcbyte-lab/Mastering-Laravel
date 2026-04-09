<?php

namespace App\Models;

use App\Enums\TaskStatus;

readonly class Task
{
    public function __construct(
        public int $id,
        public string $title,
        public string $description,
        public TaskStatus $status,
    ) {}
}
