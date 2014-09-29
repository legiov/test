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

}
