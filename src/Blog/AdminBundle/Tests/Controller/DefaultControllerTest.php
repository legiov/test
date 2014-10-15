<?php

namespace Blog\AdminBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    /**
     * Admin index test
     */
    public function testIndex()
    {
        $client = static::createClient( array(),array(
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW'   => 'adminpass',
        ));

        $client->request('GET', '/admin/');

        $this->assertTrue( $client->getResponse()->isRedirect('/admin/post/'),'No redirection');
    }
}
