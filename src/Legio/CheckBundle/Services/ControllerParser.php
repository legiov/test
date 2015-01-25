<?php

namespace Legio\CheckBundle\Services;

use Symfony\Bundle\FrameworkBundle\Controller\ControllerNameParser;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Description of ControllerParser
 *
 * @author Вадим
 */
class ControllerParser
{
    private $container;
    
    public function __construct( ContainerInterface $container )
    {
        $this->container = $container;
    }
    
    /**
     * parse controller name like Acme:DemoBundle:index
     * 
     * @param string $controllerName
     * @return array
     * @throws InvalidArgumentException
     */
    public function parse( $controllerName )
    {
        $parser = new ControllerNameParser( $this->container->get( 'kernel' ) );
        
        $controller = $parser->parse($controllerName );
        
        list($class, $method) = explode('::', $controller, 2);

        if (!class_exists($class)) {
            throw new InvalidArgumentException(sprintf('Class "%s" does not exist.', $class));
        }

        $controller = new $class();
        
        $controller->setContainer($this->container);
        

        return array($controller, $method);
    }
}
