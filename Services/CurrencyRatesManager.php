<?php

namespace Jev\CurrencyExchangeBundle\Services;

use Jev\CurrencyExchangeBundle\Providers\ProviderInterface;

class CurrencyRatesManager
{
    private $providers;

    public function __construct()
    {
        $this->providers = array();
    }

    public function addProvider(ProviderInterface $provider)
    {
        $this->providers[] = $provider;
    }
    
    public function getProviders()
    {
        return $this->providers;
    }
}
