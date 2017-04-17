<?php
/**
 * WordPress Content Controller
 *
 * @package     erdiko/wordpress/controllers
 * @copyright   Copyright (c) 2017, Arroyo Labs, www.arroyolabs.com
 * @author      John Arroyo, john@arroyolabs.com
 */
namespace erdiko\wordpress\controllers;


class Content extends \erdiko\Controller
{
    use \erdiko\theme\traits\Controller;

    public function __invoke($request, $response, $args) 
    {
        $postUrl = isset($args['post_url']) ? $args['post_url'] : implode('/', $args);

        $this->container->logger->debug("/wordpress/".$postUrl);

        $theme = new \erdiko\theme\Engine;
        $view = "blog/post/detail.html";

        $content = new \erdiko\wordpress\models\Content;
        $post = $content->getPost($postUrl);
        // $this->container->logger->debug("post: ".print_r($post, true));
        
        $theme->title = $post->post_title;
        $theme->post = $content->themeData($post);
        $theme->url = $args['post_url'];
        $theme->categories = $content->getCategoryLinks($post);
        $theme->tags = $content->getTagLinks($post);

        // Add post metadata
        $theme->addMeta($content->getMeta($post));

        // $theme->feat_image = $config['content']['defaults']['feat_image'];

        return $this->render($response, $view, $theme);
    }

    // http://kenwheeler.github.io/slick, http://videojs.com, https://open.521dimensions.com/amplitudejs
    private function addWpThemeExtras()
    {
      // Add Css
      $this->getResponse()->getTheme()->addCss('/themes/wordpress/css/slick.css');
      $this->getResponse()->getTheme()->addCss('/themes/wordpress/css/slick-theme.css');
      $this->getResponse()->getTheme()->addCss('/themes/wordpress/css/slickstyle.css');
      // Add Js
      $this->getResponse()->getTheme()->addJs('/themes/wordpress/js/slick.min.js');
      $this->getResponse()->getTheme()->addJs('/themes/wordpress/js/slickstyle.js');
      $this->getResponse()->getTheme()->addJs('/themes/wordpress/js/audioplaylist.js');
      $this->getResponse()->getTheme()->addJs('/themes/wordpress/js/videoplaylist.js');
    }
}
