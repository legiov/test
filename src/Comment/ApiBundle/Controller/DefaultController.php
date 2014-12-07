<?php

namespace Comment\ApiBundle\Controller;

use Comment\ModelBundle\Entity\Comment;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View as FOSview;
use JMS\Serializer\SerializationContext;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class DefaultController extends FOSRestController
{

    /**
     * Return Comment by id
     *
     * @return FOSview
     * @ApiDoc(
     *  resource=true,
     *  description="function return comment by id"
     * )
     */
    public function getCommentAction( Comment $id )
    {

        $view = $this->setGroup( $id );

        return $this->handleView( $view );
    }

    /**
     * Return all Comments
     *
     * @return FOSview
     * @ApiDoc(
     *  resource=true,
     *  description="function return all comment"
     * )
     */
    public function getCommentsAction()
    {
        $data = $this->getDoctrine()->getRepository( 'CommentModelBundle:Comment' )->findAll();


        $view = $this->setGroup( $data );

        return $this->handleView( $view );
    }

    /**
     * Return all Comments for post
     * @param integer $post post_id
     * @return FOSview
     * @ApiDoc(
     *  resource=true,
     *  description="function return all comment for post"
     * )
     */
    public function getPostCommentsAction( $post )
    {
        $data = $this->getDoctrine()->getRepository( 'CommentModelBundle:Comment' )->findBy( array(
            'comment_object' => $post
        ) );


        $view = $this->setGroup( $data );

        return $this->handleView( $view );
    }

    /**
     * Return count Comments for post
     * @param integer $post post_id
     * @return FOSview
     * @ApiDoc(
     *  resource=true,
     *  description="function return count comments for post"
     * )
     */
    public function getPostCommentsCountAction( $post )
    {
        $data = $this->getDoctrine()->getRepository( 'CommentModelBundle:Comment' )->countObjectComments( $post );

        $data = array(
            'count' => $data );
        $view = $this->setGroup( $data );

        return $this->handleView( $view );
    }

    /**
     * 
     * @param mixed $data
     * @param array $groups
     * @return FOSview
     */
    private function setGroup( $data, $groups = array(
        "all_user" ) )
    {
        $view    = $this->view( $data, 200 );
        $context = new SerializationContext();
        $context->setGroups( $groups );
        $view->setSerializationContext( $context );

        return $view;
    }

}
