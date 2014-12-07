<?php

namespace Comment\ApiBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testCommentsGet()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/api/v1/comments.json');

        $this->assertEquals(200, $client->getResponse()->getStatusCode(), 'Response was not successful');
    }
    
    public function testCommentsForPost()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/api/v1/posts/18/comments.json');

        $this->assertEquals(200, $client->getResponse()->getStatusCode(), 'Response was not successful');
    }
    public function testCountCommentsForPost()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/api/v1/posts/18/comments/count.json');

        $this->assertEquals(200, $client->getResponse()->getStatusCode(), 'Response was not successful');
    }
    
    public function testGetCommentById()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/api/v1/comments/54.json');

        $this->assertEquals(200, $client->getResponse()->getStatusCode(), 'Response was not successful');
    }
}
