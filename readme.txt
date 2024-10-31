=== Premise Portfolio ===
Contributors: premisewp
Donate link: http://premisewp.com/donate
Tags: portfolio, premise portfolio, minimalistic portfolio, simple portfolio, portfolio custom post type, premise wp, premise, premisewp
Requires at least: 3.9.0
Tested up to: 4.7
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Display a modern and minimalistic portfolio on your site. This is the official portfolio plugin used across premisewp.com to display the themes and plugins that we build.

== Description ==

This plugin was built to display the portfolio at <a href="http://premisewp.com" target="_blank">premisewp.com</a>. What's neat about this plugin, compared to the MANY other portfolio plugins out there, is that it was built with developers in mind. We have put together a plugin with no Options page (options are passed through filters from your theme). It offers a shortcode that accepts a few params (columns, additional classes, cat) and calls a loop template that can also be customized directly from your theme.

The idea here is that if you have a client that needs a portfolio and you are buiolding them a theme, you should be able to simply install the portfolio plugin in the client's site and then control all the options and the view directly from your theme. This way the plugin and your theme simply work nice together. When the plugin is updated none of your changes are affected.

**Customize the shortcode**
To control the view of the shortcode the easiest wasy to start is to copy the file `loop-premise-portfolio.php` located in the `view` directory of the plugin into your theme directory. From here you can change the HTML directly or add your own code. To remove any of the plugin's css simply remove the id attribute `pwpp-portfolio-grid`.

Do the same thing with the file `content-premise-portfolio.php` to control the content of a single portfolio item. To remove any of the plugin's css simply remove the id attribute `pwpp-portfolio-content`.

== Installation ==

This section describes how to install the plugin and get it working.

e.g.

1. Upload the plugin main folder to the `/wp-content/plugins/` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Start adding Portfolio Items :)

== Frequently Asked Questions ==

= Where can I find more information and documentation? =

Go to <a href="http://plugins.premisewp.com/premise-portfolio/premise-portfolio/" target="_blank">Premise Portfolio</a>.

== Changelog ==

= 1.2.3 =
* Fixes issue with view file missing.

= 1.2.2 =
* Added new filter 'pwp_portfolio_loop_excerpt' that lets you control the excerpt for portfolio items when displayed via the shortcode.
* Removed template override for portfolio categories. The loop template is now only used by the shortcode class when loading a shortcode.

= 1.2.1 =
* Added ability to change the defaults from a filter. Documented filter in the Readme.md file.

= 1.2.0 =
* Simplified templates for portfolio loop and single post.
* Added ability to filter portfolio items by category passing a param `cat` - can be a string of category names or ids sepatated by commas.

= 1.1.0 =
* Add tags and categories to Portfolio Items CPT & single template
* Fix 404 error for Portfolio Items CPT

= 1.0.0 =
* New version
