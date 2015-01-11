<?php

namespace Comment\ApiBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{

    public function testCommentsGet()
    {
        $client = static::createClient();

        $crawler = $client->request( 'GET', '/api/v1/comments.json' );

        $this->assertEquals( 200, $client->getResponse()->getStatusCode(), 'Response was not successful' );
    }

    public function testCommentsForPost()
    {
        $client  = static::createClient();
        $post    = $client->getContainer()->get( 'doctrine' )->getRepository( 'ModelBundle:Post' )->findFirst();
        $crawler = $client->request( 'GET', '/api/v1/posts/' . $post->getId() . '/comments.json' );

        $this->assertEquals( 200, $client->getResponse()->getStatusCode(), 'Response was not successful' );
    }

    public function testCountCommentsForPost()
    {
        $client  = static::createClient();
        $post    = $client->getContainer()->get( 'doctrine' )->getRepository( 'ModelBundle:Post' )->findFirst();
        $crawler = $client->request( 'GET', '/api/v1/posts/' . $post->getId() . '/comments/count.json' );

        $this->assertEquals( 200, $client->getResponse()->getStatusCode(), 'Response was not successful' );
    }

    public function testGetCommentById()
    {
        $client = static::createClient();

        $comment = $client->getContainer()->get( 'doctrine' )->getRepository( 'Component\Comment\Model\Comment' )->findLast();

        $crawler = $client->request( 'GET', '/api/v1/comments/' . $comment->getId() . '.json' );

        $this->assertEquals( 200, $client->getResponse()->getStatusCode(), 'Response was not successful' );
    }

    public function testPostComment()
    {
        $client = static::createClient();
        $post   = $client->getContainer()->get( 'doctrine' )->getRepository( 'ModelBundle:Post' )->findFirst();
        $params = array(
            'comment_api_form' => array(
                'authorName'     => 'testAuthor',
                'body'           => 'тестовое сообщение',
                'comment_object' => $post->getId()
            )
        );

        $client->request( 'POST', '/api/v1/comments.json', $params );

        $this->assertEquals( '201', $client->getResponse()->getStatusCode(), 'Comment did not save' );
    }

    public function testDeleteComment()
    {
        $client  = static::createClient();
        $comment = $client->getContainer()->get( 'doctrine' )->getRepository( 'Component\Comment\Model\Comment' )->findLast();

        $client->request( 'DELETE', '/api/v1/comments/' . $comment->getId() . '.json' );

        $this->assertEquals( '200', $client->getResponse()->getStatusCode(), 'Comment did not delete' );
    }

}
