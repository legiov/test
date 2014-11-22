<?php

namespace Blog\CoreBundle\Services;


use Blog\ModelBundle\Entity\Post;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Acl\Model\MutableAclProviderInterface;
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


}
