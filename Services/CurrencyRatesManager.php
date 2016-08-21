<?php

namespace Jev\CurrencyExchangeBundle\Services;

use Jev\CurrencyExchangeBundle\Providers\ProviderInterface;
use Doctrine\Common\Cache\CacheProvider;

class CurrencyRatesManager
{
    private $providers;
    
    private $baseCurrencies;
    
    private $foreignCurrencies;
    
    private $cache;

    public function __construct($baseCurrencies, $foreignCurrencies, CacheProvider $cache)
    {
        $this->providers = array();
        $this->baseCurrencies = $baseCurrencies;
        $this->foreignCurrencies = $foreignCurrencies;
        $this->cache = $cache;
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
            $result[$provider->getName()] = $this->getRates($provider, $baseCurrency, $foreignCurrency);
        }

        $max = max($result);
        $provider = array_search($max, $result);
        
        return array('provider' => $provider, 'rate' => $max);
    }

    /**
     * Gets rates from specific provider
     * 
     * @param ProviderInterface $provider
     * @param bool $date false if current date
     * @return array
     */
    public function getRates(ProviderInterface $provider, $baseCurrency, $foreignCurrency, $date = false)
    {
        if(!$date) {
            $date = new \DateTime('now');
        }
        
        $key = $date->format('Y-m-d') . '|' . $provider->getName() . '|' . $baseCurrency;

        if(!$rates = unserialize($this->cache->fetch($key)))
        {
            $rates = $provider->getRates($baseCurrency, $date);
            $this->cache->save($key, serialize($rates), 10800);
        }

        return $provider->filterRates($rates, $baseCurrency, $foreignCurrency);
    }

}
