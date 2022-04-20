<?php

namespace App\Http\Services\Abstraction\User;

use Illuminate\Http\Request;

/**
 * Class LoginServiceInterface
 *
 * @package App\Http\Services\Abstraction\User
 * @author  Nikola Zekavica <nikolazekavica88@yahoo.com>
 */
interface LoginServiceInterface
{
    /**
     * Login user.
     *
     * @param $request
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function login(array $request);

    /**
     * Logout user.
     *
     * @param Request $request
     *
     * @return void
     */
    public function logout(Request $request);
}