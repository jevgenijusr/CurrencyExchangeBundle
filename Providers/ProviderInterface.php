<?php

namespace Jev\CurrencyExchangeBundle\Providers;

interface ProviderInterface
{
    const NO_RATE_ERROR = 'No such rate exist';
    
    /**
     * Get all rates for specific base currency
     * 
     * @param $baseCurrency
     * @param \DateTime $date
     * @return mixed
     */
    public function getRates($baseCurrency, \DateTime $date);


    /**
     * Return rates for specific foreign currency
     * 
     * @param $rates
     * @param $baseCurrency
     * @param $foreignCurrency
     * @return mixed
     */
    public function filterRates($rates, $baseCurrency, $foreignCurrency);

    /**
     * Get currency provider name
     * 
     * @return string
     */
    public function getName();      
}
