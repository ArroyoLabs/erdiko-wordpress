<?php
/**
 * Wordpress Post Model
 * Service to pull content from wordpress
 *
 * @package     erdiko\wordpress\models
 * @copyright 	Copyright (c) 2018 Arroyo Labs, Inc. http://www.arroyolabs.com
 * @author      John Arroyo <john@arroyolabs.com>
 */
namespace erdiko\wordpress\models;

class Post
{
    public $defaultFeatImg = '/themes/clean-blog/img/post-bg.jpg';

    /**
     * Get posts list
     */
    public function getPosts($args)
    {
        $posts = array();

        return $posts;
    }

    public function getPost404()
    {
        return (object)['title' => ['rendered' => '404'], 'post_content' => "<p>Sorry, page not found :-(</p>", 'post_type' => "none"];
    }

    public function getCustomFields($postId)
    {
        // return \get_post_custom($postId);
    }

    /**
     * Get post/page content
     *
     * @param Post id || Post URL: year/month/day/post_name
     */
    public function getPost($api, $args)
    {
        // Prep the slug
        $slug   = "/".trim($args['path'], "/");
        $slug   = preg_match("/([^\/]*)$/", $slug, $matches) ? $matches[1] : $args['path'];
		$post   = $api->get("posts?slug={$slug}");

        // Check to see if there is a post at the given url
        if( empty($post) ) {
            $post = $this->getPost404();
        } else {
            $post = $post[0];
        }

        return $post;
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
     * getMeta
     * Get SEO meta tags for the html page header
     * @param $post
     * @param array $additional, additional meta tags (takes precedence over $post)
     * @return array $meta
     */
    public function getMeta($post, $additional=array())
    {
        if(!is_array($additional))
          throw new \Exception("Error in Content::getMeta(), additional meta tags must be an array");

        // Get description
        if(!empty($post->excerpt->rendered))
            $description = $post->excerpt->rendered;
        // elseif(!empty($post->custom_fields['erdiko_seo_description'][0]))
        //    $description = $post->custom_fields['erdiko_seo_description'][0];
        else
            $description = $post->post_title;

        // Get formatted post dates
        $postDate = date('c', strtotime($post->date));
        $updateDate = date('c', strtotime($post->modified));

        // Description & author
        $meta['description'] = $description;
        // $meta['author'] = $post->author->display_name; // @todo fix this

        // Open Graph
        // $meta['og:locale'] = 'en_US'; // coming from application.json now
        $meta['og:type'] = 'blog';
        $meta['og:title'] = $post->title->rendered;
        $meta['og:description'] = $description;
        // @todo remove 'http://' and set dynamically somehow
        $meta['og:url'] = "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
        $meta['og:updated_time'] = $updateDate;
        $meta['og:image'] = $post->feat_image;

        // Article
        // $meta['article:publisher'] = "https://www.facebook.com/yoast";
        // $meta['article:author'] = "https://www.facebook.com/jdevalk";
        $meta['article:section'] = 'Blog';
        $meta['article:published_time'] = $postDate;
        $meta['article:modified_time'] = $updateDate;

        // Article Tags
        $tags = array();
	    if(!empty($post->tags)) {
		    foreach ( $post->tags as $tag ) {
			    $tags[] = $tag->name;
		    } // $tag->slug
		    if ( count( $tags ) > 0 ) {
			    $meta['article:tag'] = $tags;
		    }
	    }

        // Twitter Card
        $meta['twitter:card'] = "summary_large_image";
        $meta['twitter:description'] = $description;
        $meta['twitter:title'] = $post->title->rendered;
        $meta['twitter:image'] = $post->feat_image;
        // $meta['twitter:creator'] = "@erdiko";

        // Override any default meta values (from post) with $additional meta supplied
        if(!empty($additional))
            $meta = array_merge($meta, $additional);

        return $meta;
    }

    public function getOffset($page, $pagesize)
    {
        if( empty($page) )
            return 0;
        else
            return $page * $pagesize - $pagesize;
    }

    /**
     * Get pagination data
     * @return array $pager
     */
    public function getPagerData($defaultPagesize = 10)
    {
        $pager = array();
        $pager['pagesize'] = empty($_REQUEST['pagesize'])
            ? $defaultPagesize : $_REQUEST['pagesize'];
        $pager['page'] = empty($_REQUEST['page']) ? 1 : $_REQUEST['page'];
        $pager['offset'] = $pager['page'] * $pager['pagesize'] - $pager['pagesize'];

        return $pager;
    }

    /**
     * Get pager
     */
    public function getPager(int $defaultPagesize = 10, int $count = 0)
    {
        $pagerData = $this->getPagerData($defaultPagesize);

        // Get number of pages
        $pages = ceil($count / $pagerData['pagesize']);

        // Get previous and next
        $previous  = (($pagerData['page'] - 1) < 1) ? null : $pagerData['page'] - 1;
        $next = ($pagerData['page'] == $pages) ? null : $pagerData['page'] + 1;

        return array(
            'pagesize' => $pagerData['pagesize'],
            'page' => $pagerData['page'],
            'pages' => $pages,
            'previous' => $previous,
            'next' => $next,
            'count' => $count,
            'offset' => $pagerData['offset'],
            'url' => explode("?", $_SERVER['REQUEST_URI'])[0]
            );
    }

    /**
     * Get pagination data
     * @return array $pager
     */
    public function getPagination($defaultPagesize = 10, $category=null)
    {
        $pager = array();

        $pager['pagesize'] = empty($_REQUEST['pagesize']) ?
            $defaultPagesize : $_REQUEST['pagesize'];
        $pager['page'] = empty($_REQUEST['page']) ? 1 : $_REQUEST['page'];
        $pager['offset'] = $pager['page'] * $pager['pagesize'] - $pager['pagesize'];
        $pager['pagination'] = $this->getPaginationData($pager['pagesize'], $pager['page']);

        return $pager;
    }

    public function getPostCount()
    {
        $countPosts = \wp_count_posts();
        return $countPosts->publish;
    }

    public function getCategoryCount($category, $catType = 'category')
    {
        $term = \get_term_by('slug', $category, $catType);
        return $term->count;
    }

    public function getTagCount($tag, $tagType = 'post_tag')
    {
        $term = \get_term_by('slug', $tag, $tagType);
        return $term->count;
    }
}
