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

        $crawler = $client->request('GET', '/');

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

        $crawler = $client->request('GET', '/'. $post->getSlug() );

        $this->assertTrue( $client->getResponse()->isSuccessful(),'The response was not Successful');
        $this->assertEquals( $post->getTitle() ,$crawler->filter('h1')->text(),'Post title is invalid');

        $this->assertGreaterThanOrEqual( 1,$crawler->filter('article.comment')->count(),'There shoud be at last one comment');
    }

    

}
