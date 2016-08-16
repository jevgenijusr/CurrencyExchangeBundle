<?php

namespace Jev\CurrencyExchangeBundle\Services;

use Jev\CurrencyExchangeBundle\Providers\ProviderInterface;

class CurrencyRatesManager
{
    private $providers;
    
    private $baseCurrencies;
    
    private $foreignCurrencies;

    public function __construct($baseCurrencies, $foreignCurrencies)
    {
        $this->providers = array();
        $this->baseCurrencies = $baseCurrencies;
        $this->foreignCurrencies = $foreignCurrencies;
    }

    public function addProvider(ProviderInterface $provider)
    {
        $this->providers[] = $provider;
    }
    
    public function getProviders()
    {
        return $this->providers;
    }
    
    public function getBaseCurrencies()
    {
        return $this->baseCurrencies;
    }
    
    public function getForeignCurrencies()
    {
        return $this->foreignCurrencies;
    }
    
    public function getBestRate($baseCurrency, $foreignCurrency)
    {
        $result = array();
        foreach ($this->providers as $provider) {
            $rates = $provider->getRates();
            foreach ($rates as $currencyRate) {
                if($currencyRate['base'] != $baseCurrency) continue;
                foreach ($currencyRate['rates'] as $key => $rate) {
                    if($key != $foreignCurrency) continue;
                    $result[$provider->getName()] = $rate;
                }
            }
        }

        $max = max($result);
        $provider = array_search($max, $result);
        
        return array('provider' => $provider, 'rate' => $max);
    }
}
