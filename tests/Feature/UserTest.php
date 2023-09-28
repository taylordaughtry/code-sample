<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function has_available_openings(): void
    {
        $user = User::factory()->create();

        $availability = $user->availability();

        // The contents aren't under test at this point, simply that the method
        // returns available openings. Hence we're simply considering any
        // iterable/countable entity returned with 1+ items as successful.
        $this->assertTrue((bool) $availability->count());

        // Given a User with one meeting at 9 AM
        // When a client requests openings for that Host
        // Then the response should contain 8 AM and 10 AM
        //  AND the response should not contain 9 AM
    }
}
