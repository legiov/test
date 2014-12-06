<?php

namespace Blog\CoreBundle\Services;

/**
 * Description of BundleResolver
 */
class BundleResolver
{
    private $bundles;
    
    private $reletions = array(
        'comment' => 'CommentCoreBundle'
    );
    
    public function __construct( array $bundles )
    {
        $this->bundles = $bundles;
    }
    
    public function bundleIsset( $bundle )
    {
        return isset( $this->bundles[ $this->reletions[ $bundle ] ] );
    }
    
    
}
