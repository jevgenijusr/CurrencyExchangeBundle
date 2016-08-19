<?php

namespace Jev\CurrencyExchangeBundle\Tests\Unit\DependencyInjection;

use Jev\CurrencyExchangeBundle\DependencyInjection\Configuration;
use Symfony\Component\Config\Definition\Processor;

class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    public function testConfiguration()
    {
        $processor = new Processor();
        $processorConfig = $processor->processConfiguration(new Configuration(), []);
        
        $expectedConfiguration = array(
            'base_currencies' => array('EUR', 'GBP'),

        );

        $this->assertEquals($expectedConfiguration, $processorConfig);
    }
}