<?php

namespace Blog\AdminBundle\Tests\Controller;

use Blog\AdminBundle\Tests\ExtendedCase;

/**
 * class AuthorControllerTest
 */
class AuthorControllerTest extends ExtendedCase
{
    /**
     * test Author CRUD
     */
    public function testCompleteScenario()
    {
        // Create a new client to browse the application
        $client = $this->getAuthenticatedClient('admin', 'adminpass');

        // Create a new entry in the database
        $crawler = $client->request( 'GET', '/admin/author/' );
        $this->assertEquals( 200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /author/" );
        $crawler = $client->click( $crawler->selectLink( 'Create a new entry' )->link() );

        // Fill in the form and submit it
        $form = $crawler->selectButton( 'Create' )->form( array(
            'blog_modelbundle_author[name]' => 'Test',
            'blog_modelbundle_author[username]' => 'TestU',
            'blog_modelbundle_author[password]' => 'TestP',
            'blog_modelbundle_author[enabled]' => TRUE,
            'blog_modelbundle_author[email]' => 'test@example.ru',
            
                // ... other fields to fill
        ) );

        $client->submit( $form );
        $crawler = $client->followRedirect();

        // Check data in the show view
        $this->assertGreaterThan( 0, $crawler->filter( 'td:contains("Test")' )->count(), 'Missing element td:contains("Test")' );

        // Edit the entity
        $crawler = $client->click( $crawler->selectLink( 'Edit' )->link() );

        $form = $crawler->selectButton( 'Update' )->form( array(
            'blog_modelbundle_author[name]' => 'Foo',
                // ... other fields to fill
        ) );

        $client->submit( $form );
        $crawler = $client->followRedirect();

        // Check the element contains an attribute with value equals "Foo"
        $this->assertGreaterThan( 0, $crawler->filter( '[value="Foo"]' )->count(), 'Missing element [value="Foo"]' );

        // Delete the entity
        $client->submit( $crawler->selectButton( 'Delete' )->form() );
        $crawler = $client->followRedirect();

        // Check the entity has been delete on the list
        $this->assertNotRegExp( '/Foo/', $client->getResponse()->getContent() );
    }

}
