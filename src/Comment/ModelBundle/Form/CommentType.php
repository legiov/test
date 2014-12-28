<?php

namespace Comment\ModelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class CommentType extends AbstractType
{

    private $securityContext;

    public function __construct( SecurityContextInterface $sc )
    {
        $this->securityContext = $sc;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm( FormBuilderInterface $builder, array $options )
    {
        $builder
                ->add( 'authorName', null, array(
                    'label' => 'blog.core.comment.author' ) )
                ->add( 'body', null, array(
                    'label' => 'blog.core.comment.comment' ) )
                ->add( 'send', 'submit', array(
                    'label' => 'blog.core.comment.send' ) )
        ;
        $sc = $this->securityContext;
        $builder->addEventListener(
                FormEvents::POST_SET_DATA, function( FormEvent $event ) use ( $sc )
                {
                    
                    $user = $sc ? $sc->getToken()->getUser() : null;

                    if( $user instanceof UserInterface )
                    {
                        $form = $event->getForm();
                        $form->remove( 'authorName' )
                                ->add( 'authorName', 'hidden', array(
                                    'data' => $user->getName()
                                        )
                        );
                    }
                }
        );
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions( OptionsResolverInterface $resolver )
    {
        $resolver->setDefaults( array(
            'data_class' => 'Comment\ModelBundle\Entity\Comment'
        ) );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'comment_modelbundle_comment';
    }

}
