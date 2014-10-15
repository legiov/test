<?php

namespace Blog\CoreBundle\Services;

use Blog\ModelBundle\Entity\Post;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


/**
 * Class AuthorManager
 */
class PostManager
{
    private $em;

    /**
     * Construct
     * @param EntityManager $em
     */
    public function __construct( EntityManager $em )
    {
        $this->em = $em;
    }

    /**
     *
     * @param string $slug
     * @return Post
     * @throws NotFoundHttpException
     */
    public function findBySlug( $slug )
    {
        $post = $this->em->getRepository('ModelBundle:Post')->findOneBy( array(
            'slug' => $slug
        ));

        if( null === $post )
            throw new NotFoundHttpException('Post was not found');

        return $post;
    }

    /**
     * Find all posts
     * @return array|\Blog\ModelBundle\Entity\Post[]
     */
    public function findAll()
    {
        $posts = $this->em->getRepository('ModelBundle:Post')->findAll();

        return $posts;
    }

    /**
     * Find latest posts
     *
     * @param int $num
     * @return array|\Blog\ModelBundle\Entity\Post[]
     */
    public function findLatest($num)
    {
        $posts = $this->em->getRepository('ModelBundle:Post')->findLatest( $num );

        return $posts;
    }


}
