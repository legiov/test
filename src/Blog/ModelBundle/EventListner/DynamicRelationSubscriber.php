<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Blog\ModelBundle\EventListner;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * Description of DinamicRelationSuscriber
 *
 * @author Вадим
 */
class DynamicRelationSubscriber implements EventSubscriber
{
    
    const COMMENT_ENTITY_PATH = "Blog\ModelBundle\Entity\Blog";
    
    private $resolveClass;
    
    public function __construct( $resolveClass )
    {
        $this->resolveClass = $resolveClass;
    }

    public function getSubscribedEvents()
    {
        return array(
            Events::loadClassMetadata,
        );
    }
    
    public function loadClassMetadata( LoadClassMetadataEventArgs $args )
    {
        /** @var $metadata ClassMetadata */
        $metadata = $args->getClassMetadata();
        
        if( $metadata->getName() != self::COMMENT_ENTITY_PATH )
            return;
        
        $namingStrategy = $args
                ->getEntityManager()
                ->getConfiguration()
                ->getNamingStrategy();
        
        $metadata->mapOneToMany( array(
            'targetEntity' => $this->resolveClass,
            'fieldName'    => 'comments',
            'mappedBy' => "comment_object",
            'cascade' => array('remove')
            
        ));
    }

}
