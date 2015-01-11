<?php

namespace Comment\CoreBundle\EventListener;

use Component\Comment\Model\CommentObjectValidator;
use Doctrine\Common\Annotations\FileCacheReader;
use Doctrine\Common\Util\ClassUtils;
use ReflectionClass;
use ReflectionObject;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

class AnnotationListener
{

    private $reader;
    private $annotation;

    public function __construct( FileCacheReader $reader, $annotation )
    {
        $this->reader     = $reader;
        $this->annotation = $annotation;
    }

    public function onKernelController( FilterControllerEvent $event )
    {
        $controller = $event->getController();

        if( !is_array( $controller ) )
        {
            return;
        }

        list( $controllerObject, $method ) = $controller;

        $classAnnotation = $this->reader->getClassAnnotation( new ReflectionClass( ClassUtils::getClass( $controllerObject ) ), $this->annotation );

        if( $classAnnotation )
        {
            // do something
        }

        $reflectionObject = new ReflectionObject( $controllerObject );
        $reflectionMethod = $reflectionObject->getMethod( $method );

        $methodAnnotation = $this->reader->getMethodAnnotation( $reflectionMethod, $this->annotation );

        if( $methodAnnotation )
        {
            $objName = $methodAnnotation->post;
            $request = $event->getRequest();
            $post = $request->get($objName);
            CommentObjectValidator::validObject($post);
        }
    }

}
