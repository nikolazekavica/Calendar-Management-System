<?php
/**
 * Created by PhpStorm.
 * User: n.zekavica
 * Date: 15.4.2022.
 * Time: 18:41
 */
namespace App\Http\Services\Concrete\Common;

use App\Http\Services\Abstraction\Common\HttpClientInterface;
use GuzzleHttp\Client;

class HttpClient implements HttpClientInterface
{
    private $method;
    private $request = [];
    private $headers = [];
    private $url;

    private static $httpClient = null;

    public static function getInstance() {
        if (!isset(self::$httpClient)) {
            self::$httpClient = new Client();
        }
        return self::$httpClient;
    }

    /**
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function callApi() {

            $response = self::getInstance()->request(
                $this->method,
                $this->url,
                $this->getParameters()
            );

            return $response;

    }

    public function setMethod(string $method):self {
        $this->method = $method;
        return $this;
    }

    public function setUrl(string $url):self  {
        $this->url = $url;
        return $this;
    }

    public function setRequest(array $request):self  {
        $this->request = $request;
        return $this;
    }

    public function setHeaders(array $headers):self  {
        $this->headers = ['headers' => $headers];
        return $this;
    }

    private function getParameters(){
        $parameters = array_merge($this->request, $this->headers);
        return $parameters;
    }
}