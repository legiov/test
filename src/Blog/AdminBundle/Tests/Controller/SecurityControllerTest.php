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

        $crawler = $client->request('GET', '/login');
        
        $this->assertTrue($client->getResponse()->isSuccessful(), 'Response is not successfull');
        
        $this->assertEquals('Admin panel', $crawler->filter('header > p')->text(), 'Title is wrong');
        
        $this->assertCount(1, $crawler->filter('input#username'), 'no username input found');
        $this->assertCount(1, $crawler->filter('input#password'), 'no password input found');
        $this->assertCount(1, $crawler->filter('input[type=submit]'), 'no submit button found');
        
        $form = $crawler->selectButton('_submit')->form(array(
            '_username' => 'admin',
            '_password' => 'adminpass'
        ));
        
        $client->submit($form);
        
        $this->assertTrue( $client->getResponse()->isRedirect(),'There was no redirection after authentication' );
        
        $crawler = $client->followRedirect();
        
        $link = $crawler->filter('a:contains("Exit")')->first()->link();
        
        $client->click($link);
        
        $this->assertTrue( $client->getResponse()->isRedirect(),'There was no redirection after logout');
        
    }
    
    public function testLoginRu()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/ru/login');
        
        $this->assertTrue($client->getResponse()->isSuccessful(), 'Response is not successfull');
        
        $this->assertEquals('Панель администратора', $crawler->filter('header > p')->text(), 'Title is wrong');
        
        $this->assertCount(1, $crawler->filter('input#username'), 'no username input found');
        $this->assertCount(1, $crawler->filter('input#password'), 'no password input found');
        $this->assertCount(1, $crawler->filter('input[type=submit]'), 'no submit button found');
        
        $form = $crawler->selectButton('_submit')->form(array(
            '_username' => 'admin',
            '_password' => 'adminpass'
        ));
        
        $client->submit($form);
        
        $this->assertTrue( $client->getResponse()->isRedirect(),'There was no redirection after authentication' );
        
        $crawler = $client->followRedirect();
        
        $link = $crawler->filter('a:contains("Выход")')->first()->link();
        
        $client->click($link);
        
        $this->assertTrue( $client->getResponse()->isRedirect(),'There was no redirection after logout');
        
    }


}
