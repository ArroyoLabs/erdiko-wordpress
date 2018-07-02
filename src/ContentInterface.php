<?php
/**
 * WordPress Content interface
 *
 * @package   	erdiko\wordpress
 * @copyright 	Copyright (c) 2017 Arroyo Labs, Inc. http://www.arroyolabs.com
 * @author		John Arroyo <john@arroyolabs.com>
 */
 namespace erdiko\wordpress;

interface ContentInterface
{
    public function getPosts($args);
    public function getPostsByTag($pageSize = -1, $offset = 0, $tag = '', $taxonomy = 'post_tag');
    public function getCategories($postId);
    public function getTags($postId);
    public function getCustomFields($postId);
    public function getPost($args, $renderWP = false);
    public function getFeaturedImage($postId, $useDefault = true);
    public function getAllPages();
    public function getPage($args);
    public function getPager(int $defaultPagesize = 10, int $count = 0);

    // Should we support these?
    public function getPost404();
    public function getPostThemed($args, $renderWP = false);
    public function getMeta($post, $additional=array());
    public function getAuthorShort($id);
    public function getCategoryLinks($post, $path="/category");
    public function getTagLinks($post, $path="/tag");

    // Do we need theme functions in the interface?
    public function themeData($data, $useWpTheme = false);
    public function themeImage($matches, $i);
    public function themeVideo($matches, $i);
    public function themeAudio($matches, $i);
    public function themePlaylist($matches, $i);
    public function themeGallery($matches, $i);
    public function themeEmbed($matches, $i);
}
