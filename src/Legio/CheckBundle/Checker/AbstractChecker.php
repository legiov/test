<?php
namespace Legio\CheckBundle\Checker;

use Symfony\Component\Security\Core\SecurityContext;
/**
 * Description of AbstractChecker
 *
 * @author Вадим
 */
abstract class AbstractChecker
{
    /**
     * Method for set some value
     *
     * @var string
     */
    protected $methodSet;
    /**
     * Method for get checked value
     *
     * @var string
     */
    protected $methodGet;
    
    /**
     *
     * @var SecurityContext
     */
    protected $sc;
    
    /**
     * Configured controller
     *
     * @var string | null
     */
    protected $controller;

    /**
     * 
     * @param type $method
     * @param type $methodSet
     * @param SecurityContext $sc
     * @param string | null $controller
     */
    public function __construct( $method, $methodSet, SecurityContext $sc, $controller = NULL )
    {
        $this->sc         = $sc;
        $this->methodGet  = $method;
        $this->methodSet  = $methodSet;
        $this->controller = $controller;
    }
}
