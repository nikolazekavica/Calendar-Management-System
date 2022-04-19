<?php
/**
 * Created by PhpStorm.
 * User: n.zekavica
 * Date: 8.4.2022.
 * Time: 14:24
 */

namespace App\Http\Controllers\Calendar\v1;

use App\Helpers\CalendarResponse;
use App\Http\Requests\User\RegisterUserRequest;
use App\Http\Requests\User\VerifyUserRequest;
use App\Http\Services\Abstraction\User\RegistrationServiceInterface;
use App\Http\Services\Abstraction\User\UserServiceInterface;
use App\Http\Services\Concrete\Common\EmailService;
use App\Mail\UserVerificationMailable;
use Illuminate\Http\Response;

class RegistrationController extends Controller
{
    private $userService;
    private $registrationService;

    public function __construct(
        UserServiceInterface $userService,
        RegistrationServiceInterface $registrationService
    ) {
        $this->userService         = $userService;
        $this->registrationService = $registrationService;
    }

    public function register(RegisterUserRequest $request)
    {
        $user      = $this->userService->store($request->all());
        $emailData = $this->registrationService->prepareVerificationEmailData($user);

        EmailService::send(
            $user['email'],
            new UserVerificationMailable($emailData)
        );

        return CalendarResponse::success(
            "User successfully registered.",
            Response::HTTP_CREATED
        );
    }

    public function verify(VerifyUserRequest $request)
    {
        $user = $this->registrationService->verify($request->get('code'));

        $this->userService->update(
            ['verification_status' => 1],
            $user->getAttribute('id')
        );

        return CalendarResponse::success(
            "Verification successfully finished.",
            Response::HTTP_OK
        );
    }
}