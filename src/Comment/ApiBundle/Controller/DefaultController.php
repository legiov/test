<?php

namespace Comment\ApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\View\View as FOSview;

class DefaultController extends FOSRestController
{

    /**
     * Return Comment by id
     *
     * @return FOSview
     * @ApiDoc(
     *  resource=true,
     *  description="This is a description of your API method"
     * )
     */
    public function getAction( \Comment\ModelBundle\Entity\Comment $id )
    {
        $view = $this->view( $id, 200 );

        return $this->handleView( $view );
    }

}
