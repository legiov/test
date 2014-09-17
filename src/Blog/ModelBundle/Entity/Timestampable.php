<?php

namespace Blog\ModelBundle\Entity;

use Doctrine\ORM\Mapping AS ORM;

/**
 * Description of Timestampable
 * define created behavior
 * ORM\MappedSuperClass()
 */
abstract class Timestampable
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     * 
     */
    protected $createdAt;
    
    /**
     * Construct
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }
    
    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Post
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
}