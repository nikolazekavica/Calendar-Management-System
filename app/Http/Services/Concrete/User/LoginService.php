<?php
/**
 * Created by PhpStorm.
 * User: n.zekavica
 * Date: 14.4.2022.
 * Time: 18:33
 */
namespace App\Http\Services\Concrete\User;

use App\Exceptions\CalendarErrorException;
use App\Http\Services\Abstraction\UserInterfaces\LoginServiceInterface;
use App\Http\Services\Abstraction\UserInterfaces\UserServiceInterface;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Crypt;

class LoginService implements LoginServiceInterface
{
    private $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @param string $code
     * @return mixed
     * @throws CalendarErrorException
     */
    public function verificationUser($code):User
    {
        $userData = Crypt::decrypt($code);
        $user     = $this->userService->getByEmail($userData['email']);

        if(!$user->firstOrFail()){
            throw new CalendarErrorException(
                'Verification link is not valid',
                Response::HTTP_BAD_REQUEST
            );
        }

        if($user->firstWhere('verification_status',1)){
            throw new CalendarErrorException(
                'User already verified.',
                Response::HTTP_CONFLICT
            );
        }

        return $user->first();
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function prepareVerificationData(array $data):array
    {
        $code   = Crypt::encrypt(
            [
                'email'             => $data['email'],
                'verification_code' => $data['verification_code']
            ],
            true
        );

        $verificationLink = env('APP_URL').'/api/users/verificationUser?code='.$code;

        $mailData = [
            'first_name'       => $data['first_name'],
            'verificationLink' => $verificationLink
        ];

        return $mailData;
    }
}