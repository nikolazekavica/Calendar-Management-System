<?php

namespace App\Http\Services\Abstraction\Common;

use App\Http\Services\Concrete\Common\HttpClientService;

/**
 * Class HttpClientInterface
 *
 * @package App\Http\Services\Abstraction\Common
 * @author  Nikola Zekavica <nikolazekavica88@yahoo.com>
 */
interface HttpClientInterface
{
    /**
     * Http call method.
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function callApi();

    /**
     * Set method.
     *
     * @param string $method
     *
     * @return HttpClientService
     */
    public function setMethod(string $method): HttpClientService;

    /**
     * Set url.
     *
     * @param string $url
     *
     * @return HttpClientService
     */
    public function setUrl(string $url): HttpClientService;

    /**
     * Set request.
     *
     * @param array $request
     *
     * @return HttpClientService
     */
    public function setRequest(array $request): HttpClientService;

    /**
     * Set headers.
     *
     * @param array $headers
     *
     * @return HttpClientService
     */
    public function setHeaders(array $headers): HttpClientService;
}