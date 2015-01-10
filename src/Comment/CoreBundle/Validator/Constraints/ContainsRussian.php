<?php

namespace Comment\CoreBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Description of ContainsRussian
 * @Annotation
 * @author Вадим
 */
class ContainsRussian extends Constraint
{
    public $message = 'Body can only contains russian simvols, your text - "%string%"';
}
