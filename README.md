Ambassador
==========

Ambassador is a small and extensible PHP 5.3 library which makes it easy to fetch and display data 
from various web services, like Twitter or Tumblr.

**Notice:** This library is not under active development anymore and may be deleted soonish.


Installation
------------

Clone or download this repository. Move the _/ambassador_ directory to your website or 
application and include the `bootstrap.php` file.

    <?php
    require 'ambassador/bootstrap.php';
    use ambassador\core\Ambassador;
    ?>


Configuration
-------------

Ambassador's default configuration should be fine in most cases. However, changing the
configuration is easy:

    Ambassador::config(array(
    	'cache_dir' => 'custom/path/to/cache',
    	'max_requests' => 2
    ));


Usage
-----

The first step is to configure one or more adapters you want to use to fetch data. This is
done using `Ambassador::add()` which takes three parameters:

1. Name of the configuration. Can be anything but you should only use letters, digits and
   underscores since this will also be the name of the cache file.
2. Name of the adapter you want to configure.
3. Actual configuration of the adapter. The parameters may be different for every adapter but 
   most will require at least one parameter (e.g. a Twitter username).

Example configuration for the Twitter adapter:

	Ambassador::add('tweets', 'Twitter', array('name' => 'johndoe'));

After configuring an adapter you can use `Ambassador::fetch()` to get the data.

	$latest_tweets = Ambassador::fetch('tweets');

You may also fetch data from several adapters at once (great for creating activity streams).

	Ambassador::add('tweets', 'Twitter', array('name' => 'johndoe'));
	Ambassador::add('posts', 'Tumblr', array('name' => 'johndoe'));
	$stream = Ambassador::fetch(array('tweets', 'posts'));


Extending
---------

Creating your own adapters is easy. Please refer to the provided adapters for now, a detailed
documentation will follow later.


Testing
-------

Ambassador uses [PHPUnit](https://github.com/sebastianbergmann/phpunit) for testing. To run 
all tests open a terminal, change to the _/ambassador_ directory and enter `$ phpunit tests`.


License
-------

MIT License (see _LICENSE_ file)
