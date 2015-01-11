<?php

namespace Component\Comment\Model;

use Symfony\Component\Intl\Exception\NotImplementedException;


class CommentObjectValidator
{
    public static function validObject( $obj )
    {
        if( !is_object( $obj ) || !method_exists( $obj, 'getId' ) )
        {
            throw new NotImplementedException('Non correct object giving');
        }
    }
}
