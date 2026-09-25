<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ComplaintTest extends TestCase
{
    use RefreshDatabase;

    public function test_complaint_can_be_submitted(): void
    {
        $this->post(route('complaint.store'), [
            'name' => 'Rahim',
            'phone' => '01812345678',
            'description' => 'Jar arrived broken.',
        ])->assertOk()->assertJson(['message' => true]);

        $this->assertDatabaseCount('complaints', 1);
    }

    public function test_complaint_validation_fails_without_description(): void
    {
        $this->post(route('complaint.store'), [
            'name' => 'Rahim',
            'phone' => '01812345678',
        ])->assertInvalid('description');
    }
}
