erdiko-wordpress
================

Erdiko WordPress integration

Installation
------------

* install wordpress in /lib/wordpress folder

* Add a symlink for the uploaded files

	mkdir -p public/sites/default
	cd public/sites/default
	ln -s ../../../lib/drupal/sites/default/files files

* Add the wordpress package

	composer require erdiko/wordpress 0.1.*

Demo
----

Add the following lines to route.json to enable wordpress support:

```
"/wordpress/": "\erdiko\wordpress\controllers\Example",
"/wordpress/:alpha": "\erdiko\wordpress\controllers\Example",
```

