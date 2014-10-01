<?php

namespace Blog\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class PostController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        $posts = $this->getDoctrine()->getRepository('ModelBundle:Post')->findAll();
        $latastPosts = $this->getDoctrine()->getRepository('ModelBundle:Post')->findLatest(3);

        return array(
            'posts'         => $posts,
            'latest_posts'  => $latastPosts
        );
    }

    /**
     * Show a post
     *
     * @param string $slug
     * @return array
     *
     * @Route("/{slug}")
     * @Template()
     * @throws NotFoundHttpException
     */
    public function showAction( $slug )
    {
        $post = $this->getDoctrine()->getRepository('ModelBundle:Post')->findOneBy(array( 'slug' => $slug ));
        if( $post === null )
            throw $this->createNotFoundException('Post was not found');



        return array(
            'post'         => $post,
        );
    }

}
