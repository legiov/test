<?php

namespace Blog\CoreBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LocaleTest extends WebTestCase
{
    /**
     * Test show Author
     */
    public function testShow()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/' );

        $this->assertTrue( $client->getResponse()->isSuccessful(),'The response was not Successful');
        
        $selectorRu = '#language_selector>li>a:contains("Russian")';
        $selectorEn = '#language_selector>li>a:contains("Английский")';
        
        $msgNotContains = 'There is no selector with write choise';
        $msgContainsIncorrect = 'Selector contains incorrect choise';
         
        $this->assertCount( 1 ,$crawler->filter( $selectorRu ), $msgNotContains);
        $this->assertCount( 0 ,$crawler->filter( $selectorEn ), $msgContainsIncorrect );
        
        $link = $crawler->filter( $selectorRu)->first()->link();
        $crawler = $client->click($link);
        
        $this->assertCount( 1 ,$crawler->filter( $selectorEn ), $msgNotContains);
        $this->assertCount( 0 ,$crawler->filter( $selectorRu ), $msgContainsIncorrect );
        
    }
}
