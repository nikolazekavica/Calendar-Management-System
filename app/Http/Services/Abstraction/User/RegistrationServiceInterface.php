<?php

namespace App\Http\Services\Abstraction\User;

use App\Exceptions\CalendarErrorException;
use App\Models\User;

/**
 * Class RegistrationServiceInterface
 *
 * @package App\Http\Services\Abstraction\User
 * @author  Nikola Zekavica <nikolazekavica88@yahoo.com>
 */
interface RegistrationServiceInterface
{
    /**
     * Verification user. Method validate code from verification link
     * and check does user already verified.
     *
     * @param string $code
     *
     * @return mixed
     * @throws CalendarErrorException
     */
    public function verify(string $code): User;

    /**
     * Preparing verification mail data. Data contain url with code.
     * Code include encryption of email and verification code.
     *
     * @param array $data
     * @return mixed
     */
    public function prepareVerificationEmailData(array $data): array;
}