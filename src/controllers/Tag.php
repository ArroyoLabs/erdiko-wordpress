<?php
/**
 * Tag Controller
 *
 * @category    erdiko
 * @package     wordpress
 * @copyright   Copyright (c) 2016, Arroyo Labs, www.arroyolabs.com
 * @author      John Arroyo, john@arroyolabs.com
 */
namespace erdiko\wordpress\controllers;


class Tag extends \erdiko\core\Controller
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
        $posts = $model->getPostsByTag(10, 0, $var);

        $data = (object)array('title' => ucfirst($var), 'collection' => $posts);

        // Load a custom view
        $view = new \erdiko\wordpress\View('post_list', $data, $model->getViewPath());

        $this->setTitle("Tag {$data->title}");
        $this->addMeta('description', "Posts with tag {$data->title}"); // Meta from the config

        $this->setContent($view);
    }
}
