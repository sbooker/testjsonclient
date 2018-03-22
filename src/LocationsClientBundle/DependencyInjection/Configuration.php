<?php

declare(strict_types=1);

namespace LocationsClientBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('locations_client');

        $rootNode
            ->children()
                ->enumNode('http_client')
                ->isRequired()
                    ->values(['guzzle'])
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}