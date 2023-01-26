<?php


use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use Talebyte\Providers\Exchange\ExchangeRateProvider;

class ExchangeRateProviderTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testGetExchangeRateSuccess()
    {
        // Create a mock response for a successful request
        $mock = new MockHandler([
            new Response(200, [], '{"rates": {"EUR": 1.2}}'),
        ]);

        // Create a client with the mock handler. Remove mock handler to test real api. Test can be fail use debug
        $client = new Client(['handler' => $mock]);

        // Create an instance of the provider class and pass the client, url and apikey
        // API key is working you can
        $exchangeRateProvider = new ExchangeRateProvider($client, "https://api.apilayer.com/exchangerates_data/latest", "QbJbyRAtAEc7b6tp2AWgau5rbtWT10vc");

        // Call the getExchangeRate method and assert the result is as expected
        $result = $exchangeRateProvider->getExchangeRate("EUR", "USD");

        $this->assertEquals(1.2, $result);
    }

    public function testGetExchangeRateError()
    {
        // Create a mock response for a request with an error
        $mock = new MockHandler([
            new Response(500, [], '{"error": "Server Error"}'),
        ]);

        // Create a client with the mock handler
        $client = new Client(['handler' => $mock]);

        // Create an instance of the provider class and pass the client, url and apikey
        $exchangeRateProvider = new ExchangeRateProvider($client, "", "");

        // Expect an exception to be thrown when calling the getExchangeRate method
        $this->expectException(Exception::class);
        $exchangeRateProvider->getExchangeRate("EUR", "USD");
    }
}