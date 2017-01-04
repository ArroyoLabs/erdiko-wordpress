<?php
/**
 * Content Controller
 * A simple way to get wordpress content into your site
 * @note this is a work in progress.  It is however a good starting point for running headless
 *
 * @category    erdiko
 * @package     wordpress
 * @copyright   Copyright (c) 2017, Arroyo Labs, www.arroyolabs.com
 * @author      John Arroyo, john@arroyolabs.com
 */
namespace erdiko\wordpress\controllers;


class Bookmarks extends \erdiko\core\Controller
{
    /**
     * Get
     *
     * @param mixed $var
     * @return mixed
     */
    public function get($args = null)
    {
        $model = new \erdiko\wordpress\models\Bookmarks;
        // $bookmarks = $model->getBookmarks();
        $category = 'press'; // Change this to the category you wish to view
        $bookmarks = $model->getBookmarksByCategory($category);

        $data = (object) array(
          'title' => ucfirst($category),
          'collection' => $bookmarks
          );
        $view = new \erdiko\wordpress\View('bookmarks', $data, $model->getViewPath());
        $this->addView($view);

        /** SEO **/
        $this->setTitle("Links");
        $this->addMeta('description', "A collection of our links");
    }
}
