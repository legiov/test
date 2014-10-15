<?php

namespace Blog\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class AuthorController
 * @Route("/{_locale}/author", requirements={"_locale"="en|ru"}, defaults={"_locale"="en"})
 */
class AuthorController extends Controller
{
    /**
     * Show a author
     *
     * @param string $slug
     * @return array
     *
     * @Route("/{slug}", name="author_show")
     * @Template()
     * @throws NotFoundHttpException
     */
    public function showAction( $slug )
    {
        $author = $this->getAuthorManager()->findBySlug($slug);

        $posts = $author->getPosts();

        return array(
            'author'        => $author,
            'posts'         => $posts,
        );
    }

    /**
     *
     * @return \Blog\CoreBundle\Services\AuthorManager
     */
    private function getAuthorManager()
    {
        return $this->get('blog.core.author_manager');
    }
}
