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
        print_r($arg_list);

        if(!empty($arg_list))
        {
            $response = null;
            if($arg_list[0] == "post"){
                if(count($arg_list) == 2)
                    $response = $this->getPost($arg_list[1]);
                if(count($arg_list) == 5)
                    $response = $this->getPostByUrl($arg_list[1],$arg_list[2],$arg_list[3],$arg_list[4]);
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
      //  $this->addView('examples/WordPressViewIndex');
    }
    public function getPosts(){
        $model = new \erdiko\wordpress\Model;
        $post = $model->getAllPosts();
     //   $post = $model->print_post();
        $this->addView('examples/WordPressViewList',$post);
    }
    public function getPost($id){
        $model = new \erdiko\wordpress\Model;
        $post = $model->getPost($id);
        $this->addView('examples/WordPressViewDetails',$post);
    }
    public function getPostByUrl($year,$month,$date,$name){
        $model = new \erdiko\wordpress\Model;
        $post = $model->getPostByUrl($year,$month,$date,$name);
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
