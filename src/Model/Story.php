<?php

namespace Masterclass\Model;

/**
 * Class Story
 * @package Masterclass\Model
 */
class Story extends BaseModel
{
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
        $this->db->execute($sql, array(
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
        $story_stmt = $this->db->fetchOne($story_sql, [$story_id]);

        if ($story_stmt->rowCount() < 1) {
            throw new \Exception('Story not found.');
        }

        return $story_stmt;
    }

    /**
     * Get all stories.
     * @return array
     */
    public function getStories()
    {
        $sql = 'SELECT * FROM story ORDER BY created_on DESC';
        return $this->db->fetchAll($sql);
    }

    /**
     * Validate form.
     * @param string $headline
     * @param string $url
     * @return bool
     * @throws \Exception
     */
    public function isValid($headline, $url)
    {
        if (empty($headline) || empty($url) || filter_var($url, FILTER_VALIDATE_URL) === false) {
            throw new \Exception('You did not fill in all the fields or the URL did not validate.');
        }

        return true;
    }

}
