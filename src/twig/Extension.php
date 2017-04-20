<?php
namespace erdiko\wordpress\twig;


class Extension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_Filter('strip', array($this, 'stripTrim')),
            new \Twig_Filter('permalink', array($this, 'getHeadlessPermalink')),
        );
    }

    public function getFunctions()
    {
        return array(
            new \Twig_Function('featured_image', array($this, 'getFeaturedImage')),
        );
    }

    /**
     *
     */
    public function stripTrim($html, $length = 255)
    {
        $text = strip_tags($html);

        return substr($text, 0, $length);
    }

    /**
     * Get headless friendly permalink
     * @param int $postId
     * @return string $link
     */
    function getHeadlessPermalink($postId)
    {
        $url = get_permalink($postId);
        return str_replace( home_url(), "", $url ); // strip domain (since it's headless)
    }

    /**
     * Get the featured image for a post
     * @param int $postId
     * @param boolean $useDefault if true return default image if none found
     * @return string $imageUrl
     */
    public function getFeaturedImage($postId, $default = '/themes/clean-blog/img/post-bg.jpg')
    {
        $featImg = \wp_get_attachment_url( \get_post_thumbnail_id($postId) );
        if(empty($featImg))
            $featImg = $default;

        return $featImg;
    }
}