<?php

namespace Legio\CheckBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{

    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode    = $treeBuilder->root( 'legio_check' );

        $rootNode
            ->children()
                ->arrayNode( 'check_types' )
                    ->prototype( 'array' )
                        ->children()
                            ->scalarNode( 'checking_service' )->end()
                            ->scalarNode( 'data_field' )->end()
                            ->enumNode( 'type')
                                ->values( array('money','time_interval','rate', 'custom') )
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;


        return $treeBuilder;
    }

}
