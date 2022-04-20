<?php

namespace App\Http\Services\Concrete\User;

use App\Exceptions\CalendarErrorException;
use App\Helpers\Constants;
use App\Http\Services\Abstraction\User\RegistrationServiceInterface;
use App\Http\Services\Abstraction\User\UserServiceInterface;
use App\Models\User;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Crypt;

/**
 * Class RegistrationService
 *
 * @package App\Http\Services\Concrete\User
 * @author  Nikola Zekavica <nikolazekavica88@yahoo.com>
 */
class RegistrationService implements RegistrationServiceInterface
{
    /**
     * @var UserServiceInterface
     */
    private $userService;

    /**
     * RegistrationService constructor
     *
     * @param UserServiceInterface $userService
     */
    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Verification user. Method validate code from verification link
     * and check does user already verified.
     *
     * @param string $code
     *
     * @return mixed
     * @throws CalendarErrorException
     */
    public function verify($code): User
    {
        try {
            $userData = Crypt::decrypt($code);
            $user     = $this->userService->getByEmail($userData['email']);
        } catch (\Exception $exception) {
            throw new CalendarErrorException(
                'Verification link is not valid.',
                Response::HTTP_BAD_REQUEST
            );
        }

        if ($user->getAttribute('verification_status') == 1) {
            throw new CalendarErrorException(
                'User already verified.',
                Response::HTTP_CONFLICT
            );
        }

        return $user;
    }

    /**
     * Preparing verification mail data. Data contain url with code.
     * Code include encryption of email and verification code.
     *
     * @param array $data
     * @return mixed
     */
    public function prepareVerificationEmailData(array $data): array
    {
        $code = Crypt::encrypt(
            [
                'email'             => $data['email'],
                'verification_code' => $data['verification_code']
            ],
            true
        );

        $verificationLink = env('APP_URL') . Constants::VERIFICATION_USER_LINK . $code;

        $emailData = [
            'first_name'       => $data['first_name'],
            'verificationLink' => $verificationLink
        ];

        return $emailData;
    }
}