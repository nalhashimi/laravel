<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\BlogPost;

class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'content' => $this->faker->sentence(),
            'blog_post_id' => BlogPost::factory()->create()->id
        ];
    }
}
