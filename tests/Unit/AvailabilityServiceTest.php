<?php
/**
 * Created by PhpStorm.
 * User: n.zekavica
 * Date: 20.4.2022.
 * Time: 0:23
 */

namespace Tests\Unit;

use App\Http\Services\Concrete\Availability\AvailabilityBuilderService;
use App\Http\Traits\DateTimeTrait;
use App\Models\Availability;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AvailabilityServiceTest extends TestCase
{
    use DateTimeTrait;

    public function test_build()
    {
        $user = $this->validStoredUser();

        $availabilityCollection = new Collection();

        $availabilityOne = Availability::factory()->make([
            'user_id'        => $user->getAttribute('id'),
            "is_recurrences" => true,
        ]);

        $availabilityTwo = Availability::factory()->make([
            'user_id'        => $user->getAttribute('id'),
            "is_recurrences" => false,
        ]);

        $availabilityCollection->add($availabilityOne);
        $availabilityCollection->add($availabilityTwo);


        $startDateSearch = $this->startDateLimitSearch()->getTimestamp();
        $endDateSearch   = $this->endDateLimitSearch()->getTimestamp();

        Availability::query()->truncate();
        $availabilities = AvailabilityBuilderService::getInstance()->build(
            $availabilityCollection,
            $startDateSearch,
            $endDateSearch
        );

        $this->assertIsArray($availabilities);
        $this->assertArrayHasKey('total_results', $availabilities);
        $this->assertArrayHasKey('items', $availabilities);
        $this->assertArrayHasKey('period', $availabilities['items'][0]);
    }

    //PRIVATE FUNCTION
    private function validStoredUser($verification = 0)
    {
        $user = User::factory()->make([
            'password'              => Hash::make('Test123!'),
            'username'       => 'test123',
            'email'                 => 'calendarlaraveltest@gmail.com',
            'verification_status'   => $verification,
            'verification_code'     => Crypt::encrypt([
                'email'             => 'calendarlaraveltest@gmail.com',
                'verification_code' => Hash::make('test123')
            ],
                true
            )
        ]);

        User::query()->truncate();
        $user = User::create($user->getAttributes());

        return $user;
    }
}