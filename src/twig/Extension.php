<?php
namespace erdiko\wordpress\twig;


class Extension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_Filter('strip', array($this, 'stripTrim')),
        );
    }

    public function getFunctions()
    {
        return array(
            new \Twig_Function('permalink', array($this, 'getHeadlessPermalink')),
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
     * @param string $link
     * @return string $url
     */
    function getHeadlessPermalink($link)
    {
        return str_replace( home_url(), "", $link ); // strip domain (since it's headless)
    }

    /**
     * Get the featured image for a given post
     * @param object $post
     * @param string $default default image url, used when there is no featured
     * @return string $imageUrl
     */
    public function getFeaturedImage($post, $default = '/themes/clean-blog/img/post-bg.jpg')
    {
		// get from embed, if embed empty grab from another api call, if no embed use default.
		if ( !empty( $post->_embedded->{'wp:featuredmedia'}[0]->source_url )) {
			$featImg = $post->_embedded->{'wp:featuredmedia'}[0]->source_url;

		} elseif ( empty($post->_embedded->{'wp:featuredmedia'}) ) {
			// make an API call for the featured image?
            // $post->_links->{'wp:featuredmedia'}[0]['href'];
		}

        if( empty($featImg) )
            $featImg = $default;

        return $featImg;
    }
}
