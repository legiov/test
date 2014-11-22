<?php

namespace Comment\CoreBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Description of ExtendedCase
 */
class ExtendedCase extends WebTestCase
{
    /**
     * Return authanticated client
     * 
     * @param type $login
     * @param type $pass
     * @return type
     */
    public function getAuthenticatedClient( $login, $pass )
    {
        $client  = static::createClient();
        $crawler = $client->request( 'GET', '/login' );

        $form = $crawler->selectButton( '_submit' )->form( array(
            '_username' => $login,
            '_password' => $pass
        ) );

        $client->submit( $form );

        $this->assertTrue( $client->getResponse()->isRedirect(), 'There should be redirection after authentication' );

        $client->followRedirect();

        return $client;
    }
}
