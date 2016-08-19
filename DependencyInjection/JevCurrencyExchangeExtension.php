<?php

namespace Jev\CurrencyExchangeBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class JevCurrencyExchangeExtension extends Extension implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $this->addCurrencyRateServices($container, $config);
    }
    
    private function addCurrencyRateServices(ContainerBuilder $container, $config)
    {
        $container
            ->register(
                'guzzle.client',
                'GuzzleHttp\Client'
            )
        ;

        $container
            ->register(
                'jev_currency_exchange.cache_provider',
                'Doctrine\Common\Cache\PhpFileCache'
            )
            ->addArgument("%kernel.cache_dir%/jevgenijus/currency")
            ->addArgument(".jevgenijus.currency_cache.php")
        ;   

        $container
            ->register(
                'app.currency_provider.some_provider',
                'Jev\CurrencyExchangeBundle\Providers\SomeProvider'
            )
            ->addArgument(new Reference('guzzle.client'))            
            ->addTag('currency.provider')
        ;

        $container
            ->register(
                'app.currency_provider.some_other_provider',
                'Jev\CurrencyExchangeBundle\Providers\SomeOtherProvider'
            )
            ->addArgument(new Reference('guzzle.client'))
            ->addTag('currency.provider')
        ;

        $container
            ->register(
                'app.currency_provider.yet_another_provider',
                'Jev\CurrencyExchangeBundle\Providers\YetAnotherProvider'
            )
            ->addTag('currency.provider')
        ;

        $container
            ->register(
                'app.currency_rates_manager',
                'Jev\CurrencyExchangeBundle\Services\CurrencyRatesManager'
            )
            ->addArgument($config['base_currencies'])
            ->addArgument($config['foreign_currencies'])
            ->addArgument(new Reference('jev_currency_exchange.cache_provider'))
        ;        

        $container
            ->register(
                'app.currency_rates_command',
                'Jev\CurrencyExchangeBundle\Command\CurrencyRatesCommand'
            )
            ->addArgument(new Reference('app.currency_rates_manager'))
            ->addTag('console.command')
        ;

        $container
            ->register(
                'app.currency_rates_best_command',
                'Jev\CurrencyExchangeBundle\Command\CurrencyRateBestCommand'
            )
            ->addArgument(new Reference('app.currency_rates_manager'))
            ->addTag('console.command')
        ;
    }

    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('app.currency_rates_manager')) {
            return;
        }

        $currencyRatesManagerDefinition = $container
            ->findDefinition('app.currency_rates_manager');

        $taggedServiceIds = $container->findTaggedServiceIds('currency.provider');

        foreach ($taggedServiceIds as $serviceId => $tags) {

            $currencyRatesManagerDefinition
                ->addMethodCall(
                    'addProvider',
                    array(new Reference($serviceId))
                );

        }
    }
}
