<?php

namespace erdiko\wordpress\controllers;

use Erdiko;
use erdiko\core\Config;

/**
 * Example Controller Class
 */
class Content extends \erdiko\core\Controller
{
    /** Before */
    public function _before()
    {
        $this->setThemeName('bootstrap');
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
     * Wordpredd example
     */
    public function getIndex()
    {
        $content = $this->getView('wordpressIndex', null, dirname(__DIR__));
        $this->setContent($content);
    }
    public function getPosts(){
        $model = new \erdiko\wordpress\model\Content;
        $post = $model->getAllPosts();
        $content = $this->getView('wordpressList', $post, dirname(__DIR__));
        $this->setContent($content);
    }
    public function getPost($args){
        $model = new \erdiko\wordpress\model\Content;
        $post = $model->getPost($args);
        $content = $this->getView('wordpressDetails', $post, dirname(__DIR__));
        $this->setContent($content);
    }
    public function getPages(){
        $model = new \erdiko\wordpress\model\Content;
        $post = $model->getAllPages();
        $content = $this->getView('wordpressPageList', $post, dirname(__DIR__));
        $this->setContent($content);
    }
    public function getPage($args){
        $model = new \erdiko\wordpress\model\Content;
        $post = $model->getPage($args);
        $content = $this->getView('wordpressDetails', $post, dirname(__DIR__));
        $this->setContent($content);
    }

}
