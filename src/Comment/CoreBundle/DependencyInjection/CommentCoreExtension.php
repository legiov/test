<?php

namespace Comment\CoreBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class CommentCoreExtension extends Extension implements PrependExtensionInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
    /**
     * Allow to prepend any extension configuration
     * @param ContainerBuilder $container
     */
    public function prepend( ContainerBuilder $container )
    {
        //get all bundles
        $bundles = $container->getParameter('kernel.bundles');
        
        if( isset( $bundles['DoctrineBundle'] ) )
        {
            //get our config
            $configuration = new Configuration();
            $configs = $container->getExtensionConfig( $this->getAlias() );
            $config = $this->processConfiguration($configuration, $configs);
            
            //prepare insert data
            $forInsert = array(
                'orm' => array(
                    'resolve_target_entities' => array(
                        'Comment\ModelBundle\Model\CommentObjectInterface' => $config['entity']['class']
                    )
                )
            );
            
            //insert our config to doctrine extension
            $container->prependExtensionConfig('doctrine', $forInsert);
            
        }
    }

}
