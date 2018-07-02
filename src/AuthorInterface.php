<?php
/**
 * WordPress Author interface
 *
 * @package   	erdiko\wordpress
 * @copyright 	Copyright (c) 2017 Arroyo Labs, Inc. http://www.arroyolabs.com
 * @author		John Arroyo <john@arroyolabs.com>
 */
 namespace erdiko\wordpress;

interface AuthorInterface
{
    public function getViewPath();
    public function getGravitarUrl($user, $size);
    public function getAuthor($name, $size = 200);
}
