<?php

namespace Blog\CoreBundle\Services;

use Blog\ModelBundle\Entity\Comment;
use Blog\ModelBundle\Entity\Post;
use Blog\ModelBundle\Form\CommentType;
use Doctrine\ORM\EntityManager;
use FOS\UserBundle\Model\UserInterface;
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
class PostManager
{

    private $em;
    private $formFactory;
    private $securityContext;
    private $aclProvider;

    /**
     * Construct
     * @param EntityManager $em
     */
    public function __construct( EntityManager $em, FormFactory $formFactory, SecurityContextInterface $sc, MutableAclProviderInterface $aclProvider )
    {
        $this->em              = $em;
        $this->formFactory     = $formFactory;
        $this->aclProvider     = $aclProvider;
        $this->securityContext = $sc;
    }

    /**
     *
     * @param string $slug
     * @return Post
     * @throws NotFoundHttpException
     */
    public function findBySlug( $slug )
    {
        $post = $this->em->getRepository( 'ModelBundle:Post' )->findOneBy( array(
            'slug' => $slug
                ) );

        if( null === $post )
            throw new NotFoundHttpException( 'Post was not found' );

        return $post;
    }

    /**
     * Find all posts
     * @return array|Post[]
     */
    public function findAll()
    {
        $posts = $this->em->getRepository( 'ModelBundle:Post' )->findAll();

        return $posts;
    }

    /**
     * Find latest posts
     *
     * @param int $num
     * @return array|Post[]
     */
    public function findLatest( $num )
    {
        $posts = $this->em->getRepository( 'ModelBundle:Post' )->findLatest( $num );

        return $posts;
    }

    /**
     * Create comment form and save form
     * @param Post $post
     * @param Request $request
     * 
     * @return boolean|FormInterface
     */
    public function createComment( Post $post, Request $request, $commentType )
    {

        $comment = new Comment();
        $comment->setPost( $post );

        $form = $this->formFactory->create( $commentType, $comment );

        $form->handleRequest( $request );


        if( $form->isValid() )
        {
            $post->addComment( $comment );


            $this->em->persist( $comment );
            $this->em->flush();

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

            return true;
        }

        return $form;
    }

}
