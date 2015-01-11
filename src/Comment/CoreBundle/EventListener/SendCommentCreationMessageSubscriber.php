<?php

namespace Comment\CoreBundle\EventListener;

use Comment\CoreBundle\Event\CommentEvent;
use Comment\CoreBundle\Event\CommentEvents;
use Component\Comment\Model\Comment;
use Swift_Mailer;
use Swift_Message;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Description of SendCommentCreationMessageSubscriber
 *
 * @author Вадим
 */
class SendCommentCreationMessageSubscriber implements EventSubscriberInterface
{

    private $mailer;

    public function __construct( Swift_Mailer $mailer )
    {
        $this->mailer = $mailer;
    }

    public static function getSubscribedEvents()
    {
        return array(
            CommentEvents::COMMENT_CREATE => 'onCommentCreate',
        );
    }

    public function onCommentCreate( CommentEvent $event )
    {
        $comment = $event->getComment();
        $this->sendNewCommentMessage($comment);
    }
    
    private function sendNewCommentMessage( Comment $comment )
    {
        $message = Swift_Message::newInstance()
                ->setSubject('New comment created')
                ->setFrom('sait@test.ru')
                ->setTo('admin@test.ru')
                ->setBody('New Comment created for post '. $comment->getCommentObject()->getId() );
        
        $this->mailer->send($message);
    }
        
}
