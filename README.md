erdiko-wordpress
================

Run WordPress headless

You can use this module with any composer based php framework.


Installation
------------

* Install wordpress in /lib/wordpress folder

* Add the erdiko-wordpress package using composer

	composer require erdiko/wordpress 0.1.*

These additional instructions work for Erdiko, Laravel and certain other frameworks. You would need to modify slightly if you are using another framework.  If you don't care about media uploads you could ignore this alltogether.

* Add a symlink for the uploaded files

	mkdir -p public/wp-content
	cd public/wp-content
	ln -s ../../../lib/wordpress/wp-content/uploads uploads


Erdiko Demo
-----------

If you are using this module with Erdiko Add the following lines to route.json to enable the wordpress example controller:

```
"/wordpress/": "\erdiko\wordpress\controllers\Example",
"/wordpress/:alpha": "\erdiko\wordpress\controllers\Example",
"/wordpress\/([a-z0-9 \-]+)\/([a-z0-9 \-\/]+)": "\erdiko\wordpress\controllers\Content"
```

