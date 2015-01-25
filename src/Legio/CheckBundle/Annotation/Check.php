<?php

namespace Legio\CheckBundle\Annotation;

use Legio\CheckBundle\Annotation\AnnotationInterface;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * @Annotation
 */
class Check implements AnnotationInterface
{
    /**
     *
     * @var sting
     */
    private $value;
    /**
     *
     * @var string
     */
    private $type;


    /**
     * Construct
     * 
     * @param array $arguments
     */
    public function __construct( $arguments )
    {
        $this->value = $arguments['value'];
        $this->type  = $arguments['type'];
    }
    
    /**
     * return configured checker's name
     * 
     * @return string
     */
    public function getName()
    {
        return $this->type;
    }
    
    /**
     * return annotation value for check
     * 
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }
}
