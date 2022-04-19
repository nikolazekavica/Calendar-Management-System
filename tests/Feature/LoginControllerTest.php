<?php
/**
 * Created by PhpStorm.
 * User: n.zekavica
 * Date: 19.4.2022.
 * Time: 0:56
 */

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Passport;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    public function test_logout()
    {
        $user = User::factory()->make([
            'password'            => Hash::make('Test123!'),
            'verification_code'   => 'testtesddsadt',
            'verification_status' => 1,
            'email' => 'calendarlaraveltest@gmail.com',
            'username' => 'testuser',
            'role_id' => 2
        ]);

        Passport::actingAs($user);

        $response = $this->post('/api/users/logout');
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_login_input_error()
    {
        $request = [
            'email' => 'test1gmail.com',
            'password' => 'Test123!'
        ];

        $response = $this->post('api/users/login', $request);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJson([
            "errors" => [
                [
                    "param"   => "email",
                    "message" => [
                        "Email does not exist.",
                        "Incorrect email format."
                    ],
                ]
            ]
        ]);
    }
}