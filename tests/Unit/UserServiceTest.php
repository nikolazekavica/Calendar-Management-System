<?php
/**
 * Created by PhpStorm.
 * User: n.zekavica
 * Date: 19.4.2022.
 * Time: 21:43
 */

namespace Tests\Unit;


use App\Exceptions\CalendarErrorException;
use App\Http\Repositories\Concrete\UserRepository;
use App\Http\Services\Concrete\User\UserService;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    public function test_get_by_email_and_password()
    {
        $user = $this->validStoredUser(1);

        $data = [
            'email'    => $user->getAttribute('email'),
            'password' => 'Test123!'
        ];

        $response = UserService::getInstance()->getByEmailAndPassword($data);

        $this->assertEquals($user->getAttribute('email'), $response->getAttribute('email'));
        $this->assertInstanceOf(User::class, $response);
    }

    public function test_get_by_email_and_password_user_verified_error()
    {
        $this->expectExceptionCode(Response::HTTP_UNAUTHORIZED);
        $this->expectException(CalendarErrorException::class);
        $this->expectExceptionMessage('User account is not verified.');

        $user = $this->validStoredUser();

        $data = [
            'email'    => $user->getAttribute('email'),
            'password' => 'Test123!'
        ];

        UserService::getInstance()->getByEmailAndPassword($data);
    }

    public function test_get_by_email_and_password_input_error()
    {
        $this->expectExceptionCode(Response::HTTP_FORBIDDEN);
        $this->expectException(CalendarErrorException::class);
        $this->expectExceptionMessage('Incorrect password.');

        $user = $this->validStoredUser(1);

        $data = [
            'email'    => $user->getAttribute('email'),
            'password' => 'testtest'
        ];

        UserService::getInstance()->getByEmailAndPassword($data);
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