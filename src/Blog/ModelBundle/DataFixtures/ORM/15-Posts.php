<?php

namespace Blog\ModelBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Blog\ModelBundle\Entity\Post;
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
        $p1 = new Post();
        $p1->setTitle( 'Lorem ipsum dolor sit amet' );
        $p1->setBody('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut eget hendrerit erat, non fermentum massa. Cras feugiat, tortor porta maximus volutpat, ex orci lacinia elit, in sagittis mauris dui at ipsum. Sed nec euismod leo, nec semper nisi. Duis ut facilisis tortor, vitae molestie urna. Etiam rhoncus augue ac feugiat tincidunt. In hac habitasse platea dictumst. Nulla facilisi. Nullam maximus mattis tincidunt. Nunc blandit rutrum nibh, at auctor diam interdum non. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Suspendisse aliquam metus a vestibulum imperdiet. Suspendisse id tristique justo, eu vestibulum est. Quisque sed velit non neque vulputate scelerisque. Vivamus egestas sapien ac sodales blandit.');
                $p1->setAuthor( $this->getAuthor($manager, 'Vadim'));
        
        $p2 = new Post();
        $p2->setTitle( 'Lorem ipsum dolor sit amet' );
        $p2->setBody('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut eget hendrerit erat, non fermentum massa. Cras feugiat, tortor porta maximus volutpat, ex orci lacinia elit, in sagittis mauris dui at ipsum. Sed nec euismod leo, nec semper nisi. Duis ut facilisis tortor, vitae molestie urna. Etiam rhoncus augue ac feugiat tincidunt. In hac habitasse platea dictumst. Nulla facilisi. Nullam maximus mattis tincidunt. Nunc blandit rutrum nibh, at auctor diam interdum non. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Suspendisse aliquam metus a vestibulum imperdiet. Suspendisse id tristique justo, eu vestibulum est. Quisque sed velit non neque vulputate scelerisque. Vivamus egestas sapien ac sodales blandit.');
        $p2->setAuthor( $this->getAuthor($manager, 'Nikolay'));
        
        $p3 = new Post();
        $p3->setTitle( 'Lorem ipsum dolor sit amet' );
        $p3->setBody('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut eget hendrerit erat, non fermentum massa. Cras feugiat, tortor porta maximus volutpat, ex orci lacinia elit, in sagittis mauris dui at ipsum. Sed nec euismod leo, nec semper nisi. Duis ut facilisis tortor, vitae molestie urna. Etiam rhoncus augue ac feugiat tincidunt. In hac habitasse platea dictumst. Nulla facilisi. Nullam maximus mattis tincidunt. Nunc blandit rutrum nibh, at auctor diam interdum non. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Suspendisse aliquam metus a vestibulum imperdiet. Suspendisse id tristique justo, eu vestibulum est. Quisque sed velit non neque vulputate scelerisque. Vivamus egestas sapien ac sodales blandit.');
        $p3->setAuthor( $this->getAuthor($manager, 'Edgar'));
        
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
    public function getAuthor( ObjectManager $manager, $name )
    {
        return $manager->getRepository('ModelBundle:Author')->findOneBy(
            array(
                'name' => $name
            )
        );
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