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
        $model = new \erdiko\wordpress\models\Author;
        $author = $model->getAuthor($var);
        $content = $this->getView('author', $author, $model->getViewPath());
        $this->setContent($content);
    }
}
