<?php
/**
 * Created by PhpStorm.
 * User: n.zekavica
 * Date: 15.4.2022.
 * Time: 18:17
 */

namespace App\Http\Services\Concrete\User;

use App\Http\Services\Abstraction\Common\HttpClientInterface;
use App\Http\Services\Abstraction\User\AuthServiceInterface;
use App\Models\User;
use Illuminate\Http\Request;

class AuthService implements AuthServiceInterface
{
    private $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @param User $user
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function createToken(User $user)
    {
        $token = $this->httpClient
           ->setMethod('POST')
           ->setHeaders([
               'Content-Type' => 'application/x-www-form-urlencoded',
               'x-testing'    => app()->environment('testing')
           ])
           ->setUrl('http://localhost/oauth/token')
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

    public function revokeToken(Request $request)
    {
        $request->user()->token()->revoke();
    }
}