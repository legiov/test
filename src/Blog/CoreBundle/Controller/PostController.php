<?php

namespace Blog\CoreBundle\Controller;

use Blog\ModelBundle\Form\CommentType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
     *
     * @Route("/{slug}")
     * @Template()
     * @throws NotFoundHttpException
     */
    public function showAction( $slug )
    {
        $post = $this->getPostManager()->findBySlug( $slug );

        $form = $this->createForm( $this->get( 'blog.model.comment_type' ) );

        return array(
            'post' => $post,
            'form' => $form->createView()
        );
    }

    /**
     * @param Request $request
     * @param string $slug
     *
     * @return array
     *
     * @Method({"POST"})
     * @Route("/{slug}/create_comment")
     * @Template("CoreBundle:Post:show.html.twig")
     */
    public function createCommentAction( Request $request, $slug )
    {
        $post = $this->getPostManager()->findBySlug( $slug );

        $commentType = $this->get( 'blog.model.comment_type' );

        $form = $this->getPostManager()->createComment( $post, $request, $commentType );
        if( TRUE === $form )
        {
            $session = $this->get( 'session' );
            $session->getFlashBag()->add( 'success', 'Your comment was submited successfully' );
            return $this->redirect( $this->generateUrl( 'blog_core_post_show', array(
                                'slug' => $post->getSlug() ) ) . '#comments' );
        }
        return array(
            'post' => $post,
            'form' => $form->createView()
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
