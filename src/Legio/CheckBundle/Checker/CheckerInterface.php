<?php

namespace Legio\CheckBundle\Checker;

/**
 *
 * @author Вадим
 */
interface CheckerInterface
{

    /**
     * Check value with configured checker
     * 
     * @param string $value
     */
    public function check( $value );
}
