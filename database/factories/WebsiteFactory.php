<?php

namespace Database\Factories;

use App\Models\Website;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Website>
 */
class WebsiteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Website::class;

    public function definition()
    {
      return [
        'address' => $this->faker->domainName(),
        'title' => $this->faker->domainWord(),
        'description' => $this->faker->paragraph()
      ];
    }
}
