<?php

namespace Blog\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class DefaultController
 *
 */
class DefaultController extends Controller
{
    /**
     * redirection
     * @Route("/")
     * @return type
     */
    public function indexAction()
    {
        return $this->redirect( $this->generateUrl('blog_admin_post_index'));
    }
}
