<?php

namespace app\controllers;

use Erdiko;
use erdiko\core\Config;

/**
 * Example Controller Class
 */
class WordPressController extends \erdiko\core\Controller
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
        $content = $this->getView('examples/WordPressViewIndex', null, dirname(__DIR__));
        $this->setContent($content);
    }
    public function getPosts(){
        $model = new \erdiko\wordpress\Model;
        $post = $model->getAllPosts();
        $this->addView('examples/WordPressViewList',$post);
    }
    public function getPost($args){
        $model = new \erdiko\wordpress\Model;
        $post = $model->getPost($args);
        $this->addView('examples/WordPressViewDetails',$post);
    }
    public function getPages(){
        $model = new \erdiko\wordpress\Model;
        $post = $model->getAllPages();
        $this->addView('examples/WordPressViewPageList',$post);
    }
    public function getPage($args){
        $model = new \erdiko\wordpress\Model;
        $post = $model->getPage($args);
        $this->addView('examples/WordPressViewDetails',$post);
    }
}
