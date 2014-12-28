<?php

namespace Comment\CoreBundle\Services;

use Comment\CoreBundle\Event\CommentEvent;
use Comment\CoreBundle\Event\CommentEvents;
use Comment\ModelBundle\Entity\Comment;
use Comment\ModelBundle\Form\CommentType;
use Doctrine\ORM\EntityManager;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\Test\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Model\MutableAclProviderInterface;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Class AuthorManager
 */
class Manager
{

    private $em;
    private $formFactory;
    private $securityContext;
    private $aclProvider;
    private $class;
    private $eventDispatcher;

    /**
     * Construct
     * @param EntityManager $em
     */
    public function __construct(
    EntityManager $em, FormFactory $formFactory, SecurityContextInterface $sc, MutableAclProviderInterface $aclProvider, EventDispatcherInterface $ed, $class
    )
    {
        $this->em              = $em;
        $this->formFactory     = $formFactory;
        $this->aclProvider     = $aclProvider;
        $this->securityContext = $sc;
        $this->eventDispatcher = $ed;
        $this->class           = $class;
    }

    /**
     *
     * @param string $id
     * @return Comment
     * @throws NotFoundHttpException
     */
    public function findCommentObjectById( $id )
    {
        $object = $this->em->getRepository( $this->class )->find( $id );

        if( null === $object ){
            throw new NotFoundHttpException( 'comment object was not found' );
        }

        return $object;
    }

    /**
     * Find all comments
     * @return array|array Comment
     */
    public function findAll()
    {
        $posts = $this->em->getRepository( 'CommentModelBundle:Comment' )->findAll();

        return $posts;
    }

    /**
     * Find latest comments
     *
     * @param int $num
     * @return array| array Comment
     */
    public function findLatest( $num )
    {
        $comments = $this->em->getRepository( 'CommentModelBundle:Comment' )->findLatest( $num );

        return $comments;
    }

    /**
     * Create comment form and save form
     * @param $object
     * @param Request $request
     * 
     * @return boolean|FormInterface
     */
    public function createComment( $object, Request $request, $commentForm )
    {
        $comment = new Comment();
        $comment->setCommentObject( $object );

        $form = $this->formFactory->create( $commentForm, $comment );

        $form->handleRequest( $request );

        if( $form->isValid() )
        {
            if( $object )
                $object->addComment( $comment );


            $this->em->persist( $comment );
            $this->em->flush();

            $this->eventDispatcher->dispatch( CommentEvents::COMMENT_CREATE, new CommentEvent( $comment ) );

            $user = $this->securityContext->getToken()->getUser();

            if( $user instanceof UserInterface )
            {
                //create ACL
                $objectIdentity = ObjectIdentity::fromDomainObject( $comment );
                $acl            = $this->aclProvider->createAcl( $objectIdentity );

                //securIdentity
                $securityIdentity = UserSecurityIdentity::fromAccount( $user );
                $acl->insertObjectAce( $securityIdentity, MaskBuilder::MASK_OWNER );

                $this->aclProvider->updateAcl( $acl );
            }

            return $comment;
        }

        return $form;
    }

}
