<?php

namespace Comment\CoreBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Comment\ModelBundle\Entity\Comment;

/**
 * Description of CommentEvent
 *
 * @author Вадим
 */
class CommentEvent extends Event
{
    private $comment;
    
    public function __construct( Comment $comment )
    {
        $this->comment = $comment;
    }
    
    public function getComment()
    {
        return $this->comment;
    }
}

