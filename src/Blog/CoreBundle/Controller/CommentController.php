<?php

namespace Blog\CoreBundle\Controller;

use Blog\ModelBundle\Entity\Comment;
use Blog\ModelBundle\Form\CommentType;
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
     * @Route("/")
     * @Method("GET")
     * @Template()
     * @return array
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository( 'ModelBundle:Comment' )->findAll();

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

        $entity = $em->getRepository( 'ModelBundle:Comment' )->find( $id );

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

        $entity = $em->getRepository( 'ModelBundle:Comment' )->find( $id );

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
        $form = $this->createForm( $this->get( 'blog.model.comment_type' ), $entity, array(
            'action' => $this->generateUrl( 'blog_core_comment_update', array(
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

        $entity = $em->getRepository( 'ModelBundle:Comment' )->find( $id );

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
                                'slug' => $entity->getPost()->getSlug() ) ) );
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
            $entity = $em->getRepository( 'ModelBundle:Comment' )->find( $id );

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
                'slug' => $entity->getPost()->getSlug() )
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
                        ->setAction( $this->generateUrl( 'blog_core_comment_delete', array(
                                    'id' => $id ) ) )
                        ->setMethod( 'DELETE' )
                        ->add( 'submit', 'submit', array(
                            'label' => 'Delete' ) )
                        ->getForm()
        ;
    }

}
