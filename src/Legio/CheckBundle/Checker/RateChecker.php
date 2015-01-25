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
 * Description of RateChecker
 *
 * @author Вадим
 */
class RateChecker extends AbstractChecker implements CheckerInterface
{
    /**
     * Check user rate with configered get_method for get checked value
     * 
     * @param string $value
     * @return array | null
     * @throws AccessDeniedException
     */
    public function check( $value )
    {
        if( $this->sc->getToken() && !( $this->sc->getToken() instanceof AnonymousToken ) )
        {
            
            $user   = $this->sc->getToken()->getUser();
            $method = $this->methodGet;

            $rate  = call_user_func(array( $user, $method) );
            
            if( $rate < $value )
            {
                if( $this->controller )
                {
                    return $this->controller;
                }
                else
                {
                    throw new AccessDeniedException( "You don't have enough rate for access on this page" );
                }
            }
            
        }
        else
        {
            throw new AccessDeniedException();
        }
    }

}
