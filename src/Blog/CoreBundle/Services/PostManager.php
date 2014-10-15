<?php

namespace Blog\CoreBundle\Services;

use Blog\ModelBundle\Entity\Comment;
use Blog\ModelBundle\Entity\Post;
use Blog\ModelBundle\Form\CommentType;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Form\Test\FormInterface;


/**
 * Class AuthorManager
 */
class PostManager
{
    private $em;
    private $formFactory;

    /**
     * Construct
     * @param EntityManager $em
     */
    public function __construct( EntityManager $em, FormFactory $formFactory )
    {
        $this->em = $em;
        $this->formFactory = $formFactory;
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
     * @return array|Post[]
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
     * @return array|Post[]
     */
    public function findLatest($num)
    {
        $posts = $this->em->getRepository('ModelBundle:Post')->findLatest( $num );

        return $posts;
    }

    /**
     * Create comment form and save form
     * @param Post $post
     * @param Request $request
     * 
     * @return boolean|FormInterface
     */
    public function createComment( Post $post, Request $request )
    {
                
        $comment = new Comment();
        $comment->setPost($post);

        $form = $this->formFactory->create( new CommentType(), $comment );

        $form->handleRequest($request);


        if( $form->isValid() )
        {
            $post->addComment( $comment );


            $this->em->persist($comment);
            $this->em->flush();

            return true;

        }

        return $form;
    }

}
