<?php


namespace Legio\CheckBundle\Checker;

use DateTime;
use InvalidArgumentException;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Description of TimeChecker
 *
 * @author Вадим
 */
class TimeChecker extends AbstractChecker implements CheckerInterface
{
    
    /**
     * check user last time access on annotated page
     * for annotated time interval
     * 
     * @param string $value
     * @return string | null
     * @throws AccessDeniedException
     * @throws InvalidArgumentException
     */
    public function check( $value )
    {
        if( $this->sc->getToken() && !( $this->sc->getToken() instanceof AnonymousToken ) )
        {
            
            $user   = $this->sc->getToken()->getUser();
            $method = $this->methodGet;

            $lastPass = call_user_func(array( $user, $method) );
            
            if( $lastPass instanceof DateTime )
            {
                $nowDate = new DateTime();
                
                $diff = $nowDate->getTimestamp() - $lastPass->getTimestamp();
                
                if( $diff < $value )
                {
                    $accessEnDate = new DateTime( $lastPass->getTimestamp() + $value );
                    
                    if( $this->controller )
                    {
                        return $this->controller;
                    }
                    else
                    {
                        throw new AccessDeniedException( "Your last pass on this page was at ". $lastPass->format( 'd.m.Y H:i:s' ) .
                                ', you could access on this page only at '. $accessEnDate->format( 'd.m.Y H:i:s' ) );
                    }
                }
                elseif( $this->methodSet )
                {
                    call_user_func( array( $user, $this->methodSet ) );
                }
            }
            else{
                throw new InvalidArgumentException("The method 'get_method' must return DateTime object for type 'time' ");
            }
            
        }
        else
        {
            throw new AccessDeniedException();
        }
    }

}
