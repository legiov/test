<?php

namespace Legio\CheckBundle\Listener;

use Doctrine\Common\Annotations\FileCacheReader;
use Legio\CheckBundle\Resolver\ControllerAnnotationResolver;
use ReflectionMethod;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

/**
 * Description of ControllerAnnotationListener
 *
 * @author Вадим
 */
class ControllerAnnotationListener
{

    private $annotationReader;
    private $annotationClass;
    private $resolver;

    public function __construct( FileCacheReader $annotationReader, $annotationClass, ControllerAnnotationResolver $resolver )
    {
        $this->annotationReader = $annotationReader;
        $this->annotationClass  = $annotationClass;
        $this->resolver         = $resolver;
    }

    public function onKernelController( FilterControllerEvent $event )
    {
        $controller = $event->getController();
        if( !is_array( $controller ) )
        {
            return;
        }

        $action = new ReflectionMethod( $controller[ 0 ], $controller[ 1 ] );

        $annotation = $this->annotationReader->getMethodAnnotation( $action, $this->annotationClass );

        if( get_class( $annotation ) != $this->annotationClass )
        {
            return;
        }
          
        $newController = $this->resolver->resolve( $annotation );
        
        if( !empty( $newController ) )
        {
            $event->setController( $newController );
        }
    }

}
