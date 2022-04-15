<?php
/**
 * Created by PhpStorm.
 * User: n.zekavica
 * Date: 8.4.2022.
 * Time: 14:24
 */

namespace App\Http\Controllers;

use App\Helpers\CalendarResponse;
use App\Http\Requests\User\RegistrationUserRequest;
use App\Http\Requests\User\VerificationUserRequest;
use App\Http\Services\Abstraction\UserInterfaces\LoginServiceInterface;
use App\Http\Services\Abstraction\UserInterfaces\UserServiceInterface;
use App\Http\Services\Concrete\Common\EmailService;
use App\Mail\UserVerificationMailable;
use Illuminate\Http\Response;

class LoginController extends Controller
{
    private $userService;
    private $loginService;

    public function __construct(
        UserServiceInterface $userService,
        LoginServiceInterface $loginService
    ) {
        $this->userService  = $userService;
        $this->loginService = $loginService;
    }

    public function registrationUser(RegistrationUserRequest $request)
    {
        $user      = $this->userService->store($request->all());
        $emailData = $this->loginService->prepareVerificationData($user);

        EmailService::send(
            $user['email'],
            new UserVerificationMailable($emailData)
        );

        return CalendarResponse::success(
            "User successfully registered.",
            Response::HTTP_CREATED
        );
    }

    public function verificationUser(VerificationUserRequest $request)
    {
        $user = $this->loginService->verificationUser($request->get('code'));

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