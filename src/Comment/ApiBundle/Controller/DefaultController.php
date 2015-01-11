<?php

namespace Comment\ApiBundle\Controller;

use Comment\ModelBundle\Entity\Comment;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View as FOSview;
use JMS\Serializer\SerializationContext;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;

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
     * Create comment for post
     * 
     * @return FOSview
     * @ApiDoc(
     *  resource=true,
     *  description="function create comment for post and return comment",
     *  input="comment_api_form",
     *  output={
     *      "class"="Component\Comment\Model\Comment",
     *      "groups"={"all_user"},
     *      "parsers"={
     *          "Nelmio\ApiDocBundle\Parser\JmsMetadataParser"
     *      }
     *  },
     *  statusCodes={
     *      "201"="comment successful created",
     *      "400"="bad request"
     *  }
     * )
     */
    public function postCommentAction( Request $request )
    {
        /* @var $manager \Comment\CoreBundle\Services\Manager */
        $manager = $this->get( 'comment.manager' );

        $data = $manager->createComment( null, $request, 'comment_api_form' );

        if( $data instanceof Comment )
        {
            $view = $this->setGroup( $data );
            $view->setStatusCode( 201 );
        }
        else
        {
            $view = FOSview::create( $data );
        }
        return $this->handleView( $view );
    }

    /**
     * Delete comment by id
     * 
     * @return FOSview
     * @ApiDoc(
     *  resource=true,
     *  description="function delete comment by id",
     *  statusCodes={
     *      "200"="comment successful delete",
     *      "400"="bad request"
     *  }
     * )
     */
    public function deleteCommentAction( $id )
    {
        $view    = $this->view( array(
            'message' => 'Comment was deleted' ), 200 );
        $comment = $this->getDoctrine()->getRepository( 'CommentModelBundle:Comment' )->find( $id );

        if( $comment )
        {
            $em = $this->getDoctrine()->getManager();
            $em->remove( $comment );
            $em->flush();
        }
        else
            $view = $this->view( array(
                'Comment not found' ), 404 );

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
