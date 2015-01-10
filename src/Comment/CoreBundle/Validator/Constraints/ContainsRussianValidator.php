<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Comment\CoreBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Description of ContainsRussianValidator
 * 
 * @author Вадим
 */
class ContainsRussianValidator extends ConstraintValidator
{

    public function validate( $value, Constraint $constraint )
    {
        if( !preg_match( '/^[\p{Cyrillic}\p{P}\s]+$/u', $value, $matches ) )
        {
            $this->context->addViolation( 
                $constraint->message,
                array(
                    '%string%' => $value
                ) 
            );
        }
    }

}
