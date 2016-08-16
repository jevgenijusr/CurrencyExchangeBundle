<?php

namespace Jev\CurrencyExchangeBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('jev_currency_exchange');

        $rootNode
            ->children()
                ->arrayNode('base_currencies')
                    ->prototype('scalar')->end()
                ->end()
                ->arrayNode('foreign_currencies')
                        ->prototype('scalar')->end()
                ->end()            
            ->end()
        ;


        return $treeBuilder;
    }
}
