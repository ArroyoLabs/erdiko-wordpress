<?php
/**
 * Category Controller
 * 
 * @category    erdiko
 * @package     wordpress
 * @copyright   Copyright (c) 2016, Arroyo Labs, www.arroyolabs.com
 * @author      John Arroyo, john@arroyolabs.com
 */
namespace erdiko\wordpress\controllers;


class Category extends \erdiko\core\Controller
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
        $model = new \erdiko\wordpress\models\Content;
        $posts = $model->getAllPosts(10, 0, $var);

        $data = (object)array('title' => ucfirst($var), 'collection' => $posts);

        // Load a custom view
        $view = new \erdiko\wordpress\View('home_list', $data, $model->getViewPath());
        $this->setContent($view);
    }
}
