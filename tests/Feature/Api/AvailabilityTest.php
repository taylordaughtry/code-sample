<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\User;
use Carbon\CarbonImmutable;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AvailabilityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function return_available_times_for_a_given_user(): void
    {
        $user = User::factory()->create();

        Passport::actingAs($user);

        $testDates = collect([
            CarbonImmutable::now()->startOfHour(),
            CarbonImmutable::now()->startOfHour()->addDays(1),
        ]);

        $this->mock(
            GoogleCalendar::class,
            function ($mock) use ($testDates) {
                $mock
                    ->shouldReceive('byUserId')
                    ->andReturn($testDates);
            }
        );

        $response = $this->getJson("/api/v1/{$user->id}/availability");

        $response->assertStatus(200);
    }
}
