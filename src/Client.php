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
     * @param array $curlOptions
     */
    public function __construct(HttpClient $httpClient = null, $curlOptions = [])
    {
        $curlOptions['base_uri'] = self::BASE_URL;
        $this->httpClient = $httpClient ?? new HttpClient($curlOptions);
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
    public function balanceSheet($symbol, $period = 'quarter', $last = 5)
    {
        $url = $this->version . '/stock/' . $symbol . '/balance-sheet';

        return $this->filterResponse(
            $this->httpClient->get($url, [
                'query' => [
                    'period' => $period,
                    'last' => $last,
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
    public function income($symbol, $period = 'quarter', $last = 5)
    {
        $url = $this->version . '/stock/' . $symbol . '/income';

        return $this->filterResponse(
            $this->httpClient->get($url, [
                'query' => [
                    'period' => $period,
                    'last' => $last,
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
    public function cashFlow($symbol, $period = 'quarter', $last = 5)
    {
        $url = $this->version . '/stock/' . $symbol . '/cash-flow';

        return $this->filterResponse(
            $this->httpClient->get($url, [
                'query' => [
                    'period' => $period,
                    'last' => $last,
                    'token' => $this->token,
                ]
            ])
        );
    }

    /**
     * @param string $symbol
     * @return mixed
     */
    public function advancedStats($symbol)
    {
        $url = $this->version . '/stock/' . $symbol . '/advanced-stats';

        return $this->filterResponse(
            $this->httpClient->get($url, [
                'query' => [
                    'token' => $this->token,
                ]
            ])
        );
    }

    /**
     * @return mixed
     */
    public function symbols()
    {
        $url = $this->version . '/ref-data/symbols';

        return $this->filterResponse(
            $this->httpClient->get($url, [
                'query' => [
                    'token' => $this->token,
                ]
            ])
        );
    }

    /**
     * @return mixed
     */
    public function exchanges()
    {
        $url = $this->version . '/ref-data/exchanges';

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
    public function previous($symbol)
    {
        $url = $this->version . '/stock/' . $symbol . '/previous';

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
    public function price($symbol)
    {
        $url = $this->version . '/stock/' . $symbol . '/price';

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
     * @param string $field Case sensitive string matching a response attribute below. Specifying an attribute will return just the attribute value.
     * @param boolean $displayPercent If set to true, all percentage values will be multiplied by a factor of 100
     * @return mixed
     */
    public function quote($symbol, $field = null, $displayPercent = false)
    {
        $url = $this->version . '/stock/' . $symbol . '/quote';

        if ($field !== null) {
            $url .= '/' . $field;
        }

        return $this->filterResponse(
            $this->httpClient->get($url, [
                'query' => [
                    'token' => $this->token,
                    'displayPercent' => $displayPercent,
                ]
            ])
        );
    }

    /**
     * @param $isin
     * @return mixed
     */
    public function isin($isin)
    {
        $url = $this->version . '/ref-data/isin';

        return $this->filterResponse(
            $this->httpClient->get($url, [
                'query' => [
                    'token' => $this->token,
                    'isin' => $isin,
                ],
            ])
        );
    }

    /**
     * @param string $symbol
     * @param integer $last
     * @return mixed
     */
    public function financials($symbol, $last = 1)
    {
        $url = $this->version . '/stock/' . $symbol . '/financials';

        return $this->filterResponse(
            $this->httpClient->get($url, [
                'query' => [
                    'token' => $this->token,
                    'last' => $last,
                ],
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
