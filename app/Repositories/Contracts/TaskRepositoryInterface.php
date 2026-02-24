<?php

namespace App\Repositories\Contracts;

use App\DTOs\TaskData;
use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

interface TaskRepositoryInterface
{
    /**
     * @return Collection<int, Task>
     */
    public function all(): Collection;

    public function find(int $id): ?Task;

    public function create(TaskData $data): Task;

    public function update(int $id, TaskData $data): Task;

    public function delete(int $id): bool;

    /**
     * @return Collection<int, Task>
     */
    public function pending(): Collection;

    /**
     * @return Collection<int, Task>
     */
    public function complete(): Collection;

    /**
     * @return Collection<int, Task>
     */
    public function overdue(): Collection;
}
