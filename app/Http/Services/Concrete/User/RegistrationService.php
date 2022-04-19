<?php
/**
 * Created by PhpStorm.
 * User: n.zekavica
 * Date: 14.4.2022.
 * Time: 18:33
 */
namespace App\Http\Services\Concrete\User;

use App\Exceptions\CalendarErrorException;
use App\Helpers\Constants;
use App\Http\Services\Abstraction\User\RegistrationServiceInterface;
use App\Http\Services\Abstraction\User\UserServiceInterface;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Crypt;

class RegistrationService implements RegistrationServiceInterface
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
    public function verify($code):User
    {
        try{
            $userData = Crypt::decrypt($code);
            $user     = $this->userService->getByEmail($userData['email']);
            $user->firstOrFail();
        } catch (\Exception $exception) {
            throw new CalendarErrorException(
                'Verification link is not valid.',
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
    public function prepareVerificationEmailData(array $data):array
    {
        $code   = Crypt::encrypt(
            [
                'email'             => $data['email'],
                'verification_code' => $data['verification_code']
            ],
            true
        );

        //TODO:BETTER SOLUTION FOR BUILDER LINK
        $verificationLink = env('APP_URL').Constants::VERIFICATION_USER_LINK.$code;

        $emailData = [
            'first_name'       => $data['first_name'],
            'verificationLink' => $verificationLink
        ];

        return $emailData;
    }
}