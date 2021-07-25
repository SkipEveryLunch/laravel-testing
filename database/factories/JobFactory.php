<?php

namespace Database\Factories;

use App\Models\Job;
use App\Models\User;
use App\Models\JobCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Job::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->words(2,true),
            'description' => $this->faker->paragraph(2,true),
            'location' => $this->faker->city,
            'requirement' => $this->faker->paragraph(2,true),
            'job_category_id' => JobCategory::Factory(),
            'user_id' => User::Factory()
        ];
    }
}
