<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Expense>
 */
class ExpenseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    // public function definition(): array
    // {
    //     return [
    //         'description' => fake()->words(3, false),
    //         'amount' => fake()->randomDigitNotNull(),
    //         'type' => fake()->shuffleArray(['food', 'shopping', 'entertainment', 'travel', 'other']),
    //     ];
    // }

    public function definition(): array
    {
        $array = ['food', 'shopping', 'entertainment', 'travel', 'other'];
        return [
            
            'description' => fake()->text(),
            'amount' => 100*rand(1,10),
            'type' => $array[rand(0,4)],
        ];
    }
}
