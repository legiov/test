<?php

namespace Legio\CheckBundle\DependencyInjection;

use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\ControllerNameParser;
use Symfony\Bundle\FrameworkBundle\Controller\ControllerResolver;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class LegioCheckExtension extends Extension
{

    /**
     * {@inheritDoc}
     */
    public function load( array $configs, ContainerBuilder $container )
    {
        $configuration = new Configuration();
        $config        = $this->processConfiguration( $configuration, $configs );



        $loader = new Loader\YamlFileLoader( $container, new FileLocator( __DIR__ . '/../Resources/config' ) );
        $loader->load( 'services.yml' );


        if( isset( $config[ 'check_types' ] ) && !empty( $config[ 'check_types' ] ) )
        {
            foreach( $config[ 'check_types' ] as $name => $checkerConfiguration )
            {
                $this->setCheckerService( $name, $checkerConfiguration, $container );
            }
        }
    }

    private function setCheckerService( $name, $config, ContainerBuilder $container )
    {
        $this->validateData( $config, $name, $container );
        $type = $config[ 'type' ];

        if( $type != 'custom' )
        {
            $class      = $container->getParameter( 'legio_check.checker.' . $type . '.class' );
            $definition = new Definition( $class );
            $definition->addArgument( $config[ 'get_method' ] );
            if( isset( $config[ 'set_method' ] ) )
            {
                $definition->addArgument( $config[ 'set_method' ] );
            }
            $definition->addArgument( new Reference( 'security.context' ) );
            if( isset( $config[ 'controller' ] ) )
            {
                $definition->addArgument( $this->parseController( $config[ 'controller' ], $container ) );
            }

            $container->setDefinition( 'legio_check.checker.' . $name, $definition );
        }
        else
        {
            //@todo custom service
        }
    }

    private function validateData( $config, $name, ContainerBuilder $container )
    {
        if( $config[ 'type' ] == 'custom' )
        {
            if( !isset( $config[ 'checker' ] ) || empty( $config[ 'checker' ] ) )
            {
                throw new InvalidArgumentException( 'The "checker" must be configured for ' . $name );
            }
        }
    }

    private function parseController( $controller, ContainerBuilder $container )
    {
        // return;
        $parser = new ControllerNameParser( $container->get( 'kernel' ) );

        return $parser->parse( $controller );
    }

}
