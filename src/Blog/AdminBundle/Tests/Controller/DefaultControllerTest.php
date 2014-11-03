<?php

namespace Blog\AdminBundle\Tests\Controller;

use Blog\AdminBundle\Tests\ExtendedCase;

class DefaultControllerTest extends ExtendedCase
{
    /**
     * Admin index test
     */
    public function testIndex()
    {
        $client = $this->getAuthenticatedClient('admin', 'adminpass');

        $client->request('GET', '/admin/');

        $this->assertTrue( $client->getResponse()->isRedirect('/admin/post/'),'No redirection');
    }
}
