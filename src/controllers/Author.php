<?php
/**
 * Author Controller
 *
 * @category    erdiko
 * @package     wordpress
 * @copyright   Copyright (c) 2016, Arroyo Labs, www.arroyolabs.com
 * @author      John Arroyo, john@arroyolabs.com
 */
namespace erdiko\wordpress\controllers;


class Author extends \erdiko\core\Controller
{
    /**
     * Get
     *
     * @param mixed $var
     * @return mixed
     */
    public function get($var = null)
    {
        $model = new \erdiko\wordpress\models\Author;
        $author = $model->getAuthor($var);
        $content = $this->getView('author', $author, $model->getViewPath());

        // echo "<pre>".print_r($author, true)."</pre>";

        /** SEO **/
        // Title
        $this->setTitle("{$author->user->display_name}'s profile");
        // Page description
        $this->addMeta('description', "Profile for {$author->user->display_name}");
        // Author
        $this->addMeta('author', $author->user->display_name);

        $this->setContent($content);
    }
}
