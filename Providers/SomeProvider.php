<?php

namespace Jev\CurrencyExchangeBundle\Providers;

use GuzzleHttp\Client;

class SomeProvider implements ProviderInterface
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getRates($baseCurrency, \DateTime $date)
    {
        try {
            $response = $this->client->get('http://api.fixer.io/' . $date->format('Y-m-d') . '?base=' . $baseCurrency);
        } catch (\Exception $e) {
            throw new \Exception('Invalid response');
        }

        return json_decode($response->getBody()->getContents(), true);
    }
    
    public function filterRates($rates, $baseCurrency, $foreignCurrency)
    {
        if(!isset($rates['rates'][$foreignCurrency])) {
            return self::NO_RATE_ERROR;
        }

        return $rates['rates'][$foreignCurrency];
    }

    public function getName()
    {
        return 'FIXER.IO';
    }
}