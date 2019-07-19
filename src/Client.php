<?php

namespace IEXCloud;

use GuzzleHttp\Client as HttpClient;
use Psr\Http\Message\ResponseInterface;

class Client
{
    const BASE_URL = 'https://cloud.iexapis.com';

    /**
     * @var HttpClient
     */
    protected $httpClient;

    /**
     * @var string
     */
    protected $token;

    /**
     * @var string
     */
    protected $version;

    /**
     * Resource constructor.
     *
     * ResourceAbstract constructor.
     * @param HttpClient $httpClient
     */
    public function __construct(HttpClient $httpClient = null)
    {
        $this->httpClient = $httpClient ?? new HttpClient([
            'base_uri' => self::BASE_URL
        ]);
    }

    /**
     * @param string $token
     * @return Client
     */
    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }

    /**
     * @param string $version
     * @return Client
     */
    public function setVersion($version)
    {
        $this->version = $version;
        return $this;
    }

    /**
     * @param string $symbol
     * @param integer $last
     * @return mixed
     */
    public function news($symbol, $last = 10)
    {
        $url = $this->version . '/stock/' . $symbol . '/news/last/' . $last;

        return $this->filterResponse(
            $this->httpClient->get($url, [
                'query' => [
                    'token' => $this->token,
                ]
            ])
        );
    }

    /**
     * @param string $symbol
     * @return mixed
     */
    public function company($symbol)
    {
        $url = $this->version . '/stock/' . $symbol . '/company';

        return $this->filterResponse(
            $this->httpClient->get($url, [
                'query' => [
                    'token' => $this->token,
                ]
            ])
        );
    }

    /**
     * @param string $symbol
     * @param string $stat
     * @return mixed
     */
    public function stats($symbol, $stat = '')
    {
        $url = $this->version . '/stock/' . $symbol . '/stats';

        if (!empty($stat)) {
            $url .= '/' . $stat;
        }

        return $this->filterResponse(
            $this->httpClient->get($url, [
                'query' => [
                    'token' => $this->token,
                ]
            ])
        );
    }

    /**
     * @param string $symbol
     * @param string $period
     * @param integer $last
     * @return mixed
     */
    public function balanceSheet($symbol, $period = 'quarter', $last = 1)
    {
        $url = $this->version . '/stock/' . $symbol . '/balance-sheet/last/' . $last;

        return $this->filterResponse(
            $this->httpClient->get($url, [
                'query' => [
                    'period' => $period,
                    'token' => $this->token,
                ]
            ])
        );
    }

    /**
     * Filter the response, try to maintain the original format.
     *
     * @param ResponseInterface $response
     * @return mixed
     */
    protected function filterResponse(ResponseInterface $response)
    {
        return json_decode($response->getBody()->getContents());
    }
}
