<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\Website;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Post::class;

    public function definition()
    {
        $websites = Website::all(); //Needs to be a VALID website_id

        return [
        'website_id' => $this->faker->randomElement($websites->pluck('id')->toArray()),
        'post_address' => $this->faker->domainWord(),
        'title' => $this->faker->sentence(),
        'description' => $this->faker->paragraph()
      ];
    }
}
