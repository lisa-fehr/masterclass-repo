<?php

namespace Masterclass\Model;

use PDO;

class Comment
{
    /**
     * @var PDO
     */
    protected $db;

    /**
     * Comment constructor.
     * @param array $config
     */
    public function __construct($config)
    {
        $dbconfig = $config['database'];
        $dsn = 'mysql:host=' . $dbconfig['host'] . ';dbname=' . $dbconfig['name'];
        $this->db = new PDO($dsn, $dbconfig['user'], $dbconfig['pass']);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

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
