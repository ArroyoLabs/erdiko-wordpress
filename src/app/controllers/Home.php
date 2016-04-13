<?php
/**
 * Home Controller
 *
 * @category    erdiko
 * @package     wordpress
 * @copyright   Copyright (c) 2016, Arroyo Labs, www.arroyolabs.com
 * @author      John Arroyo, john@arroyolabs.com
 */
namespace erdiko\wordpress\app\controllers;

/**
 * Wordpress content controller class
 */
class Home extends \erdiko\core\Controller
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
        $config = \Erdiko::getConfig();

        $model = new \erdiko\wordpress\app\models\Content;
        $post = $model->getAllPosts(10, 0);
        $data = (object)array(
            'title' => "{$config['site']['full_name']}", 
            'subtitle' => "{$config['site']['tagline']}", 
            'collection' => $post
            );

        // Load a custom view
        $view = new \erdiko\wordpress\View('home_list', $data, $model->getViewPath());
        $this->setContent($view);
    }
}
