<?php
/**
 * ImageTrait
 * Useful functions for dealing with featured images
 *
 * @package     erdiko/wordpress/traits
 * @copyright 	Copyright (c) 2017, Arroyo Labs, http://www.arroyolabs.com
 * @author      John Arroyo <john@arroyolabs.com>
 */
namespace erdiko\wordpress\traits;

use \erdiko\core\Helper as Erdiko;

trait ImageTrait
{
    public $defaultFeatImg = '/themes/clean-blog/img/post-bg.jpg';

    /**
     * get path for views
     */
    public function getViewPath()
    {
        return dirname(__DIR__);
    }

    /**
     * Get the featured image for a post
     * @param int $postId
     * @param boolean $useDefault if true return default image if none found
     * @return string $imageUrl
     */
    public function getFeaturedImage($postId, $useDefault = true)
    {
        $featImg = \wp_get_attachment_url( \get_post_thumbnail_id($postId) );
        if(empty($featImg) && $useDefault)
            $featImg = $this->defaultFeatImg;

        return $featImg;
    }

    /**
     *
     */
    public function themeFeaturedImage($image)
    {
      $newTag = Erdiko::getView('header_image', array('image_url' => $image), $this->getViewPath());

      return $newTag;
    }

    /**
     * Parse and theme wordpress image caption
     *
     * @param post content
     * @param index
     * @todo clean up: why are we sending all the matches?
     */
    public function themeImage($matches, $i)
    {
        // Strip out image and caption
        $original = $matches[5][$i];
        preg_match_all('/(\<img.*?\/\>)/s', $matches[5][$i], $imgURL);
        preg_match_all('/(?!.*\>)(.*)/s', $matches[5][$i], $caption);

        // echo "<pre>original({$i}): ".print_r($matches[5][$i], true)."</pre>";
        // echo "<pre>parsed({$i}): ".print_r($imgURL, true)."</pre>";
        // echo "<pre>caption({$i}): ".print_r($caption, true)."</pre>";

        $newTag = Erdiko::getView('image_w_caption', array('url' => $imgURL[0][0],
            'caption' => $caption[0][0]), $this->getViewPath());
        return $newTag;
    }
}