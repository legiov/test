<?php

namespace Blog\CoreBundle\Controller;

use Blog\ModelBundle\Form\CommentType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Legio\CheckBundle\Annotation\Check;

/**
 * class PostController

 */
class PostController extends Controller
{

    /**
     * @Route("/", name="main_index")
     * @Template()
     */
    public function indexAction()
    {
        $posts       = $this->getPostManager()->findAll();
        $latastPosts = $this->getPostManager()->findLatest( 3 );

        return array(
            'posts'        => $posts,
            'latest_posts' => $latastPosts
        );
    }

    /**
     * Show a post
     *
     * @param string $slug
     * @return array
     * @Route("/{slug}")
     * @Template()
     * @Check(type="check_test", value="200")
     * @throws NotFoundHttpException
     */
    public function showAction( $slug )
    {
        $post = $this->getPostManager()->findBySlug( $slug );

        return array(
            'post' => $post,
        );
    }

    /**
     *
     * @return \Blog\CoreBundle\Services\PostManager
     */
    private function getPostManager()
    {
        return $this->get( 'blog.core.post_manager' );
    }

}
