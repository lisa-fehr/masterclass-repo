<?php

namespace Masterclass\Model;

/**
 * Class Comment
 * @package Masterclass\Model
 */
class Comment extends BaseModel
{
    /**
     * Create new comment.
     * @param string $username
     * @param int $story_id
     * @param string $comment
     * @return bool
     */
    public function create($username, $story_id, $comment)
    {
        $sql = 'INSERT INTO comment (created_by, created_on, story_id, comment) VALUES (?, NOW(), ?, ?)';
        return $this->db->execute($sql, array(
            $username,
            $story_id,
            filter_var($comment, FILTER_SANITIZE_FULL_SPECIAL_CHARS),
        ));
    }

    /**
     * Get a list of comments for a story.
     * @param int $story_id
     * @return array
     */
    public function getComments($story_id)
    {
        $comment_sql = 'SELECT * FROM comment WHERE story_id = ?';
        return $this->db->fetchAll($comment_sql, [$story_id]);
    }

}
