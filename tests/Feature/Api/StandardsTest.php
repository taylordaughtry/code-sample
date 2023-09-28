<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\User;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StandardsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function rejects_authorized_requests(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->getJson('/api/v1');

        $response->assertStatus(401);
    }

    /** @test */
    public function accepts_authorized_requests(): void
    {
        $user = User::factory()->create();

        Passport::actingAs($user);

        $response = $this->actingAs($user)->getJson('/api/v1');

        $response->assertStatus(200);
    }

    // In a real-world project I'd drive out some simple assurances here to make
    // sure we're adhering to a standard (i.e. JSON API). It'd be extraneous
    // once the project grows (and likely unreasonable to check all endpoints),
    // but initially it's a good way to get that logic in-place via TDD and
    // ensure it has test coverage.
}
