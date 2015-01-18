<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Legio\CheckBundle\Resolver;

use Legio\CheckBundle\Annotation\AnnotationInterface;

/**
 *
 * @author Вадим
 */
interface ResolverInterface
{
    /**
     * resolve doomain logic from annatation
     * 
     * @param AnnotationInterface $annotation
     */
    public function resolve( AnnotationInterface $annotation );
}
