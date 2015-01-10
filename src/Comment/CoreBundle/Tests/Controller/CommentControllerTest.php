<?php

namespace Comment\CoreBundle\Tests\Controller;

use Comment\CoreBundle\Tests\ExtendedCase;

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
            'comment_form[body]'  => 'Тест боди',
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check data in the show view
        $this->assertGreaterThan(0, $crawler->filter('div:contains("Тест боди")')->count(), 'Missing element td:contains("Тест боди")');

        // Edit the entity
        $crawler = $client->click($crawler->selectLink('Edit')->link());

        $form = $crawler->selectButton('Send')->form(array(
            'comment_form[body]'  => 'Тест бодива',
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check the element contains an attribute with value equals "Foo"
        $this->assertGreaterThan(0, $crawler->filter('div:contains("Тест бодива")')->count(), 'Missing element td:contains("Тест бодива")');

        $crawler = $client->click($crawler->selectLink('Edit')->link());
        
        // Delete the entity
        $client->submit($crawler->selectButton('Delete')->form());
        $crawler = $client->followRedirect();
        
        // Check the entity has been delete on the list
        $this->assertNotRegExp('/Foo/', $client->getResponse()->getContent());
    }
    
    /**
     * Test create comment
     */
    public function testCommentCreate()
    {
        $client = static::createClient();

        $post = $client->getContainer()->get('doctrine')->getRepository('ModelBundle:Post')->findFirst();

        $crawler = $client->request('GET', '/'. $post->getSlug() );

        $button = $crawler->selectButton('Send');

        $form = $button->form( array(
            'comment_form[authorName]'  => 'some name',
            'comment_form[body]'        => 'какой то текст'
        ));

        $client->submit($form);

        $this->assertTrue( $client->getResponse()->isRedirect('/'. $post->getSlug().'#comments' ), 'There is no redirection' );
        $crawler = $client->followRedirect();


        $this->assertCount( 1, $crawler->filter('html:contains("Your comment was submited successfully")'), 'There was no confirmation massage');
    }

    
}
