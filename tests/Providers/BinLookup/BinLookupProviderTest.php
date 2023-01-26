<?php

use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use Talebyte\Providers\BinLookup\BinLookupProvider;

class BinLookupProviderTest extends TestCase
{
    /**
     * @throws Exception|GuzzleException
     */
    public function testGetCountry()
    {
        // Create a mock response for a successful request
        $mock = new MockHandler([
            new Response(200, [], '{"country": {"alpha2": "US"}}'),
        ]);

        // Create a client with the mock handler Remove mock handler to test real api. Test can be fail use debug
        $client = new Client(['handler' => $mock]);

        // Create an instance of the provider class and pass the client and the URL
        $binLookupProvider = new BinLookupProvider($client, "https://lookup.binlist.net/");

        $result = $binLookupProvider->getCountry("420000");
        $this->assertIsArray($result);
        $this->assertArrayHasKey("country", $result);
    }

    /**
     * @throws Exception|GuzzleException
     */
    public function testGetCountryError()
    {
        // Create a mock response for a request with network error
        $mock = new MockHandler([
            new Response(500, [], '{"error": "Server Error"}'),
        ]);

        // Create a client with the mock handler
        $client = new Client(['handler' => $mock]);

        // Create an instance of the provider class and pass the client
        $binLookupProvider = new BinLookupProvider($client, "https://lookup.binlist.net/");

        $this->expectException(Exception::class);
        $result = $binLookupProvider->getCountry("420000");

    }
}