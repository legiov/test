<?php

namespace Blog\CoreBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PostControllerTest extends WebTestCase
{
    /**
     * Test posts index
     */
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/en/');

        $this->assertTrue( $client->getResponse()->isSuccessful(),'The response was not Successful');
        $this->assertCount( 3, $crawler->filter('h2'),'There should be 3 displayed posts');
    }

    /**
     * Test post show
     */
    public function testShow()
    {
        $client = static::createClient();

        $post = $client->getContainer()->get('doctrine')->getRepository('ModelBundle:Post')->findFirst();

        $crawler = $client->request('GET', '/en/'. $post->getSlug() );

        $this->assertTrue( $client->getResponse()->isSuccessful(),'The response was not Successful');
        $this->assertEquals( $post->getTitle() ,$crawler->filter('h1')->text(),'Post title is invalid');

        $this->assertGreaterThanOrEqual( 1,$crawler->filter('article.comment')->count(),'There shoud be at last one comment');
    }

    /**
     * Test create comment
     */
    public function testCommentCreate()
    {
        $client = static::createClient();

        $post = $client->getContainer()->get('doctrine')->getRepository('ModelBundle:Post')->findFirst();

        $crawler = $client->request('GET', '/en/'. $post->getSlug() );

        $button = $crawler->selectButton('Send');

        $form = $button->form( array(
            'blog_modelbundle_comment[authorName]'  => 'some name',
            'blog_modelbundle_comment[body]'        => 'some text'
        ));

        $client->submit($form);

        $this->assertTrue( $client->getResponse()->isRedirect('/en/'. $post->getSlug().'#comments' ), 'There is no redirection' );
        $crawler = $client->followRedirect();


        $this->assertCount( 1, $crawler->filter('html:contains("Your comment was submited successfully")'), 'There was no confirmation massage');
    }

}
