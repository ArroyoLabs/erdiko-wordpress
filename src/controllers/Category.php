<?php
/**
 * Category Controller
 * 
 * @package     erdiko/wordpress/controllers
 * @copyright   Copyright (c) 2017, Arroyo Labs, www.arroyolabs.com
 * @author      John Arroyo, john@arroyolabs.com
 */
namespace erdiko\wordpress\controllers;


class Category extends \erdiko\Controller
{
    use \erdiko\theme\traits\Controller;

    public function __invoke($request, $response, $args) 
    {
        if(empty($args['category']))
            throw new \Exception("No Category Specified");

        $category = $args['category'];
        $view = "blog/post/list.html";

        $theme = new \erdiko\theme\Engine;
        $content = new \erdiko\wordpress\models\Content;

        // Get paging info
        $pagerData = $content->getPagerData($theme->getThemeField('pagesize'));
        // Get posts
        $posts = $content->getAllPosts($pagerData['pagesize'], $pagerData['offset'], $category);
        $count = $content->getCategoryCount($category);
        $pager = $content->getPager($pagerData, $count);

        $this->container->logger->debug("post ct: {$count}");
        
        $description = "Posts in category {$category}";
        $theme->title = ucfirst($category);
        $theme->subtitle = $description;
        $theme->category = $category;
        $theme->posts = $posts;
        $theme->paging = $pager;
        // $theme->feat_image = $config['content']['defaults']['feat_image'];
        $theme->url = explode('?', $_SERVER["REQUEST_URI"], 2)[0];

        // Add additional SEO tags
        // @todo get extended meta data for the page like, $theme->addMeta($content->getMeta($post));
        $meta = [
            "description" => $description,
            "og:description" => $description
            ];
        $theme->addMeta($meta);

        return $this->render($response, $view, $theme);
    }
}
