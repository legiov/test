<?php

namespace Blog\ModelBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Blog\ModelBundle\Entity\Post;
use Faker\Factory as FakerFactory;
/**
 * Description of 15-Posts
 *
 * @author grishvv
 */
class Posts extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     *
     * {@inheritdoc}
     */
    public function load( ObjectManager $manager )
    {
        $faker = FakerFactory::create('ru_RU');
        $p1 = new Post();
        $p1->setTitle( $faker->sentence(5));
        $p1->setBody( $faker->paragraph(12));
        $faker->seed(1111);
        $p1->setAuthor( $this->getAuthor($manager, $faker->firstName));

        $p2 = new Post();
        $p2->setTitle( $faker->sentence(7) );
        $p2->setBody( $faker->paragraph(15));
        $faker->seed(1112);
        $p2->setAuthor( $this->getAuthor($manager, $faker->firstName));

        $p3 = new Post();
        $p3->setTitle( $faker->sentence(4) );
        $p3->setBody( $faker->paragraph(18));
        $faker->seed(1111);
        $p3->setAuthor( $this->getAuthor($manager, $faker->firstName));

        $manager->persist( $p1 );
        $manager->persist( $p2 );
        $manager->persist( $p3 );

        $manager->flush();
    }

    /**
     *
     * @param ObjectManager $manager
     * @param type $name
     * @return Author
     */
    private function getAuthor( ObjectManager $manager, $name )
    {
        
        $author = $manager->getRepository('ModelBundle:Author')->findOneBy(
            array(
                'name' => $name
            )
        );
        echo $author->getSlug();
        return $author;
    }

    /**
     *
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 15;
    }

}