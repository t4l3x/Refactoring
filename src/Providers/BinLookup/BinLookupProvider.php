<?php

namespace Talebyte\Providers\BinLookup;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class BinLookupProvider implements BinLookupInterface
{

    private Client $client;
    private string $baseUrl;

    public function __construct(Client $client, string $baseUrl)
    {
        $this->client = $client;
        $this->baseUrl = $baseUrl;
    }

    /**
     * @throws Exception|GuzzleException
     */
    public function getCountry(string $bin): array
    {
        try {
            $response = $this->client->get($this->baseUrl.$bin);

            if ($response->getStatusCode() != 200) {
                throw new Exception('Exchange rate error');
            }

            $result = json_decode($response->getBody()->getContents(), true);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        return $result;
    }
}