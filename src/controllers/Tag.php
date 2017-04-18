<?php
/**
 * Tag Controller
 *
 * @package     erdiko/wordpress/controllers
 * @copyright   Copyright (c) 2017, Arroyo Labs, www.arroyolabs.com
 * @author      John Arroyo, john@arroyolabs.com
 */
namespace erdiko\wordpress\controllers;


class Tag extends \erdiko\Controller
{
    use \erdiko\theme\traits\Controller;

    public function __invoke($request, $response, $args) 
    {
        if(empty($args['tag']))
            throw new \Exception("No tag specified"); // @todo throw 404 instead

        $tag = $args['tag'];
        $theme = new \erdiko\theme\Engine;
        $view = "blog/post/list.html";

        $content = new \erdiko\wordpress\models\Content;
        // Get paging info
        $pager = $content->getPagination($theme->getThemeField('pagesize'), $tag);

        // Get posts
        $posts = $content->getPostsByTag($pager['pagesize'], $pager['offset'], $tag);
        
        $description = "Posts with tag {$tag}";
        $theme->title = ucfirst($tag);
        $theme->subtitle = $description;
        $theme->tag = $tag;
        $theme->posts = $posts;
        $theme->paging = $pager['pagination'];
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
