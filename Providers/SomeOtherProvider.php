<?php

namespace Jev\CurrencyExchangeBundle\Providers;


class SomeOtherProvider implements ProviderInterface
{
    public function getRates()
    {
        return 'bar';
    }
}