<?php

namespace Database\Factories;

use App\Enums\ReportCategory;
use App\Enums\ReportStatus;
use App\Enums\ReportType;
use App\Models\Report;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Report>
 */
class ReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'type' => fake()->randomElement(ReportType::cases()),
            'category' => fake()->randomElement(ReportCategory::cases()),
            'title' => fake()->sentence(4),
            'description' => fake()->paragraph(),
            'location' => fake()->city(),
            'happened_at' => fake()->dateTimeBetween('-1 month'),
            'status' => ReportStatus::Open,
        ];
    }
}
