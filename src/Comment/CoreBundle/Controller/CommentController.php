<?php

namespace Comment\CoreBundle\Controller;

use Comment\ModelBundle\Entity\Comment;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Comment controller.
 *
 * @Route("/comment")
 */
class CommentController extends Controller
{

    /**
     * Lists all Comment entities.
     *
     * @Route("/object/{id}")
     * @Method("GET")
     * @Template()
     * @return array
     */
    public function commentsAction( $id, Request $request )
    {
        $em = $this->getDoctrine()->getManager();
        
        $object = $this->getManager()->findCommentObjectById( $id );
        
        $form = $this->getManager()->createComment( $object, $request );

        $comments = $em->getRepository( 'CommentModelBundle:Comment' )->findBy( array( 'commentObject' => $object ) );

        return array(
            'comments' => $comments,
            'object'   => $object,
            'form'     => $form->createView()
        );
    }
    /**
     * Lists all Comment entities.
     *
     * @Route("/")
     * @Method("GET")
     * @Template()
     * @return array
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository( 'CommentModelBundle:Comment' )->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Comment entity.
     * @param string $id
     * @Route("/{id}")
     * @Method("GET")
     * @Template()
     * @return array
     */
    public function showAction( $id )
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository( 'CommentModelBundle:Comment' )->find( $id );

        if( !$entity )
        {
            throw $this->createNotFoundException( 'Unable to find Comment entity.' );
        }

        $deleteForm = $this->createDeleteForm( $id );

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }
    
    /**
     * @param Request $request
     * @param string $id
     *
     * @return array
     *
     * @Method({"POST"})
     * @Route("/{id}/create_comment")
     * @Template("CoreBundle:Post:show.html.twig")
     */
    public function createAction( Request $request, $id )
    {
        $post = $this->getManager()->findCommentObjectById( $id );

        $form = $this->getManager()->createComment( $post, $request );
        
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
     * Displays a form to edit an existing Comment entity.
     * @param string $id
     * @Route("/{id}/edit")
     * @Method("GET")
     * @Template()
     * @return array
     */
    public function editAction( $id )
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository( 'CommentModelBundle:Comment' )->find( $id );

        if( !$entity )
        {
            throw $this->createNotFoundException( 'Unable to find Comment entity.' );
        }

        $editForm   = $this->createEditForm( $entity );
        $deleteForm = $this->createDeleteForm( $id );

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Creates a form to edit a Comment entity.
     *
     * @param Comment $entity The entity
     *
     * @return Form The form
     */
    private function createEditForm( Comment $entity )
    {
        $form = $this->createForm( $this->get( 'comment.model.comment_type' ), $entity, array(
            'action' => $this->generateUrl( 'comment_core_comment_update', array(
                'id' => $entity->getId() ) ),
            'method' => 'PUT',
                ) );

        return $form;
    }

    /**
     * Edits an existing Comment entity.
     * @param string $id
     * @Route("/{id}")
     * @Method("PUT")
     * @Template("ModelBundle:Comment:edit.html.twig")
     * @return array
     */
    public function updateAction( Request $request, $id )
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository( 'CommentModelBundle:Comment' )->find( $id );

        if( !$entity )
        {
            throw $this->createNotFoundException( 'Unable to find Comment entity.' );
        }

        $securityContext = $this->get( 'security.context' );

        if( false === $securityContext->isGranted( 'EDIT', $entity ) )
        {
            throw new AccessDeniedException();
        }

        $deleteForm = $this->createDeleteForm( $id );
        $editForm   = $this->createEditForm( $entity );
        $editForm->handleRequest( $request );

        if( $editForm->isValid() )
        {
            $em->flush();

            return $this->redirect( $this->generateUrl( 'blog_core_post_show', array(
                                'slug' => $entity->getCommentObject()->getSlug() ) ) );
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Comment entity.
     * @param Request $request
     * @param string $id
     * 
     * @Route("/{id}")
     * @Method("DELETE")
     * 
     * @return array
     */
    public function deleteAction( Request $request, $id )
    {
        $form = $this->createDeleteForm( $id );
        $form->handleRequest( $request );

        $url = null;
        if( $form->isValid() )
        {
            $em     = $this->getDoctrine()->getManager();
            $entity = $em->getRepository( 'CommentModelBundle:Comment' )->find( $id );

            if( !$entity )
            {
                throw $this->createNotFoundException( 'Unable to find Comment entity.' );
            }

            $securityContext = $this->get( 'security.context' );
            if( false === $securityContext->isGranted( 'DELETE', $entity ) )
            {
                throw new AccessDeniedException();
            }

            $em->remove( $entity );
            $em->flush();
            $url = $this->generateUrl( 'blog_core_post_show', array(
                'slug' => $entity->getCommentObject()->getSlug() )
            );
        }
        $url ? $url : $ure = $this->generateUrl( 'blog_core_post_index' );

        return $this->redirect( $url );
    }

    /**
     * Creates a form to delete a Comment entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return Form The form
     */
    private function createDeleteForm( $id )
    {
        return $this->createFormBuilder()
                        ->setAction( $this->generateUrl( 'comment_core_comment_delete', array(
                                    'id' => $id ) ) )
                        ->setMethod( 'DELETE' )
                        ->add( 'submit', 'submit', array(
                            'label' => 'Delete' ) )
                        ->getForm()
        ;
    }
    
    public function getManager()
    {
        return $this->get('comment.manager');
    }

}
