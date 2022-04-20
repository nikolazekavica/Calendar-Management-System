<?php

namespace App\Http\Services\Concrete\Common;

use App\Http\Services\Abstraction\Common\HttpClientInterface;
use GuzzleHttp\Client;

/**
 * Class HttpClient
 *
 * @package App\Http\Services\Concrete\Common
 * @author  Nikola Zekavica <nikolazekavica88@yahoo.com>
 */
class HttpClientService implements HttpClientInterface
{
    /**
     * @var string
     */
    private $method;

    /**
     * @var array
     */
    private $request = [];

    /**
     * @var array
     */
    private $headers = [];

    /**
     * @var string
     */
    private $url;

    /**
     * @var Client
     */
    private static $httpClient = null;

    /**
     * Get instance of Client
     *
     * @return Client|null
     */
    public static function getInstance()
    {
        if (!isset(self::$httpClient)) {
            self::$httpClient = new Client();
        }
        return self::$httpClient;
    }

    /**
     * Http call method.
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function callApi()
    {
        $response = self::getInstance()->request(
            $this->method,
            $this->url,
            $this->getParameters()
        );

        return $response;
    }

    /**
     * Set method.
     *
     * @param string $method
     *
     * @return HttpClientService
     */
    public function setMethod(string $method): self
    {
        $this->method = $method;
        return $this;
    }

    /**
     * Set url.
     *
     * @param string $url
     *
     * @return HttpClientService
     */
    public function setUrl(string $url): self
    {
        $this->url = $url;
        return $this;
    }

    /**
     * Set request.
     *
     * @param array $request
     *
     * @return HttpClientService
     */
    public function setRequest(array $request): self
    {
        $this->request = $request;
        return $this;
    }

    /**
     * Set headers.
     *
     * @param array $headers
     *
     * @return HttpClientService
     */
    public function setHeaders(array $headers): self
    {
        $this->headers = ['headers' => $headers];
        return $this;
    }

    /**
     * Get parameters.
     *
     * @return array
     */
    private function getParameters()
    {
        $parameters = array_merge($this->request, $this->headers);
        return $parameters;
    }
}