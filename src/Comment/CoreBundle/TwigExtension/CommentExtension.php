<?php

namespace Comment\CoreBundle\TwigExtension;

use Symfony\Component\HttpKernel\Controller\ControllerReference;
use Symfony\Component\HttpKernel\Fragment\FragmentHandler;
use Twig_Extension;
use Twig_SimpleFunction;

/**
 * Description of CommentExtension
 *
 * @author Вадим
 */
class CommentExtension extends Twig_Extension
{

    private $handler;

    public function __construct( FragmentHandler $fh )
    {
        $this->handler = $fh;
    }

    public function getName()
    {
        return 'comment_twig_extension';
    }

    public function getFunctions()
    {
        $_this = $this;
        return array(
            new Twig_SimpleFunction( 'comments_show', function( $post ) use ( $_this )
                    {
                        return $_this->render( 'comments', $post );
                    }, array(
                        'is_safe' => array('html')
                    ) ),
            new Twig_SimpleFunction( 'comments_count', function( $post ) use ( $_this )
                    {
                        return $_this->render( 'commentsCount', $post );
                    }, array(
                        'is_safe' => array('html')
                    ) ),
        );
    }

    public function render( $method, $post )
    {
        $uri = new ControllerReference( 'CommentCoreBundle:Comment:' . $method, array(
            'id' => $post->getId()
                )
        );

        return $this->handler->render( $uri );
    }

}
