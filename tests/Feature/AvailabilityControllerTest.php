<?php
/**
 * Created by PhpStorm.
 * User: n.zekavica
 * Date: 17.4.2022.
 * Time: 14:14
 */

namespace Tests\Feature;

use App\Helpers\Constants;
use App\Http\Traits\DateTimeTrait;
use App\Models\Availability;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Passport;
use Tests\TestCase;

class AvailabilityControllerTest extends TestCase
{
    use DateTimeTrait;

    //AVAILABILITY STORE
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_availability_store()
    {
        $user = $this->validStoredUser();

        Passport::actingAs($user, ['regular']);

        $availability = Availability::factory()->make([
            'user_id'        => $user->getAttribute('id'),
            "is_recurrences" => false,
        ]);

        $response = $this->post('/api/availabilities', $availability->getAttributes());

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJson([
            "success" =>
                [
                    "data"    => null,
                    "message" => "Availability successfully inserted."
                ]
        ]);
    }

    public function test_availability_store_permission_error()
    {
        $user = $this->validStoredUser();

        Passport::actingAs($user, ['admin']);

        $availability = Availability::factory()->make([
            'user_id'        => $user->getAttribute('id'),
            "is_recurrences" =>  false,
        ]);

        $response = $this->post('/api/availabilities', $availability->getAttributes());

        $response->assertStatus(Response::HTTP_FORBIDDEN);
        $response->assertJson([
            "errors" =>
                [
                    "message" => "User dont have permission for this action."
                ],
        ]);
    }

    public function test_availability_store_input_required_error()
    {
        $user = $this->validStoredUser();

        Passport::actingAs($user, ['regular']);

        $availability = Availability::factory()->make([
            'user_id'        => $user->getAttribute('id'),
            "is_recurrences" =>  false,
        ]);

        $attributes = $availability->getAttributes();
        unset($attributes['title']);

        $response = $this->post('/api/availabilities', $attributes);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJson([
            "errors" => [
                [
                    "param"=>"title",
                    "message"=>[
                        "The title field is required."
                    ],
                ]
            ]
        ]);
    }

    public function test_availability_store_input_format_error()
    {
        $user = $this->validStoredUser();

        Passport::actingAs($user, ['regular']);

        $availability = Availability::factory()->make([
            'user_id'        => $user->getAttribute('id'),
            "is_recurrences" =>  'test',
        ]);

        $response = $this->post('/api/availabilities', $availability->getAttributes());

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJson([
            "errors" => [
                [
                    "param"   => "is_recurrences",
                    "message" => [
                        "The is recurrences field must be true or false."
                    ],
                ]
            ]
        ]);
    }

    public function test_availability_store_custom_error()
    {
        $user = $this->validStoredUser();

        Passport::actingAs($user, ['regular']);

        $availability = Availability::factory()->make([
            'user_id'        => $user->getAttribute('id'),
            "start_date"     => $this->dateTimeNow()->addDays(1)->format(Constants::DATE_FORMAT_PROJECT),
            "end_date"       => $this->dateTimeNow()->addDays(20)->format(Constants::DATE_FORMAT_PROJECT),
            'is_recurrences' => true
        ]);

        $response = $this->post('/api/availabilities', $availability->getAttributes());

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJson([
            "errors" => [
                [
                    "param"   => "is_recurrences",
                    "message" => [
                        "Availability duration must be shorter than the frequency of recurrence."
                    ],
                ]
            ]
        ]);
    }

    public function test_availability_store_multi_error()
    {
        $user = $this->validStoredUser();

        Passport::actingAs($user, ['regular']);

        $availability = Availability::factory()->make([
            'user_id'        => $user->getAttribute('id'),
            "start_date"     => $this->dateTimeNow()->subDays(2)->format(Constants::DATE_FORMAT_PROJECT),
            "end_date"       => $this->dateTimeNow()->addDays(10)->format(Constants::DATE_FORMAT_PROJECT),
            "is_recurrences" =>  false,
        ]);

        $response = $this->post('/api/availabilities', $availability->getAttributes());

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJson([
            "errors" => [
                [
                    "param"   => "start_date",
                    "message" => [
                        "The start date must be a date after or equal to today."
                    ],
                ],
                [
                    "param"   => "is_recurrences",
                    "message" => [
                        "Availability duration must be shorter than the frequency of recurrence."
                    ],
                ]
            ],
        ]);
    }

    public function test_availability_store_multiple_recurrences_error()
    {
        $user = $this->validStoredUser();

        Passport::actingAs($user, ['regular']);

        $availability = Availability::factory()->make([
            'user_id'        => $user->getAttribute('id'),
            "is_recurrences" => true,
        ]);

        Availability::query()->truncate();
        Availability::create($availability->getAttributes());

        $responseRepeat = $this->post('/api/availabilities', $availability->getAttributes());

        $responseRepeat->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $responseRepeat->assertJson([
            "errors" => [
                [
                    "param"   => "is_recurrences",
                    "message" => [
                        "Multiple recurrences are forbidden for the same user."
                    ],
                ],
            ],
        ]);
    }

    //AVAILABILITY ALL

    public function test_availability_all()
    {
        $user = $this->validStoredUser();

        Passport::actingAs($user, ['admin']);

        $availability = Availability::factory()->make([
            'user_id'        => $user->getAttribute('id'),
            "is_recurrences" => false,
        ]);

        Availability::query()->truncate();
        Availability::create($availability->getAttributes());

        $response = $this->get('/api/availabilities');

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            "success" => [
                    "data" => [
                        'total_results',
                        'current_page',
                        'from',
                        'to',
                        'per_page',
                        'next_page_url',
                        'prev_page_url',
                        'items' =>
                            [
                                [
                                    'id',
                                    'title',
                                    'start_time',
                                    'end_time',
                                    'availability_status',
                                    'timezone',
                                    'description',
                                    'period' => [
                                        'total_results',
                                        'current_page',
                                        'from',
                                        'to',
                                        'per_page',
                                        'next_page_url',
                                        'prev_page_url',
                                        'items' => []
                                    ],
                                    'user' => [
                                        'id',
                                        'first_name',
                                        'last_name',
                                        'username',
                                        'email'
                                    ]
                                ],
                            ]
                    ],
                    "message"
            ]
        ]);
    }

    //AVAILABILITY ALL BY USER ID

    public function test_availability_all_by_user_id()
    {
        $user = $this->validStoredUser();

        $userId = $user->getAttribute('id');

        Passport::actingAs($user, ['admin']);

        $availability = Availability::factory()->make([
            'user_id'        => $userId,
            "is_recurrences" => false,
        ]);

        Availability::query()->truncate();
        Availability::create($availability->getAttributes());

        $response = $this->get('api/users/'.$userId.'/availabilities');

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            "success" => [
                "data" => [
                    'total_results',
                    'current_page',
                    'from',
                    'to',
                    'per_page',
                    'next_page_url',
                    'prev_page_url',
                    'items' =>
                        [
                            [
                                'id',
                                'title',
                                'start_time',
                                'end_time',
                                'availability_status',
                                'timezone',
                                'description',
                                'period' => [
                                    'total_results',
                                    'current_page',
                                    'from',
                                    'to',
                                    'per_page',
                                    'next_page_url',
                                    'prev_page_url',
                                    'items' => []
                                ],
                            ],
                        ]
                ],
                "message"
            ]
        ]);
    }

    public function test_availability_all_by_user_id_incorrect_user_id_error()
    {
        $user   = $this->validStoredUser();
        $userId = $user->getAttribute('id');

        Passport::actingAs($user, ['regular']);

        $availability = Availability::factory()->make([
            'user_id'        => $userId,
            "is_recurrences" => false,
        ]);

        Availability::query()->truncate();
        Availability::create($availability->getAttributes());

        $randomUserId = $userId + 1;

        $response = $this->get('api/users/'.$randomUserId.'/availabilities');

        $response->assertStatus(Response::HTTP_FORBIDDEN);
        $response->assertJson([
            "errors" =>
                [
                    "message" => "User dont have permission for this action."
                ],
        ]);
    }

    //AVAILABILITY ALL BY DATE RANGE

    public function test_availability_all_by_date_range()
    {
        $user   = $this->validStoredUser();
        $userId = $user->getAttribute('id');

        Passport::actingAs($user, ['admin']);

        $availability = Availability::factory()->make([
            'user_id'        => $userId,
            "is_recurrences" => false,
        ]);

        Availability::query()->truncate();
        Availability::create($availability->getAttributes());

        $startDate = $this->dateTimeNow()->addDays(2)->format(Constants::DATE_FORMAT_PROJECT);
        $endData   = $this->dateTimeNow()->addDays(5)->format(Constants::DATE_FORMAT_PROJECT);

        $response = $this->get('api/availabilities/filter?start_date='.$startDate.'&end_date='.$endData);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            "success" => [
                "data" => [
                    'total_results',
                    'current_page',
                    'from',
                    'to',
                    'per_page',
                    'next_page_url',
                    'prev_page_url',
                    'items' =>
                        [
                            [
                                'id',
                                'title',
                                'start_time',
                                'end_time',
                                'availability_status',
                                'timezone',
                                'description',
                                'period' => [
                                    'total_results',
                                    'current_page',
                                    'from',
                                    'to',
                                    'per_page',
                                    'next_page_url',
                                    'prev_page_url',
                                    'items' => []
                                ],
                                'user' => [
                                    'id',
                                    'first_name',
                                    'last_name',
                                    'username',
                                    'email'
                                ]
                            ],
                        ]
                ],
                "message"
            ]
        ]);
    }

    public function test_availability_all_by_date_range_permission_error()
    {
        $user   = $this->validStoredUser();
        $userId = $user->getAttribute('id');

        Passport::actingAs($user, ['regular']);

        $availability = Availability::factory()->make([
            'user_id'        => $userId,
            "is_recurrences" => false,
        ]);

        Availability::query()->truncate();
        Availability::create($availability->getAttributes());

        $startDate = $this->dateTimeNow()->addDays(2)->format(Constants::DATE_FORMAT_PROJECT);
        $endData   = $this->dateTimeNow()->addDays(5)->format(Constants::DATE_FORMAT_PROJECT);

        $response  = $this->get('api/availabilities/filter?start_date='.$startDate.'&end_date='.$endData);

        $response->assertStatus(Response::HTTP_FORBIDDEN);
        $response->assertJson([
            "errors" =>
                [
                    "message" => "User dont have permission for this action."
                ],
        ]);
    }

    public function test_availability_all_by_date_range_max_date_range_error()
    {
        $user   = $this->validStoredUser();
        $userId = $user->getAttribute('id');

        Passport::actingAs($user, ['admin']);

        $availability = Availability::factory()->make([
            'user_id'        => $userId,
            "is_recurrences" => false,
        ]);

        Availability::query()->truncate();
        Availability::create($availability->getAttributes());

        $startDate = $this->dateTimeNow()->addDays(2)->format(Constants::DATE_FORMAT_PROJECT);
        $endData   = $this->dateTimeNow()->addDays(40)->format(Constants::DATE_FORMAT_PROJECT);

        $response  = $this->get('api/availabilities/filter?start_date=' . $startDate . '&end_date=' . $endData);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJson([
            "errors" => [
                [
                    "param"   => "end_date",
                    "message" => [
                        "Range time must be less than 30 days"
                    ],
                ],
            ],
        ]);
    }

    //AVAILABILITY ALL BY USER

    public function test_availability_all_by_user()
    {
        $user      = $this->validStoredUser();
        $userId    = $user->getAttribute('id');
        $firstName = $user->getAttribute('first_name');
        $lastName  = $user->getAttribute('last_name');

        Passport::actingAs($user, ['admin']);

        $availability = Availability::factory()->make([
            'user_id'        => $userId,
            "is_recurrences" => false,
        ]);

        Availability::query()->truncate();
        Availability::create($availability->getAttributes());

        $response = $this->get('api/users/filter/availabilities?first_name='.$firstName.'&last_name='.$lastName);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            "success" => [
                "data" => [
                    'total_results',
                    'current_page',
                    'from',
                    'to',
                    'per_page',
                    'next_page_url',
                    'prev_page_url',
                    'items' =>
                        [
                            [
                                'id',
                                'title',
                                'start_time',
                                'end_time',
                                'availability_status',
                                'timezone',
                                'description',
                                'period' => [
                                    'total_results',
                                    'current_page',
                                    'from',
                                    'to',
                                    'per_page',
                                    'next_page_url',
                                    'prev_page_url',
                                    'items' => []
                                ],
                                'user' => [
                                    'id',
                                    'first_name',
                                    'last_name',
                                    'username',
                                    'email'
                                ]
                            ],
                        ]
                ],
                "message"
            ]
        ]);
    }

    public function test_availability_all_by_user_permission_error()
    {
        $user      = $this->validStoredUser();
        $userId    = $user->getAttribute('id');
        $firstName = $user->getAttribute('first_name');
        $lastName  = $user->getAttribute('last_name');

        Passport::actingAs($user, ['regular']);

        $availability = Availability::factory()->make([
            'user_id'        => $userId,
            "is_recurrences" => false,
        ]);

        Availability::query()->truncate();
        Availability::create($availability->getAttributes());

        $response = $this->get('api/users/filter/availabilities?first_name='.$firstName.'&last_name='.$lastName);

        $response->assertStatus(Response::HTTP_FORBIDDEN);
        $response->assertJson([
            "errors" =>
                [
                    "message" => "User dont have permission for this action."
                ],
        ]);
    }

    public function test_availability_all_by_user_allow_param_error()
    {
        $user   = $this->validStoredUser();
        $userId = $user->getAttribute('id');

        Passport::actingAs($user, ['admin']);

        $availability = Availability::factory()->make([
            'user_id'        => $userId,
            "is_recurrences" => false,
        ]);

        Availability::query()->truncate();
        Availability::create($availability->getAttributes());

        $response = $this->get('api/users/filter/availabilities?password=test');

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJson([
            "errors" => [
                [
                    "param"   => "password",
                    "message" => [
                        "Forbidden. Allowed params: first_name, last_name, username, email."
                    ],
                ],
            ],
        ]);
    }

    //PRIVATE FUNCTIONS
    private function validStoredUser()
    {
        $user = User::factory()->make([
            'password'              => 'Test123!',
            'username'              => 'test123',
            'email'                 => 'calendarlaraveltest@gmail.com',
            'verification_status'   => 1,
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