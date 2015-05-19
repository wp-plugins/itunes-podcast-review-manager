=== iTunes Podcast Review Manager ===

Contributors: Doug Yuen
Author URI: http://efficientwp.com
Plugin URI: http://efficientwp.com/plugins/itunes-podcast-review-manager
Tags: itunes, podcast, podcasts, podcasting, review, reviews, international, country, countries, audio
Requires at least: 4.0
Tested up to: 4.2.2
Stable tag: trunk
License: GPLv2 or later

Get your iTunes podcast reviews from all countries. Checks iTunes automatically and displays your podcast reviews in a sortable table.

== Description ==

Checks iTunes for all international reviews of a podcast. Your iTunes reviews are displayed in the backend menu, and optionally on the front end of your site using the [iprm] shortcode. iTunes is automatically checked for new podcast reviews every 4 hours. Note: sometimes in iTunes, the review feeds for certain countries are unreachable, and you will need to wait for the next automatic check or click the button to check manually.

We're working on a new service for checking your international podcast reviews. It will include features like email notifications, charts, filtering, multiple podcasts, and more. For more information and to find out when we launch, please [enter your email here](http://eepurl.com/bhU4SD "Podcast Review Service").

Created by [EfficientWP](http://efficientwp.com "EfficientWP"). Flag icons courtesy of [IconDrawer](http://www.icondrawer.com "IconDrawer").

== Installation ==

1. Upload `itunes-podcast-review-manager.zip` into your plugin directory (typically `/wp-content/plugins/`).
2. Unzip the `itunes-podcast-review-manager.zip` file.
3. Activate the plugin through the 'Plugins' menu in WordPress.
4. Go to the Podcast Reviews panel to configure settings.

== Frequently Asked Questions ==

[Plugin page on EfficientWP](http://efficientwp.com/plugins/itunes-podcast-review-manager "iTunes Podcast Review Manager")

== Screenshots ==

1. The plugin panel in the Podcast Reviews menu.

== Changelog ==

= 2.1 =
* Added flag icons in a new column
* Added iprm shortcode to display the reviews on the front end of websites
* Design changes - removed navigation borders, set button hover colors
* Added a data reset button
* Added a function to remove the cron job on plugin deactivation
* Added notices and alerts
* Updated screenshot and banner images

= 2.0 =
* Major design and UI improvements
* Code cleanup
* Added localization options
* Confirmed compatibility up to WordPress 4.2.1

= 1.2 =
* Added plugin menu icon
* Added plugin icon to plugin installer
* Added column sorting
* Added capability to get more than the 50 latest reviews for each country
* Improved backend styling
* Added link to email opt-in form for premium service

= 1.1 =
* Added review caching, so the plugin no longer checks for new reviews on every page load. It loads the last cache of reviews, unless the cache is empty, in which case it will check for reviews as it loads the page.
* Added automatic review checking every 4 hours.
* Added a manual review check button and it also displays the results of the last 5 checks.
* Rearranged display of tables and made styling changes.
* Added the total number of reviews and the review average to the main table column headings.
* Added comments to plugin code.
* Updated screenshot.

= 1.0 =
* Changed iTunes feed URLs to use https.

= 0.1 =
* Initial release.

== Upgrade Notice ==

Coming soon.

