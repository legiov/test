<?php

namespace Blog\AdminBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * class SecurityControllerTest
 */
class SecurityControllerTest extends WebTestCase
{
    public function testLogin()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/admin/login');
        
        $this->assertTrue($client->getResponse()->isSuccessful(), 'Response is not successfull');
        
        $this->assertEquals('Admin panel', $crawler->filter('header > p')->text(), 'Title is wrong');
        
        $this->assertCount(1, $crawler->filter('input#username'), 'no username input found');
        $this->assertCount(1, $crawler->filter('input#password'), 'no password input found');
        $this->assertCount(1, $crawler->filter('button[type=submit]'), 'no submit button found');
    }


}
