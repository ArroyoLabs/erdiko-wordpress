<?php
/**
 * WordPress Posts Controller
 *
 * @package     erdiko\wordpress\controllers
 * @copyright   Copyright (c) 2017, Arroyo Labs, www.arroyolabs.com
 * @author      John Arroyo, john@arroyolabs.com
 */
namespace erdiko\wordpress\controllers;

class Posts extends \erdiko\Controller
{
    use \erdiko\theme\traits\Controller;

    public function __invoke($request, $response, $args) 
    {
        $this->container->logger->debug("/wordpress");
        $theme = new \erdiko\theme\Engine;
        $view = "blog/post/list.html";

        $content = new \erdiko\wordpress\models\Content;

        // Get paging info
        $pager = $content->getPager($theme->getThemeField('pagesize'),
            $content->getPostCount($category));
        // Get posts
        $posts = $content->getAllPosts($pager['pagesize'], $pager['offset']);
        
        $theme->title = $theme->getApplicationField('name');
        $theme->subtitle = $theme->getApplicationField('tagline');
        $theme->posts = $posts;
        $theme->paging = $pager;
        // $theme->feat_image = $config['content']['defaults']['feat_image'];
        $theme->url = explode('?', $_SERVER["REQUEST_URI"], 2)[0];

        return $this->render($response, $view, $theme);
    }
}
