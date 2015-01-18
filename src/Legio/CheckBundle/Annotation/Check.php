<?php

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
    private $value;
    private $type;


    public function __construct( $arguments )
    {
        $this->value = $arguments['value'];
        $this->type  = $arguments['type'];
    }
}
