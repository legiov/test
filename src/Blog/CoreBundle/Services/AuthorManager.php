<?php

namespace Blog\CoreBundle\Services;

use Blog\ModelBundle\Entity\Author;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


/**
 * Class AuthorManager
 */
class AuthorManager
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
     * @return Author
     * @throws NotFoundHttpException
     */
    public function findBySlug( $slug )
    {
        $author = $this->em->getRepository('ModelBundle:Author')->findOneBy( array(
            'slug' => $slug
        ));

        if( null === $author )
            throw new NotFoundHttpException('Author was not found');

        return $author;
    }


}
