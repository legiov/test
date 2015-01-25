<?php

namespace Legio\CheckBundle\Resolver;

use InvalidArgumentException;
use Legio\CheckBundle\Annotation\AnnotationInterface;
use Legio\CheckBundle\Checker\CheckerInterface;
use Legio\CheckBundle\Resolver\ResolverInterface;
use Legio\CheckBundle\Services\ControllerParser;
use Symfony\Bundle\FrameworkBundle\Controller\ControllerNameParser;
use Symfony\Bundle\FrameworkBundle\Controller\ControllerResolver;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Description of ControllerAnnotationResolver
 *
 * @author Вадим
 */
class ControllerAnnotationResolver implements ResolverInterface
{

    /**
     *
     * @var ContainerInterface
     */
    private $container;

    /**
     *
     * @var CheckerInterface
     */
    private $customChecker;
    private $parser;

    /**
     * 
     * @param ContainerInterface $container
     * @param CheckerInterface $customChecker
     */
    public function __construct( ContainerInterface $container, ControllerParser $parser, CheckerInterface $customChecker = NULL )
    {
        $this->container     = $container;
        $this->customChecker = $customChecker;
        $this->parser        = $parser;
    }

    /**
     * Call checker with annotated value
     * 
     * @param AnnotationInterface $annotation
     * @return array
     * @throws InvalidArgumentException
     */
    public function resolve( AnnotationInterface $annotation )
    {
        $name    = $annotation->getName();
        $checker = $this->container->get( 'legio_check.checker.' . $name );

        if( !($checker instanceof CheckerInterface ) )
            throw new InvalidArgumentException( 'Service for checker with name ' . $name . ' must implement CheckerInterface' );

        $controller = $checker->check( $annotation->getValue() );

        if( $controller )
            $controller = $this->parser->parse( $controller );

        return $controller;
    }

}
