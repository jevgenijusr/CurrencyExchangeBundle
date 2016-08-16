<?php

namespace Jev\CurrencyExchangeBundle\Providers;


class SomeOtherProvider implements ProviderInterface
{
    private $rates = '
        [
            {"base":"EUR","date":"2009-12-31","rates":{"AUD":1.6008,"BGN":1.9558,"BRL":2.5113,"CAD":1.5128,"CHF":1.4836,"CNY":9.835,"CZK":26.473,"DKK":7.4418,"EEK":15.6466,"GBP":0.8881,"HKD":11.1709,"HRK":7.3,"HUF":270.42,"IDR":13626.13,"INR":67.04,"JPY":133.16,"KRW":1666.97,"LTL":3.4528,"LVL":0.7093,"MXN":18.9223,"MYR":4.9326,"NOK":8.3,"NZD":1.9803,"PHP":66.507,"PLN":4.1045,"RON":4.2363,"RUB":43.154,"SEK":10.252,"SGD":2.0194,"THB":47.986,"TRY":2.1547,"USD":1.4406,"ZAR":10.666}}, 
            {"base":"GBP","date":"2009-12-31","rates":{"AUD":1.8025,"BGN":2.2022,"BRL":2.8277,"CAD":1.7034,"CHF":1.6705,"CNY":11.074,"CZK":29.809,"DKK":8.3795,"EEK":17.618,"HKD":12.578,"HRK":8.2198,"HUF":304.49,"IDR":15343.0,"INR":75.487,"JPY":149.94,"KRW":1877.0,"LTL":3.8879,"LVL":0.79867,"MXN":21.306,"MYR":5.5541,"NOK":9.3458,"NZD":2.2298,"PHP":74.887,"PLN":4.6217,"RON":4.7701,"RUB":48.591,"SEK":11.544,"SGD":2.2738,"THB":54.032,"TRY":2.4262,"USD":1.6221,"ZAR":12.01,"EUR":1.126}} 
        ] 
        ';
    
    public function getRates()
    {
        $array = json_decode($this->rates, true);
        return $array;
    }

    public function getName()
    {
        return 'Provider #2';
    }
}
