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

    /**
     *
     * @var FileCacheReader
     */
    private $annotationReader;
    
    /**
     * 
     *
     * @var string
     */
    private $annotationClass;
    
    /**
     *
     * @var ControllerAnnotationResolver
     */
    private $resolver;

    public function __construct( FileCacheReader $annotationReader, $annotationClass, ControllerAnnotationResolver $resolver )
    {
        $this->annotationReader = $annotationReader;
        $this->annotationClass  = $annotationClass;
        $this->resolver         = $resolver;
    }

    /**
     * Listen kernel.controller event for find assigned annotation
     * 
     * @param FilterControllerEvent $event
     * @return null
     */
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
