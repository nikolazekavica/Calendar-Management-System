<?php
/**
 * Created by PhpStorm.
 * User: n.zekavica
 * Date: 18.4.2022.
 * Time: 17:04
 */

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegistrationControllerTest extends TestCase
{
    // REGISTER

    public function test_register()
    {
        $user = User::factory()->make([
            'password'   => 'Test123!'
        ]);

        $response = $this->post('api/users/register', $user->getAttributes());

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJson([
            "success" => [
                "data"    => null,
                "message" => "User successfully registered."
            ]
        ]);
    }

    public function test_register_input_format_error()
    {
        $user = User::factory()->make([
            'password' => 'test123'
        ]);

        $response = $this->post('api/users/register', $user->getAttributes());

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJson([
            "errors" => [
                [
                    "param"   => "password",
                    "message" => [
                        'Incorrect password format. Password length (min. 6 characters and max. 20).'.
                        'Must contain letters,numbers,capital letter and special characters(!@#%&*).'.
                        'Spaces are not permitted.'
                    ],
                ]
            ]
        ]);
    }

    public function test_register_input_exist_error()
    {
        $user = User::factory()->make([
            'password'          => 'Test123!',
            'verification_code' => "verificationcodetest"
        ]);

        User::query()->truncate();
        User::create($user->getAttributes());

        $response = $this->post('api/users/register', $user->getAttributes());

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJson([
            "errors" => [
                [
                    "param"   => "username",
                    "message" => [
                        "The username has already been taken."
                    ],
                ],
                [
                    "param"   => "email",
                    "message" => [
                        "The email has already been taken."
                    ],
                ]
            ],
        ]);
    }

    // VERIFY

    public function test_verify()
    {
        $user = $this->validStoredUser();

        $verificationCode = $user->getAttribute('verification_code');

        $response = $this->get('api/users/verify?code='.$verificationCode);

        $verificationStatus = User::where('verification_code', $verificationCode)
            ->first()
            ->getAttribute('verification_status');

        $this->assertEquals(1, $verificationStatus);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            "success" => [
                "data"    => null,
                "message" => "Verification successfully finished."
            ]
        ]);
    }

    public function test_verify_code_error()
    {
        $user = $this->validStoredUser();

        $incorrectVerificationCode = 'testtesttest';

        $response = $this->get('api/users/verify?code='.$incorrectVerificationCode);

        $verificationCode   = $user->getAttribute('verification_code');

        $verificationStatus = User::where('verification_code', $verificationCode)
            ->first()
            ->getAttribute('verification_status');

        $this->assertEquals(0, $verificationStatus);
        $response->assertStatus(Response::HTTP_BAD_REQUEST);
        $response->assertJson([
            "errors" => [
                "message" => "Verification link is not valid."
            ]
        ]);
    }

    public function test_verify_status_already_verified_error()
    {
        $user = $this->validStoredUser(1);

        $verificationCode = $user->getAttribute('verification_code');

        $response = $this->get('api/users/verify?code='.$verificationCode);

        $response->assertStatus(Response::HTTP_CONFLICT);
        $response->assertJson([
            "errors" => [
                "message" => "User already verified."
            ]
        ]);
    }

    //PRIVATE FUNCTION
    private function validStoredUser($verificationStatus = 0)
    {
        $user = User::factory()->make([
            'password'              => 'Test123!',
            'username'              => 'test123',
            'email'                 => 'calendarlaraveltest@gmail.com',
            'verification_status'   => $verificationStatus,
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