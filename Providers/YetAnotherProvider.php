<?php

namespace Jev\CurrencyExchangeBundle\Providers;


class YetAnotherProvider implements ProviderInterface
{
    public function getRates()
    {
        return 'baz';
    }
}