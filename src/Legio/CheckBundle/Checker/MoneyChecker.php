<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Legio\CheckBundle\Checker;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Bundle\FrameworkBundle\Controller\ControllerResolver;

/**
 * Description of MoneyChecker
 *
 * @author Вадим
 */
class MoneyChecker implements CheckerInterface
{

    private $method;
    private $sc;
    private $controller;

    public function __construct( $method, $methodSet, SecurityContext $sc, $controller = NULL )
    {
        $this->sc         = $sc;
        $this->methodGet  = $method;
        $this->methodSet  = $methodSet;
        $this->controller = $controller;
    }

    public function check( $value )
    {
        if( $this->sc->getToken() )
        {
            $user   = $$this->sc->getToken()->getUser();
            $method = $this->method;
            $money  = $user->$method();

            if( $money < $value )
            {
                if( $this->controller )
                {
                    return $this->getController();
                }
                else
                {
                    throw new AccessDeniedException( "You don't have enough money for access on this page" );
                }
            }
            else
            {
                $this->pay( $value );
            }
        }
        else
        {
            throw new AccessDeniedException();
        }
    }

    public function pay( $value )
    {
        
    }

    public function getController()
    {
        $res = new ControllerResolver($container, $parser);
    }

}
