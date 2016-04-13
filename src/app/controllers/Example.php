<?php
/**
 * Content Controller
 * A simple way to get wordpress content into your site
 * @note this is a work in progress.  It is however a good starting point for running headless
 *
 * @category    erdiko
 * @package     wordpress
 * @copyright   Copyright (c) 2016, Arroyo Labs, www.arroyolabs.com
 * @author      Fangxiang Wang
 * @author      John Arroyo, john@arroyolabs.com
 */
namespace erdiko\wordpress\app\controllers;

/**
 * Wordpress content controller class
 */
class Example extends \erdiko\core\Controller
{
    /** Before */
    public function _before()
    {
        $this->setThemeName('clean-blog');
        $this->prepareTheme();
    }

    /**
     * Get
     *
     * @param mixed $var
     * @return mixed
     */
    public function get($var = null)
    {
        // error_log("var: $var");

        $arg_list = func_get_args();
        if(!empty($arg_list))
        {
            $response = null;
            if($arg_list[0] == "post"){
                $response = $this->getPost($arg_list[1]);
                return $response;
            } elseif($arg_list[0] == "page"){
                $response = $this->getPage($arg_list[1]);
                return $response;
            }
            if($response == null)
                $response = $this->_autoaction($var, 'get'); // load action based off of naming conventions
            return $response;

        } else {
            return $this->getIndex();
        }
    }

    /**
     * Wordpress index
     */
    public function getIndex()
    {
        $content = $this->getView('wordpress_index', null, dirname(__DIR__));
        $this->setContent($content);
    }

    /**
     * Get posts list
     */
    public function getPosts()
    {
        $model = new \erdiko\wordpress\app\models\Content;
        $post = $model->getAllPosts();
        $content = $this->getView('wordpress_post_list', $post, $model->getViewPath());
        $this->setContent($content);
    }

    /**
     * Get post content
     *
     * @param Post id || Post URL: year/month/day/post_name
     */
    public function getPost($args)
    {
        // echo "getPost(".print_r($args, true).")";

        $model = new \erdiko\wordpress\app\models\Content;
        $post = $model->getPost($args);

        $content = $this->getView('post_detail', $post, $model->getViewPath());
        $this->setContent($content);

        $this->addWpThemeExtras();
    }

    /**
     * Get pages list
     */
    public function getPages()
    {
        $model = new \erdiko\wordpress\app\models\Content;
        $post = $model->getAllPages();
        $content = $this->getView('wordpress_page_list', $post, $model->getViewPath());
        $this->setContent($content);
    }

    /**
     * Get page content
     *
     * @param Page id || Page post_name
     */
    public function getPage($args)
    {
        $model = new \erdiko\wordpress\app\models\Content;
        $post = $model->getPage($args);
        $content = $this->getView('post_detail', $post, $model->getViewPath());
        $this->setContent($content);

        // $this->addWpThemeExtras();
    }

    public function addWpThemeExtras()
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
