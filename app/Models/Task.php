<?php

namespace App\Models;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use Database\Factories\TaskFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static Builder<Task> pending()
 * @method static Builder<Task> completed()
 * @method static Builder<Task> overdue()
 */
class Task extends Model
{
    /** @use HasFactory<TaskFactory> */
    use HasFactory;

    protected $table = 'tasks';

    protected $fillable = ['title', 'description', 'status', 'priority', 'due_date', 'completed_at'];

    protected $casts = [
        'status' => TaskStatus::class,
        'priority' => TaskPriority::class,
        'due_date' => 'date',
        'completed_at' => 'datetime',
    ];

    /**
     * @param  Builder<Task>  $query
     * @return Builder<Task>
     */
    protected function scopePending(Builder $query): Builder
    {
        return $query->where('status', TaskStatus::PENDING->value);
    }

    /**
     * @param  Builder<Task>  $query
     * @return Builder<Task>
     */
    protected function scopeCompleted(Builder $query): Builder
    {
        return $query->where('status', TaskStatus::COMPLETED->value);
    }

    /**
     * @param  Builder<Task>  $query
     * @return Builder<Task>
     */
    protected function scopeOverdue(Builder $query): Builder
    {
        return $query->whereDate('due_date', '<', now())
            ->whereNull('completed_at');
    }
}
