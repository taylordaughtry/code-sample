<?php

namespace App\Models;

use Carbon\CarbonPeriod;
use Carbon\CarbonImmutable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use App\Interfaces\EventRepositoryInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Resolve openings for a User, given an optional date range $period. If no
     * range is given, the next 24 hours are used.
     */
    public function availability(CarbonPeriod $period = null)
    {
        $period = $period ?: CarbonPeriod::create(
            CarbonImmutable::now()->startOfHour(),
            '1 hours',
            CarbonImmutable::now()->startOfHour()->addDays(1),
            CarbonPeriod::EXCLUDE_START_DATE
        );

        $events = app(EventRepositoryInterface::class)->byUserId($this->id);

        return $period
            ->filter(function ($dateTime) {
                // In the real world there would likely be much more business logic
                // here around when a given Host is available—PTO, for example. Given
                // that, it's possible this could be abstracted further. (I tend towards
                // a YAGNI/KISS approach where possible.)
                return in_array($dateTime->hour, range(8, 19));
            })
            ->filter(function ($dateTime) use ($events) {
                return ! $events->contains(fn ($event) => $event->equalTo($dateTime));
            });
    }
}
