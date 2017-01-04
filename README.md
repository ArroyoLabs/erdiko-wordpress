erdiko-wordpress
================

* Run your your WordPress site headless

* Pull content from your wordpress CMS

You can use this module with any composer based php framework by simply running, composer require erdiko/wordpress.


Installation
------------

**1. Install WordPress**

We recommend installing WordPress in /lib/wordpress or its own folder at the same level as your main site.  For instance /wordpress and /[my-website].  However it can be anywhere as long is the codebase is accessible.  Follow the WordPress docs on how to install WordPress.

***Important*** If your WordPress codebase is in /lib/wordpress and /lib is at the same level as your vendor folder then you can skip the rest of step #1.

Add this to your codebase.
```
    define('WORDPRESS_ROOT', '/this/is/the/wordpress/path');
```

This could be added in a constants file, bootstrap file or index.php.  Follow the conventions of your framework.  If you are using Erdiko it should go in the /[my-website]/app/appstrap.php file.


**2. Add the erdiko/wordpress package using composer**

```
    composer require erdiko/wordpress
```

Usage
-----

Here are some examples of how to use this package.  See the source code for the full API.

To pull content from WordPress

	$model = new \erdiko\wordpress\Model;
	$post = $model->getPost(1);

To get an Author

	$author = new \erdiko\wordpress\models\Author;
	$author->getAuthor('name');

Get all posts

	$content = new \erdiko\wordpress\models\Content;
	$content->getAllPosts();


Create a full headless site with Erdiko
---------------------------------------

These additional instructions are for creating a complete headless blog using Erdiko.  All CMS data is coming from WordPress and is rendered in a clean bootstrap based theme.  We have included controllers, models, views and a full theme.

**1. Install Erdiko**
Using composer, it is a very simple to create an erdiko project.

	composer create erdiko/erdiko [my-project-name]

More information available at [http://erdiko.org](http://erdiko.org/)

**2. Add your routes**

Add the following lines to your routes.json file to enable the wordpress example and content controllers.  It give you a FULL headless wordpress site.  Use this as an example, extend the classes in your app or roll your own headless solution.  Keep in mind, all that is really needed to pull WordPress data is to create a model that extends erdiko\wordpress\Model.

Update your /app/config/default/routes.json with:

```
"/": "\erdiko\wordpress\controllers\Posts",
"author/:alpha": "\erdiko\wordpress\controllers\Author",
"category/:alpha": "\erdiko\wordpress\controllers\Category",
"tag/:alpha": "\erdiko\wordpress\controllers\Tag",
"/:action": "\erdiko\wordpress\controllers\Content"
```

Feel free to adjust accordingly.

**3. Copy the default theme**

We even included a sample theme that is bootstrap based.  Copy the files from your vendor folder vendor/erdiko/wordpress/app/themes/ and vendor/erdiko/wordpress/public/themes/ into your app/themes/ and public/themes folder respectively.

Theme is based on a [Start Bootstrap](https://startbootstrap.com/template-overviews/clean-blog/) theme.

**4. Add a symlink for the uploaded files (optional)**

```
	mkdir -p public/wp-content
	cd public/wp-content
	ln -s ../../../lib/wordpress/wp-content/uploads uploads
```

Notes
-----

We welcome your feedback.  Let us know how we can improve this package.

If anyone is interested in helping us port this to Laravel or Symfony please send us a message.  We would love to support more frameworks!

Sponsored by [Arroyo Labs](http://arroyolabs.com/)
