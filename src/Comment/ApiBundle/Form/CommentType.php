<?php

namespace Comment\ApiBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class CommentType extends AbstractType
{

    private $objectClassss = 'Blog\ModelBundle\Entity\Post';

    public function __construct( $objectClass )
    {
        $this->objectClassss = $objectClass;
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
                ->add( 'comment_object', 'entity', array(
                        'class'     => $this->objectClassss,
                        'property'  => 'id'
                    ))
        ;
        
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions( OptionsResolverInterface $resolver )
    {
        $resolver->setDefaults( array(
            'data_class' => 'Component\Comment\Model\Comment',
            'csrf_protection' => false
        ) );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'comment_api_form';
    }

}
