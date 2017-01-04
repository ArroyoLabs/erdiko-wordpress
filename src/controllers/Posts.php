<?php
/**
 * Posts Controller
 *
 * @category    erdiko
 * @package     wordpress
 * @copyright   Copyright (c) 2017, Arroyo Labs, www.arroyolabs.com
 * @author      John Arroyo, john@arroyolabs.com
 */
namespace erdiko\wordpress\controllers;


class Posts extends \erdiko\core\Controller
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
        $offset = $page*$pagesize;
        $pagingData = $model->getPaginationData($pagesize, $page);

        $post = $model->getAllPosts($pagesize, $pagingData['offset']);
        $data = (object)array(
            'title' => $config['site']['full_name'],
            'subtitle' => $config['site']['tagline'],
            'collection' => $post,
            'paging' => $pagingData,
            'feat_image' => $config['content']['defaults']['feat_image'],
            'url' => "/"
            );

        // Load a custom view
        $view = new \erdiko\wordpress\View('post_list', $data, $model->getViewPath());

        // Page Title
        $this->setTitle($config['site']['full_name']);
        $this->setContent($view);
    }
}
