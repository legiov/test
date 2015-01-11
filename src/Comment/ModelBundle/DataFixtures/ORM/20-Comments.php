<?php

namespace Comment\ModelBundle\DataFixtures\ORM;

use Component\Comment\Model\Comment;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory as FakerFactory;
/**
 * class Comments
 *
 * @author grishvv
 */
class Comments extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     *
     * {@inheritdoc}
     */
    public function load( ObjectManager $manager )
    {
        $posts = $manager->getRepository('ModelBundle:Post')->findAll();
        $faker = FakerFactory::create('ru_RU');
        foreach( $posts as $post )
        {
            $comment = new Comment();
            $comment->setAuthorName( $faker->firstName );
            $comment->setBody( $faker->paragraph(3) );
            $comment->setCommentObject( $post );

            $manager->persist( $comment );
        }

        $manager->flush();
    }



    /**
     *
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 20;
    }

}
