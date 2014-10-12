<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Blog\CoreBundle\Tests\TwigExtensions;

use Blog\CoreBundle\TwigExtension\TransPlural;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Description of RussianPluralExtensionTest
 *
 * @author Вадим
 */
class RussianPluralExtensionTest extends WebTestCase
{
    /**
     * Test show Author
     */
    public function testExtension()
    {
        $client = static::createClient();

        $container = $client->getContainer();
        $translator = $container->get('translator');
        $translator->setLocale('ru');
        
        $msg = '{0} Будьте первым кто прокоментировал | {1} %count% коментарий | {2} %count% коментария | {3} %count% коментариев';
        
        $ext = new TransPlural( $translator );
        
        $this->assertEquals('Будьте первым кто прокоментировал', $ext->trans_plural($msg, 0) );
        $this->assertEquals('1 коментарий', $ext->trans_plural($msg, 1) );
        $this->assertEquals('2 коментария', $ext->trans_plural($msg, 2) );
        $this->assertEquals('5 коментариев', $ext->trans_plural($msg, 5) );
    }
}
