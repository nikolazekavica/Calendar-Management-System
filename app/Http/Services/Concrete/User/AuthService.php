<?php

namespace App\Http\Services\Concrete\User;

use App\Http\Services\Abstraction\Common\HttpClientInterface;
use App\Http\Services\Abstraction\User\AuthServiceInterface;
use App\Models\User;

use Illuminate\Http\Request;

use Psr\Http\Message\ResponseInterface;

/**
 * Class AuthService
 *
 * @package App\Http\Services\Concrete\User
 * @author  Nikola Zekavica <nikolazekavica88@yahoo.com>
 */
class AuthService implements AuthServiceInterface
{
    /**
     * @var HttpClientInterface
     */
    private $httpClient;

    /**
     * AuthService constructor
     *
     * @param HttpClientInterface $httpClient
     */
    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Create token. Http client call oauth route with user and client credentials.
     * Oauth server return jwt token.
     *
     * @param User $user
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function createToken(User $user): ResponseInterface
    {
        $token = $this->httpClient
            ->setMethod('POST')
            ->setHeaders(['Content-Type' => 'application/x-www-form-urlencoded'])
            ->setUrl(env('APP_URL').'/oauth/token')
            ->setRequest(
                [
                    'form_params' => [
                        'grant_type'    => 'password',
                        'client_id'     => env('PASSPORT_CLIENT_ID'),
                        'client_secret' => env('PASSPORT_CLIENT_SECRET'),
                        'username'      => $user->getAttribute('username'),
                        'password'      => $user->getAttribute('password'),
                        'scope'         => $user->role()->value('name'),
                    ]
                ]
            )->callApi();

        return $token;
    }

    /**
     * Revoke token.
     *
     * @param Request $request
     * @return void
     */
    public function revokeToken(Request $request): void
    {
        $request->user()->token()->revoke();
    }
}