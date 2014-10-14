<?php

namespace Blog\ModelBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * class PostControllerTest
 */
class PostControllerTest extends WebTestCase
{
    /**
     * test Post CRUD
     */
    public function testCompleteScenario()
    {
        // Create a new client to browse the application
        $client = static::createClient( array(),array(
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW'   => 'adminpass',
        ));
        
        // Create a new entry in the database
        $crawler = $client->request('GET', '/admin/post/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /post/");
        $crawler = $client->click($crawler->selectLink('Create a new entry')->link());

        $author = $crawler->filter('#blog_modelbundle_post_author option:contains("Любовь")')->attr('value');
        // Fill in the form and submit it
        $form = $crawler->selectButton('Create')->form(array(
            'blog_modelbundle_post[title]'  => 'Test',
            'blog_modelbundle_post[body]'  => 'Test',
            'blog_modelbundle_post[slug]'  => 'Test',
            'blog_modelbundle_post[author]'  => $author,
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check data in the show view
        $this->assertGreaterThan(0, $crawler->filter('td:contains("Test")')->count(), 'Missing element td:contains("Test")');

        // Edit the entity
        $crawler = $client->click($crawler->selectLink('Edit')->link());

        $form = $crawler->selectButton('Update')->form(array(
            'blog_modelbundle_post[title]'  => 'Foo',
            'blog_modelbundle_post[body]'  => 'Foo',
            'blog_modelbundle_post[slug]'  => 'Test',
            'blog_modelbundle_post[author]'  => $author,
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check the element contains an attribute with value equals "Foo"
        $this->assertGreaterThan(0, $crawler->filter('[value="Foo"]')->count(), 'Missing element [value="Foo"]');

        // Delete the entity
        $client->submit($crawler->selectButton('Delete')->form());
        $crawler = $client->followRedirect();

        // Check the entity has been delete on the list
        $this->assertNotRegExp('/Foo/', $client->getResponse()->getContent());
    }

   
}
