<?php
/**
 * Bookmarks Controller
 * https://codex.wordpress.org/Function_Reference/get_bookmarks
 *
 * @package     erdiko\wordpress\controllers
 * @copyright   Copyright (c) 2017, Arroyo Labs, www.arroyolabs.com
 * @author      John Arroyo, john@arroyolabs.com
 */
namespace erdiko\wordpress\controllers;


class Bookmarks extends \erdiko\Controller
{
    use \erdiko\theme\traits\Controller;

    public function __invoke($request, $response, $args) 
    {
        $view = "blog/bookmarks.html";
        $model = new \erdiko\wordpress\models\Bookmarks;

        if(isset($args['category'])) {
            $category = $args['category'];
            $bookmarks = $model->getBookmarksByCategory($category);

        } else {
            $category = "Bookmarks";
            $bookmarks = $model->getBookmarksByCategory("");
        }

        $theme = new \erdiko\theme\Engine;
        $theme->title = ucfirst($category);
        $theme->bookmarks = $bookmarks;

        // Add SEO tags
        $meta = [
            "description" => $theme->title
            ];
        $theme->addMeta($meta);

        return $this->render($response, $view, $theme);
    }
}
