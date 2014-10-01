<?php

namespace Blog\CoreBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AuthorControllerTest extends WebTestCase
{
    /**
     * Test show Author
     */
    public function testShow()
    {
        $client = static::createClient();

        $author = $client->getContainer()->get('doctrine')->getRepository('ModelBundle:Author')->findFirst();

        $postsCount = $author->getPosts()->count();

        $crawler = $client->request('GET', '/'. $author->getSlug() );

        $this->assertTrue( $client->getResponse()->isSuccessful(),'The response was not Successful');
        $this->assertCount( $postsCount ,$crawler->filter('h2'),'There shoud be '. $postsCount .' posts');
    }
}
