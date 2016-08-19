<?php

namespace Jev\CurrencyExchangeBundle\Providers;


class YetAnotherProvider implements ProviderInterface
{
    private $rates = '
        [
            {"base":"GBP","date":"2012-01-03","rates":{"AUD":1.5082,"BGN":2.342,"BRL":2.8822,"CAD":1.5771,"CHF":1.4589,"CNY":9.8121,"CZK":30.76,"DKK":8.9043,"HKD":12.107,"HRK":9.0241,"HUF":377.86,"IDR":14391.0,"ILS":5.9491,"INR":82.781,"JPY":119.58,"KRW":1791.4,"LTL":4.1346,"LVL":0.83738,"MXN":21.508,"MYR":4.8925,"NOK":9.2624,"NZD":1.9807,"PHP":68.152,"PLN":5.3579,"RON":5.1712,"RUB":49.479,"SEK":10.691,"SGD":2.0042,"THB":48.995,"TRY":2.9344,"USD":1.5584,"ZAR":12.564,"EUR":1.1975}}, 
            {"base":"EUR","date":"2012-01-03","rates":{"AUD":1.2595,"BGN":1.9558,"BRL":2.4069,"CAD":1.317,"CHF":1.2183,"CNY":8.1941,"CZK":25.688,"DKK":7.436,"GBP":0.8351,"HKD":10.1102,"HRK":7.536,"HUF":315.55,"IDR":12017.7,"ILS":4.9681,"INR":69.13,"JPY":99.86,"KRW":1496.0,"LTL":3.4528,"LVL":0.6993,"MXN":17.9613,"MYR":4.0857,"NOK":7.735,"NZD":1.6541,"PHP":56.914,"PLN":4.4744,"RON":4.3185,"RUB":41.3199,"SEK":8.9283,"SGD":1.6737,"THB":40.916,"TRY":2.4505,"USD":1.3014,"ZAR":10.4925}} 
        ] 
        ';

    public function getRates($baseCurrency, \DateTime $date)
    {
        $array = json_decode($this->rates, true);
        return $array;
    }


    public function filterRates($rates, $baseCurrency, $foreignCurrency)
    {
        return self::NO_RATE_ERROR;
    }

    public function getName()
    {
        return 'SOME DURP PROVIDER'; //http://www.urbandictionary.com/define.php?term=durp
    }
}