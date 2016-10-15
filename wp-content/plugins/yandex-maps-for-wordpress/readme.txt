=== Yandex Maps for WordPress ===
Contributors: mee.six
Tags: maps, yandex, yandex maps, shortcodes
Requires at least: 2.5.1
Tested up to: 3.3.1
Stable tag: 1.4.1

This simple plugin allows you to insert <a href="http://maps.yandex.ru">Yandex Maps</a> into your blog posts, including large cities of Eastern Europe and Russia.
== Description ==

This plugin allows you to easily insert <a href="http://maps.yandex.ru">Yandex Maps
</a> into your blog, making use of the new shortCode system in WordPress 2.5.
The maps can be configured to show or hide the zoom/pan controls, show/hide map type 
(street view, satellite, etc).  PHP5 Required. Has Wordpress MU support.

= Change log =
* 1.4.1 Baloon fixes / Multiple map fixes
* 1.4.0 CSS Bugfixes
* 1.3.1 Bugfixes
* 1.3.0 Bugfixes
* 1.2.1 Fixed bug with post edit filter
* 1.2.0 Fixed bug with nonce
* 1.1.1 Fixed bug with hook naming
* 1.1.0 Added Wordpress MU support
* 1.0.0 Initial release

== Installation ==

1. Verify that you have PHP5, which is required for this plugin.
2. Upload the whole `yandex-maps-for-wordpress` directory to the `/wp-content/plugins/` directory
3. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= Where do I insert a map into my post/page? =

When writing a post or page, there will be a meta box titled "Yandex Maps for
WordPress" just below the "Tags" and "Categories" metaboxes.

= Where can I get a Yandex Maps API Key? =

<a href="http://api.yandex.ru/maps/form.xml">http://api.yandex.ru/maps/form.xml</a>

= What unit do you expect the map width and height to be in? =

If you don't specify a unit, pixels will be used.  However, if you would like,
you can specify any valid CSS unit (em, %, etc).
