<?php

namespace Jev\CurrencyExchangeBundle\Providers;


class SomeProvider implements ProviderInterface
{
    private $rates = '
        [
            {"base":"EUR","date":"2016-08-15","rates":{"AUD":1.4577,"BGN":1.9558,"BRL":3.5463,"CAD":1.4446,"CHF":1.0893,"CNY":7.4203,"CZK":27.023,"DKK":7.4405,"GBP":0.86677,"HKD":8.6725,"HRK":7.4925,"HUF":309.49,"IDR":14641.33,"ILS":4.2585,"INR":74.7779,"JPY":112.97,"KRW":1229.06,"MXN":20.2774,"MYR":4.4757,"NOK":9.1752,"NZD":1.5498,"PHP":51.855,"PLN":4.2695,"RON":4.4594,"RUB":71.8869,"SEK":9.4601,"SGD":1.5025,"THB":38.701,"TRY":3.3007,"USD":1.118,"ZAR":14.9346}}, 
            {"base":"GBP","date":"2016-08-15","rates":{"AUD":1.6818,"BGN":2.2564,"BRL":4.0914,"CAD":1.6666,"CHF":1.2567,"CNY":8.5609,"CZK":31.177,"DKK":8.5842,"HKD":10.006,"HRK":8.6442,"HUF":357.06,"IDR":16892.0,"ILS":4.9131,"INR":86.272,"JPY":130.33,"KRW":1418.0,"MXN":23.394,"MYR":5.1637,"NOK":10.586,"NZD":1.788,"PHP":59.826,"PLN":4.9258,"RON":5.1448,"RUB":82.937,"SEK":10.914,"SGD":1.7334,"THB":44.65,"TRY":3.808,"USD":1.2898,"ZAR":17.23,"EUR":1.1537}} 
        ] 
        ';

    public function getRates()
    {
        $array = json_decode($this->rates, true);
        return $array;
    }

    public function getName()
    {
        return 'Provider #1';
    }
}