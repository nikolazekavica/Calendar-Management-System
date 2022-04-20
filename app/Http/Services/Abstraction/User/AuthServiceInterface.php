<?php

namespace App\Http\Services\Abstraction\User;

use App\Models\User;
use Illuminate\Http\Request;
use Psr\Http\Message\ResponseInterface;

/**
 * Class AuthServiceInterface
 *
 * @package App\Http\Services\Abstraction\User
 * @author  Nikola Zekavica <nikolazekavica88@yahoo.com>
 */
interface AuthServiceInterface
{
    /**
     * Create token. Http client call oauth route with user and client credentials.
     * Oauth server return jwt token.
     *
     * @param User $user
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function createToken(User $user): ResponseInterface;

    /**
     * Revoke token.
     *
     * @param Request $request
     * @return void
     */
    public function revokeToken(Request $request): void;
}