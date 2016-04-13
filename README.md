erdiko-wordpress
================

Run WordPress headless

You can use this module with any composer based php framework.


Installation
------------

* Install wordpress in /lib/wordpress folder or point to your existing wordpress root by adding this to your /app/appstrap.php file

```
    define('WORDPRESS_ROOT', '/this/is/the/wordpress/path');
```

* Add the erdiko-wordpress package using composer

```
    composer require erdiko/wordpress 0.2.*
```

These additional instructions work for Erdiko, Laravel and certain other frameworks. You would need to modify slightly if you are using another framework.  If you don't care about media uploads you could ignore this alltogether.

* Add a symlink for the uploaded files

```
	mkdir -p public/wp-content
	cd public/wp-content
	ln -s ../../../lib/wordpress/wp-content/uploads uploads
```

Erdiko Demo
-----------

If you are using this module with Erdiko Add the following lines to your routes.json file to enable the wordpress example and content controllers.  They are a good way to get a jumpstart running headless.  Use this as an example or roll your own.  Afterall, all that is really needed to get WordPress data is to create a model that extends erdiko\wordpress\Model.

Update your /app/config/application/routes.json with:

```
"/wordpress/": "\erdiko\wordpress\app\controllers\Example",
"/wordpress/:alpha": "\erdiko\wordpress\app\controllers\Example",
"/wordpress\/([a-z0-9 \-]+)\/([a-z0-9 \-\/]+)": "\erdiko\wordpress\app\controllers\Content"
```

