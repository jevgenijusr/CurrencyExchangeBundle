<?php

namespace Jev\CurrencyExchangeBundle\Providers;

interface ProviderInterface
{
    public function getRates();
}