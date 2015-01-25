<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Legio\CheckBundle\Checker;

use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Description of MoneyChecker
 *
 * @author Вадим
 */
class MoneyChecker extends AbstractChecker implements CheckerInterface
{

    /**
     * Check user enough money for access page and write off money if enough
     * throw access denied exception if user hasn't enough money
     * 
     * @param string $value
     * @return string configured controller's action
     * @throws AccessDeniedException
     */
    public function check( $value )
    {
        
        if( $this->sc->getToken() && !( $this->sc->getToken() instanceof AnonymousToken ) )
        {
            
            $user   = $this->sc->getToken()->getUser();
            $method = $this->methodGet;

            $money  = call_user_func(array( $user, $method) );
            
            if( $money < $value )
            {
                if( $this->controller )
                {
                    return $this->controller;
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

    /**
     * write off money with configured method
     * 
     * @param string $value
     */
    public function pay( $value )
    {
        $this->methodSet( $value );
    }


}
