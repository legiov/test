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
        $faker = FakerFactory::create('ru_RU');
        $a1 = new Author();
        $faker->seed(1111);
        $a1->setName( $faker->firstName );

        $a2 = new Author();
        $faker->seed(1112);
        $a2->setName( $faker->firstName );

        $a3 = new Author();
        $faker->seed(1113);
        $a3->setName( $faker->firstName );

        $manager->persist( $a1 );
        $manager->persist( $a2 );
        $manager->persist( $a3 );

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