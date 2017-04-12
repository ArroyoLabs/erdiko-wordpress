<?php
/**
 * WordPress Posts Controller
 *
 * @package     erdiko/wordpress/controllers
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
        $pagesize = empty($_REQUEST['pagesize']) ? 
            $theme->getThemeField('pagesize') : $_REQUEST['pagesize'];
        $page = empty($_REQUEST['page']) ? 1 : $_REQUEST['page'];
        $offset = $page*$pagesize;
        $pagingData = $content->getPaginationData($pagesize, $page);
        // Get posts
        $posts = $content->getAllPosts($pagesize, $pagingData['offset']);

        
        $theme->title = "Blog Title"; // $config['site']['full_name']
        $theme->subtitle = "Tagline"; // $config['site']['tagline']
        $theme->posts = $posts;
        $theme->paging = $pagingData;
        // $theme->feat_image = $config['content']['defaults']['feat_image'];
        $theme->url = explode('?', $_SERVER["REQUEST_URI"], 2)[0];

        return $this->render($response, $view, $theme);
    }
}
