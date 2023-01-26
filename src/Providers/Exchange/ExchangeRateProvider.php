<?php

namespace Talebyte\Providers\Exchange;

use Exception;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class ExchangeRateProvider
{
    private Client $client;
    private string $url;
    private string $apikey;

    public function __construct(Client $client, string $url, string $apikey)
    {
        $this->client = $client;
        $this->url = $url;
        $this->apikey = $apikey;
    }

    /**
     * @throws Exception
     */
    public function getExchangeRate(string $currency, string $base): float
    {
        try {
            $response = $this->client->get($this->url, [
                'headers' => [
                    'Content-Type' => 'text/plain',
                    'apikey' => $this->apikey
                ],
                'query' => [
                    'symbols' => $currency,
                    'base' => $base
                ]
            ]);
            if ($response->getStatusCode() != 200) {
                throw new Exception('Exchange rate error');
            }
            $result = json_decode($response->getBody()->getContents(), true);
            $exchangeRate = $result['rates'][$currency] ?? 0;
        } catch (GuzzleException $e) {
            throw new Exception('Exchange rate error');
        }
        return $exchangeRate;
    }
}