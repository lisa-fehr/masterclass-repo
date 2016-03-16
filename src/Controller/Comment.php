<?php

namespace Masterclass\Controller;

use Masterclass\Model\Comment as CommentModel;

/**
 * Class Comment
 * @package Masterclass\Controller
 */
class Comment
{
    /**
     * Store the model for this controller.
     * @var CommentModel
     */
    protected $resource;

    /**
     * Comment constructor.
     * @param array $config
     */
    public function __construct($config)
    {
        $this->resource = new CommentModel($config);
    }

    /**
     * Create new comment.
     */
    public function create()
    {
        if (!isset($_SESSION['AUTHENTICATED'])) {
            header("Location: /");
            exit;
        }

        $story_id = $_POST['story_id'];

        $this->resource->create($_SESSION['username'], $story_id, $_POST['comment']);
        header("Location: /story/?id=" . $story_id);
    }

}