<?php
/**
 * Author Controller
 *
 * @package     erdiko\wordpress\controllers
 * @copyright   Copyright (c) 2017, Arroyo Labs, www.arroyolabs.com
 * @author      John Arroyo, john@arroyolabs.com
 */
namespace erdiko\wordpress\controllers;


class Author extends \erdiko\Controller
{
    use \erdiko\theme\traits\Controller;

    public function __invoke($request, $response, $args)
    {
        // $this->container->logger->debug("/wordpress/".$args['author']);
        $view = "blog/author/detail.html";
        $author = new \erdiko\wordpress\models\Author;

        $theme = new \erdiko\theme\Engine;
        $theme->author = $author->getAuthor($args['author']);
        $theme->title = "{$theme->author->user->display_name}'s Profile";

        // Add author metadata
        $meta = [
            "description" => "Profile for {$theme->author->user->display_name}",
            "author" => $author->user->display_name
            ];
        $theme->addMeta($meta);

        return $this->render($response, $view, $theme);
    }
}
