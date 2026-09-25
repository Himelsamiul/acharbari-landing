<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /** Home page must render even on a fresh, seeded database. */
    public function test_the_application_returns_a_successful_response(): void
    {
        $this->seed();

        $this->get('/')->assertOk();
    }
}
