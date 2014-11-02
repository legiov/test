<?php

namespace Blog\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * Author
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Blog\ModelBundle\Repository\AuthorRepository")
 */
class Author extends BaseUser
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100)
     */
    private $name;

    /**
     *
     * @var string
     *
     * @Gedmo\Slug(fields={"name"}, unique=true)
     * @ORM\Column(name="slug", type = "string")
     */
    private $slug;

    /**
     *
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Post", mappedBy="author", cascade={"remove"})
     *
     */
    private $posts;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    private $updatedAt;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->posts = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Author
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    

    /**
     * Add posts
     *
     * @param Post $posts
     * @return Author
     */
    public function addPost(Post $posts)
    {
        $this->posts[] = $posts;

        return $this;
    }

    /**
     * Remove posts
     *
     * @param Post $posts
     */
    public function removePost(Post $posts)
    {
        $this->posts->removeElement($posts);
    }

    /**
     * Get posts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * Get slug
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     *
     * @param string $slug
     * @return \Blog\ModelBundle\Entity\Author
     */
    public function setSlug( $slug )
    {
        $this->slug = $slug;

        return $this;
    }
    
    public function __toString()
    {
        return $this->name;
    }
    
    
    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * 
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Get updatedAt
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt( \DateTime $updatedAt )
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

}