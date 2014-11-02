<?php

namespace Blog\ModelBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Blog\ModelBundle\Entity\Author;
use Faker\Factory as FakerFactory;

/**
 * Description of 10-Authres
 * load fixtures for authors
 *
 */
class Authres extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     *
     * {@inheritdoc}
     */
    public function load( ObjectManager $manager )
    {
        $faker = FakerFactory::create( 'ru_RU' );
        $a0    = new Author();
        
        $a0->setUsername( 'admin' );
        $a0->setPlainPassword( 'adminpass' );
        $a0->setEnabled( TRUE );
        $a0->setEmail( 'admin@example.ru' );
        $a0->setRoles( array('ROLE_ADMIN') );
        $a0->setName( $faker->firstName );
        $manager->persist( $a0 );

        for( $i = 1; $i < 4; $i++ )
        {
            $a = new Author();
            $faker->seed( 1110 + $i );
            $a->setName( $faker->firstName );
            $a->setUsername( $faker->userName );
            $a->setPlainPassword( $faker->userName );
            $a->setEnabled( TRUE );
            $a->setEmail( $faker->userName .'@example.ru' );
            $a->setRoles( array('ROLE_USER') );
            
            $manager->persist( $a );
        }
        $manager->flush();
    }

    /**
     *
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 10;
    }

}
