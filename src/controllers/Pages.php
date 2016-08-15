<?php
/**
 * Pages Controller
 *
 * @category    erdiko
 * @package     wordpress
 * @copyright   Copyright (c) 2016, Arroyo Labs, www.arroyolabs.com
 * @author      John Arroyo, john@arroyolabs.com
 */
namespace erdiko\wordpress\controllers;


class Pages extends \erdiko\core\Controller
{
    /**
     * Get
     *
     * @param mixed $var
     * @return mixed
     */
    public function get($var = null)
    {
        $model = new \erdiko\wordpress\models\Content;
        $post = $model->getAllPages();
        $data = (object)array('title' => 'Pages', 'collection' => $post);

        // Load a custom view
        $view = new \erdiko\wordpress\View('home_list', $data, $model->getViewPath());

        // @todo add a page title
        $this->setContent($view);
    }
}
