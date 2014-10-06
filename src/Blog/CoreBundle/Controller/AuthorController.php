<?php

namespace Blog\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class AuthorController
 *
 */
class AuthorController extends Controller
{
    /**
     * Show a author
     *
     * @param string $slug
     * @return array
     *
     * @Route("/author/{slug}")
     * @Template()
     * @throws NotFoundHttpException
     */
    public function showAction( $slug )
    {
        $author = $this->getDoctrine()->getRepository('ModelBundle:Author')->findOneBy(array( 'slug' => $slug ));
        if( $author === null )
            throw $this->createNotFoundException('Post was not found');

        $posts = $this->getDoctrine()->getRepository('ModelBundle:Post')->findBy(array( 'author' => $author ));

        return array(
            'author'        => $author,
            'posts'         => $posts,
        );
    }
}
