<?php

namespace Masterclass\Controller;

use Masterclass\Model\Story as StoryModel;
use Masterclass\Model\Comment as CommentModel;

/**
 * Class Index
 * @package Masterclass\Controller
 */
class Index
{
    /**
     * Store the story model for this controller.
     * @var StoryModel
     */
    protected $story_resource;

    /**
     * Store the comment model for this controller.
     * @var CommentModel
     */
    protected $comment_resource;

    /**
     * Index constructor.
     * @param StoryModel   $story
     * @param CommentModel $comment
     */
    public function __construct(StoryModel $story, CommentModel $comment)
    {
        $this->story_resource = $story;
        $this->comment_resource = $comment;
    }

    /**
     * List stories
     */
    public function index()
    {

        $stories = $this->story_resource->getStories();

        $content = '<ol>';

        foreach ($stories as $story) {
            $comments = $this->comment_resource->getComments($story['id']);

            $comment_count = count($comments);

            $content .= '
                <li>
                <a class="headline" href="' . $story['url'] . '">' . $story['headline'] . '</a><br />
                <span class="details">' . $story['created_by'] . ' | <a href="/story/?id=' . $story['id'] . '">' . $comment_count . ' Comments</a> |
                ' . date('n/j/Y g:i a', strtotime($story['created_on'])) . '</span>
                </li>
            ';
        }

        $content .= '</ol>';

        view('layout', $content);
    }
}

