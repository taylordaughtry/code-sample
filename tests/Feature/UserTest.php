<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Carbon\CarbonPeriod;
use Carbon\CarbonImmutable;
use App\Repositories\GoogleCalendar;
use App\Interfaces\EventRepositoryInterface;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function conflicts_are_accounted_for(): void
    {
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

        $user = User::factory()->create();

        $availability = $user->availability();

        $this->assertFalse($availability->contains(CarbonImmutable::now()->startOfHour()));

        $this->assertTrue($availability->contains(CarbonImmutable::now()->startOfHour()->addHours(1)));
    }
}
