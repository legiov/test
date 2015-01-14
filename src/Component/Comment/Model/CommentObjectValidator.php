<?php

namespace Component\Comment\Model;

use InvalidArgumentException;

class CommentObjectValidator
{
    public static function validObject( $obj )
    {
        if( !is_object( $obj ) || !method_exists( $obj, 'getId' ) )
        {
            throw new InvalidArgumentException('Non correct object giving');
        }
        
        return $obj;
    }
}
