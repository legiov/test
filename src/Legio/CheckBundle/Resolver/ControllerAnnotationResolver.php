<?php

namespace Legio\CheckBundle\Resolver;

use InvalidArgumentException;
use Legio\CheckBundle\Annotation\AnnotationInterface;
use Legio\CheckBundle\Checker\CheckerInterface;
use Legio\CheckBundle\Resolver\ResolverInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Description of ControllerAnnotationResolver
 *
 * @author Вадим
 */
class ControllerAnnotationResolver implements ResolverInterface
{

    private $container;
    private $customChecker;

    public function __construct( ContainerInterface $container, CheckerInterface $customChecker = NULL )
    {
        $this->container     = $container;
        $this->customChecker = $customChecker;
    }

    public function resolve( AnnotationInterface $annotation )
    {
        $name    = $annotation->getName();
        $checker = $this->container->get( 'legio_check.checker.' . $name );

        if( !($checker instanceof CheckerInterface ) )
            throw new InvalidArgumentException( 'Service for checker with name '. $name .' must implement CheckerInterface' );

        $controller = $checker->check( $annotation->getValue() );

        return $controller;
    }

}
