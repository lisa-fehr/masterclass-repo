<?php

namespace Masterclass\Model;

use PDO;

class Story
{
    /**
     * @var PDO
     */
    protected $db;

    /**
     * Story constructor.
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
     * Create new story.
     * @param string $username
     * @param string $headline
     * @param string $url
     * @return int
     */
    public function create($username, $headline, $url)
    {
        $sql = 'INSERT INTO story (headline, url, created_by, created_on) VALUES (?, ?, ?, NOW())';
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array(
            $headline,
            $url,
            $username,
        ));

        return (int)$this->db->lastInsertId();
    }

    /**
     * Get story or throw an exception.
     * @param int|null $story_id
     * @return mixed|array
     * @throws \Exception
     */
    public function getStory($story_id = null)
    {
        if (empty($story_id)) {
            throw new \Exception('Story id is missing.');
        }

        $story_sql = 'SELECT * FROM story WHERE id = ?';
        $story_stmt = $this->db->prepare($story_sql);
        $story_stmt->execute(array($story_id));

        if ($story_stmt->rowCount() < 1) {
            throw new \Exception('Story not found.');
        }

        return $story_stmt->fetch(PDO::FETCH_ASSOC);
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

    /**
     * Validate form.
     * @param string $headline
     * @param string $url
     * @return bool
     */
    public function isValid($headline, $url)
    {
        return ! (!isset($headline) || !isset($url) || filter_var($url, FILTER_VALIDATE_URL) === false);
    }

}
