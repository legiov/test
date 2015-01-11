<?php

namespace Component\Comment\Model;

/**
 * Comment
 */
class Comment extends Timestampable
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $authorName;

    /**
     * @var string
     */
    private $body;

    /**
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