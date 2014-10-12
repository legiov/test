<?php

namespace Blog\CoreBundle\Controller;

use Blog\ModelBundle\Form\CommentType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class PostController extends Controller
{
    /**
     * @Route("/", name="main_index")
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

        $form = $this->createForm( new CommentType() );

        return array(
            'post'      => $post,
            'form'      => $form->createView()      
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
        $post = $this->getDoctrine()->getRepository('ModelBundle:Post')->findOneBy(array( 'slug' => $slug ));
        if( $post === null )
            throw $this->createNotFoundException('Post was not found');
        
        $comment = new \Blog\ModelBundle\Entity\Comment();

        $form = $this->createForm( new CommentType(), $comment );
        
        $form->handleRequest($request);
        
        if( $form->isValid() )
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();
            
            $this->redirect( $this->generateUrl('blog_core_post_show', array('slug'=>$post->getSlug())));
        }

        return array(
            'post'      => $post,
            'form'      => $form->createView()      
        );
    }

}
