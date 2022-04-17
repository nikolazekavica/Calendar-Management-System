<?php

namespace App\Http\Services\Abstraction\Common;

use App\Http\Services\Concrete\Common\HttpClient;

/**
 * Created by PhpStorm.
 * User: n.zekavica
 * Date: 15.4.2022.
 * Time: 18:58
 */

interface HttpClientInterface
{
    public function callApi();
    public function setMethod(string $method) :HttpClient;
    public function setRequest(array $request) :HttpClient;
    public function setHeaders(array $headers) :HttpClient;
    public function setUrl(string $url) :HttpClient;
}