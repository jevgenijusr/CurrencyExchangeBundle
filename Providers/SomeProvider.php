<?php

namespace Jev\CurrencyExchangeBundle\Providers;


class SomeProvider implements ProviderInterface
{
    public function getRates()
    {
        return 'foo';
    }
}