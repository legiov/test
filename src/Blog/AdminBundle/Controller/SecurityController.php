<?php

namespace Blog\AdminBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Class SecurityController
 */
class SecurityController extends Controller
{

    /**
     * login action
     *
     * @param Request $request curent request
     *
     * @Route("/login")
     * @Template()
     * @return array Description
     */
    public function loginAction( Request $request )
    {
        $session = $request->getSession();

        // get the login error if there is one
        if( $request->attributes->has( SecurityContextInterface::AUTHENTICATION_ERROR ) )
        {
            $error = $request->attributes->get(
            SecurityContextInterface::AUTHENTICATION_ERROR
            );
        }
        elseif( null !== $session && $session->has( SecurityContextInterface::AUTHENTICATION_ERROR ) )
        {
            $error = $session->get( SecurityContextInterface::AUTHENTICATION_ERROR );
            $session->remove( SecurityContextInterface::AUTHENTICATION_ERROR );
        }
        else
        {
            $error = '';
        }

        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get( SecurityContextInterface::LAST_USERNAME );

        return $this->render(
        'AdminBundle:Security:login.html.twig', array(
            // last username entered by the user
            'last_username' => $lastUsername,
            'error' => $error,
        )
        );
    }

    /**
     * @Route("/login_check")
     * @Template()
     */
    public function loginCheckAction()
    {}

}