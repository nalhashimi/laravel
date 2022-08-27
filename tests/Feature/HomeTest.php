<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeTest extends TestCase
{
    /**
     * A basic feature test homepage.
     *
     * @return void
     */
    public function test_homepage()
    {
        $response = $this->get('/');

        $response->assertSeeText('Hello, world!');
    }
    public function test_contactpage()
    {
        $response = $this->get('/contact');

        $response->assertSeeText('Contact');
    }
}
