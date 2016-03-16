<?php

/**
 * Include the layout and pass in the content.
 * @param $layout
 * @param $content
 */
function view($layout, $content)
{
    require_once(__DIR__ . '/' . $layout . '.phtml');
}