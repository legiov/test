<?php

namespace Blog\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('BlogTestBundle:Default:index.html.twig', array('name' => $name));
    }
}
