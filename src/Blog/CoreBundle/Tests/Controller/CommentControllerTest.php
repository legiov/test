<?php

namespace Blog\CoreBundle\Tests\Controller;

use Blog\CoreBundle\Tests\ExtendedCase;

class CommentControllerTest extends ExtendedCase
{
    /**
     * test Comment
     */
    public function testCompleteScenario()
    {
        // Create a new client to browse the application
        $client = $this->getAuthenticatedClient('admin', 'adminpass');

        $post = $client->getContainer()->get('doctrine')->getRepository('ModelBundle:Post')->findFirst();

        $crawler = $client->request('GET', '/'. $post->getSlug() );
        
        $this->assertTrue( $client->getResponse()->isSuccessful(),'The response was not Successful');
        
        
        
        // Fill in the form and submit it
        $form = $crawler->selectButton('Send')->form(array(
            'blog_modelbundle_comment[body]'  => 'Test body',
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check data in the show view
        $this->assertGreaterThan(0, $crawler->filter('div:contains("Test body")')->count(), 'Missing element td:contains("Test")');

        // Edit the entity
        $crawler = $client->click($crawler->selectLink('Edit')->link());

        $form = $crawler->selectButton('Send')->form(array(
            'blog_modelbundle_comment[body]'  => 'Foo',
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check the element contains an attribute with value equals "Foo"
        $this->assertGreaterThan(0, $crawler->filter('div:contains("Foo")')->count(), 'Missing element td:contains("Foo")');

        $crawler = $client->click($crawler->selectLink('Edit')->link());
        
        // Delete the entity
        $client->submit($crawler->selectButton('Delete')->form());
        $crawler = $client->followRedirect();
        
        // Check the entity has been delete on the list
        $this->assertNotRegExp('/Foo/', $client->getResponse()->getContent());
    }

    
}
