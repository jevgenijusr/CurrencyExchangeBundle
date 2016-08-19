<?php

namespace Jev\CurrencyExchangeBundle\Providers;

use GuzzleHttp\Client;

class SomeOtherProvider implements ProviderInterface
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getRates($baseCurrency, \DateTime $date)
    {
        $response = $this->client->get('http://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml');
        
        try {
            $xml = simplexml_load_string((string)$response->getBody(), 'SimpleXMLElement');
        } catch (\Exception $e) {
            throw new \Exception('Invalid response');
        }

        return json_encode($xml);
    }

    public function filterRates($rates, $baseCurrency, $foreignCurrency)
    {
        if($baseCurrency != 'EUR') {
            return self::NO_RATE_ERROR; //ECB provides only EUR as base currency
        }
            
        $result = json_decode($rates, true);

        foreach ($result["Cube"]["Cube"]["Cube"] as $item) {

            if($item['@attributes']['currency'] == $foreignCurrency) {
                return $item['@attributes']['rate'];
            }
        }
        
        return self::NO_RATE_ERROR;
    }

    public function getName()
    {
        return 'European Central Bank';
    }
}
