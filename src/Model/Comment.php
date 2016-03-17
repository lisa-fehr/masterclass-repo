<?php

namespace Masterclass\Model;

use PDO;

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
     */
    public function create($username, $story_id, $comment)
    {
        $sql = 'INSERT INTO comment (created_by, created_on, story_id, comment) VALUES (?, NOW(), ?, ?)';
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array(
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
        $comment_stmt = $this->db->prepare($comment_sql);
        $comment_stmt->execute(array($story_id));
        return $comment_stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
