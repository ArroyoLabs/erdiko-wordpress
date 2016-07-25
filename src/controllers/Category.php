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
    /**
     * Get
     *
     * @param mixed $var
     * @return mixed
     */
    public function get($var = null)
    {
        $config = \Erdiko::getConfig();
        $model = new \erdiko\wordpress\models\Content;
        
        // Get paging info
        $pagesize = empty($_REQUEST['pagesize']) ? 
            $config['content']['defaults']['pagesize'] : $_REQUEST['pagesize'];
        $page = empty($_REQUEST['page']) ? 1 : $_REQUEST['page'];
        $pagingData = $model->getPaginationData($pagesize, $page, $var);

        $posts = $model->getAllPosts($pagesize, $pagingData['offset'], $var); // Get posts
        $data = (object)array(
            'title' => ucfirst($var),
            'collection' => $posts,
            'paging' => $pagingData,
            'feat_image' => $config['content']['defaults']['feat_image'],
            'url' => "/category/{$var}"
            );

        // Load a custom view
        $view = new \erdiko\wordpress\View('post_list', $data, $model->getViewPath());

        $this->setTitle("Category {$data->title}");
        $this->addMeta('description', "Posts in category {$data->title}");

        $this->setContent($view);
    }
}
