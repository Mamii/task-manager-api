<?php

namespace App\Repositories;

use App\DTOs\TaskData;
use App\Models\Task;
use App\Repositories\Contracts\TaskRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class EloquentTaskRepository implements TaskRepositoryInterface
{
    /**
     * @return Collection<int, Task>
     */
    public function all(): Collection
    {
        return Task::all();
    }

    public function find(int $id): ?Task
    {
        return Task::find($id);
    }

    public function create(TaskData $data): Task
    {
        return Task::create($data->toArray());
    }

    public function update(int $id, TaskData $data): Task
    {
        $task = Task::findOrFail($id);
        $task->update($data->toArray());

        return $task;
    }

    public function delete(int $id): bool
    {
        return (bool) Task::destroy($id);
    }

    /**
     * @return Collection<int, Task>
     */
    public function pending(): Collection
    {
        return Task::pending()->get();
    }

    /**
     * @return Collection<int, Task>
     */
    public function complete(): Collection
    {
        return Task::completed()->get();
    }

    /**
     * @return Collection<int, Task>
     */
    public function overdue(): Collection
    {
        return Task::overdue()->get();
    }
}
