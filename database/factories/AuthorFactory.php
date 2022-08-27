<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Profile;

class AuthorFactory extends Factory
{
    
        /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterMaking(function ( $author) {
           // $author->profile()->save(Profile::factory()->make());
        })->afterCreating(function ( $author) {
            $author->profile()->save(Profile::factory()->make());
        });
    }
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
        ];
    }
}
