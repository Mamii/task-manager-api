<?php

namespace App\DTOs;

readonly class TaskData
{
    public function __construct(
        public ?string $title = null,
        public ?string $description = null,
        public ?string $status = null,
        public ?string $priority = null,
        public ?string $due_date = null,
        public ?string $completed_at = null,
    ) {}

    /**
     * @return array<string, string|null>
     */
    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'priority' => $this->priority,
            'due_date' => $this->due_date,
            'completed_at' => $this->completed_at,
        ];
    }

    /**
     * @param array{title?: string, description?: string|null, status?: string, priority?: string, due_date?: string|null, completed_at?: string|null} $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            title: $data['title'] ?? null,
            description: $data['description'] ?? null,
            status: $data['status'] ?? null,
            priority: $data['priority'] ?? null,
            due_date: $data['due_date'] ?? null,
            completed_at: $data['completed_at'] ?? null,
        );
    }
}
