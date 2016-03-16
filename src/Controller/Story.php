<?php

namespace Masterclass\Controller;

use Masterclass\Model\Story as StoryModel;

class Story
{
    /**
     * Store the model for this controller.
     * @var StoryModel
     */
    protected $resource;

    /**
     * Story constructor.
     * @param array $config
     */
    public function __construct($config)
    {
        $this->resource = new StoryModel($config);
    }

    /**
     * Show a story with comments.
     */
    public function index()
    {
        $story_id = $_GET['id'];

        try {
            $story = $this->resource->getStory($story_id);
        } catch (\Exception $e) {
            header("Location: /");
            exit;
        }

        $comments = $this->resource->getComments($story['id']);

        $comment_count = count($comments);

        $content = '
            <a class="headline" href="' . $story['url'] . '">' . $story['headline'] . '</a><br />
            <span class="details">' . $story['created_by'] . ' | ' . $comment_count . ' Comments | 
            ' . date('n/j/Y g:i a', strtotime($story['created_on'])) . '</span>
        ';

        if (isset($_SESSION['AUTHENTICATED'])) {
            $content .= '
            <form method="post" action="/comment/create">
            <input type="hidden" name="story_id" value="' . $story_id . '" />
            <textarea cols="60" rows="6" name="comment"></textarea><br />
            <input type="submit" name="submit" value="Submit Comment" />
            </form>            
            ';
        }

        foreach ($comments as $comment) {
            $content .= '
                <div class="comment"><span class="comment_details">' . $comment['created_by'] . ' | ' .
                date('n/j/Y g:i a', strtotime($comment['created_on'])) . '</span>
                ' . $comment['comment'] . '<hr /></div>
            ';
        }

        view('layout', $content);

    }

    /**
     * Create a new story.
     */
    public function create()
    {
        if (!isset($_SESSION['AUTHENTICATED'])) {
            header("Location: /user/login");
            exit;
        }

        $error = '';
        if (isset($_POST['create'])) {
            $headline = $_POST['headline'];
            $url = $_POST['url'];

            try{
                $this->resource->isValid($headline, $url);
                $story_id = $this->resource->create($_SESSION['username'], $headline, $url);
                header("Location: /story/?id=" . $story_id);
                exit;
            }catch(\Exception $e){
                $error = $e->getMessage();
            }
        }

        $content = '
            <form method="post">
                ' . $error . '<br />
        
                <label>Headline:</label> <input type="text" name="headline" value="" /> <br />
                <label>URL:</label> <input type="text" name="url" value="" /><br />
                <input type="submit" name="create" value="Create" />
            </form>
        ';

        view('layout', $content);
    }

}