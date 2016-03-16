<?php

namespace Masterclass\Model;

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

}
