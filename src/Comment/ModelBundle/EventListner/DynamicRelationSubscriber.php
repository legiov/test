<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Comment\ModelBundle\EventListner;

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
    
    const COMMENT_ENTITY_PATH = "Comment\ModelBundle\Entity\Comment";
    
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
        
        $metadata->mapManyToOne( array(
            'targetEntity' => $this->resolveClass,
            'fieldName'    => 'comment_object',
            'inversedBy' => "comments",
            'joinColumn' => array(
                'name'  => $namingStrategy->joinKeyColumnName( 'comment_object' ),
                'referencedColumnName' => $namingStrategy->referenceColumnName(),
                'nullable' => 'false'
            )
            
        ));
    }

}
