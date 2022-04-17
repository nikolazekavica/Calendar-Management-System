<?php
/**
 * Created by PhpStorm.
 * User: n.zekavica
 * Date: 15.4.2022.
 * Time: 18:17
 */

namespace App\Http\Services\Concrete\User;


use App\Http\Services\Abstraction\Common\HttpClientInterface;
use App\Http\Services\Abstraction\UserInterfaces\AuthServiceInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Passport;

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
           ->setHeaders(['Content-Type' => 'application/x-www-form-urlencoded'])
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

    public function removeToken(array $data)
    {
        // TODO: Implement removeToken() method.
    }

    public function refreshToken(array $data)
    {
        // TODO: Implement refreshToken() method.
    }

    public function validateToken(array $data)
    {
        // TODO: Implement validateToken() method.
    }
}