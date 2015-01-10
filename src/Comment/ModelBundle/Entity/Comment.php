<?php

namespace Comment\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Comment\CoreBundle\Validator\Constraints\ContainsRussian;


/**
 * Comment
 * @ExclusionPolicy("all")
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Comment\ModelBundle\Repository\CommentRepository")
 */
class Comment extends Timestampable
{
    /**
     * @var integer
     * @Expose
     * @Groups({"all_user"})
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @Expose
     * @Groups({"all_user"})
     * @ORM\Column(name="authorName", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $authorName;

    /**
     * @var string
     * @Expose
     * @Groups({"all_user"})
     * @ORM\Column(name="body", type="text")
     * @Assert\NotBlank()
     * @ContainsRussian()
     */
    private $body;

    /**
     * @Assert\NotBlank()
     * @var Post
     */
    private $comment_object;


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
     * Set authorName
     *
     * @param string $authorName
     * @return Comment
     */
    public function setAuthorName($authorName)
    {
        $this->authorName = $authorName;

        return $this;
    }

    /**
     * Get authorName
     *
     * @return string
     */
    public function getAuthorName()
    {
        return $this->authorName;
    }

    /**
     * Set body
     *
     * @param string $body
     * @return Comment
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    

    /**
     * Set commentObject
     *
     * @param $commentObject
     * @return Comment
     */
    public function setCommentObject( $commentObject = null)
    {
        $this->comment_object = $commentObject;
    
        return $this;
    }

    /**
     * Get commentObject
     *
     * @return
     */
    public function getCommentObject()
    {
        return $this->comment_object;
    }
}