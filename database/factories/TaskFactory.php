<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TaskFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => Str::title(fake()->words(rand(2, 4), true)),
            'description' => fake()->text(),
        ];
    }
}
