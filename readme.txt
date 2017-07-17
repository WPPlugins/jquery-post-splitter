=== jQuery Post Splitter ===

Contributors: fahadmahmood, aqibraza, waxil

Tags: post splitter, slider, paged posts, pagination, ajax, carousel, multi-page, nextpage

Requires at least: 4.0


Tested up to: 4.7


Stable tag: 2.4.2

License: GPL3

License URI: https://www.gnu.org/licenses/gpl-3.0.html


This plugin will split your post and pages into multiple pages with a tag. A button to split the pages and posts is available in text editor icons.



== Description ==



jQuery Post Splitter is compatible with almost all themes and it can be implemented in 4 different ways from which you might will require one. For user friendliness, this plugin come up with a button "Split Page" and easy usage within the text editor. It is light weight and comparatively optimized so it will not interrupt your scripts uselessly.



Wordpress has an excellent, but little known, [feature](http://codex.wordpress.org/Styling_Page-Links) for splitting up long posts into multiple pages. However, a growing trend among major news and blog sites is instead to split up posts into dynamically loading sliders. While there are many slider plugins available for Wordpress, none of them quite tackles this functionality. That's where the jQuery Post Splitter comes in: it takes normal multi-page posts from Wordpress and replaces them with jQuery transition, ajax and page-refresh methods.



### What the slider does:

*	Provides an awesome functionality to combine many posts/pages into one with the shortcodes. Example: [JPS_CHUNK id="62" type="title"]

*   Replaces Wordpress' built-in post pagination funtionality with jQuery, ajax-based carousel and page-refresh method.

*   Uses hash based URLs for easy direct linking to specific slides. This also preserves the functionality of the browser's Back button.

*   Automatically adds slide navigation and a slide counter (e.g. '1 of 7') to sliders according to the preferences you set.

*   Adds the 'Insert Page Break' button to the TinyMCE post editor so that you can easily split your content into multiple pages/slides.

*   Provides an optional stylesheet for (very) basic styling of the slider navigation.

*	Optionally allows infinite looping of slides.

*	Optionally provides a link to view all slides on a single page.

*	Optionally allows for scrolling back to top when each slide loads.

*	For a complete tutorials, [join me here](http://www.tutorsloop.net/app/live.php?id=3680109) 



== Installation ==



1. Upload the 'jquery-post-splitter' directory to the `/wp-content/plugins/` directory

2. Activate the plugin through the 'Plugins' menu in WordPress

3. Customize your display options on the jQuery Post Splitter Settings page

4. Make paginated posts and pages using the newly visible 'Insert Page Break' button in the post editor



== Frequently Asked Questions ==



= How do I split up my posts into different slides? =



Just treat it like a normal Wordpress multi-page post. To make this extra-easy, the plugin activates the 'Insert Page Break' button in the post editor. Just insert your cursor wherever you want to break between slides and click the button - Bravo! You have a new slide!



For more information about Wordpress' built-in multi-page post funtionality, visit [this page](http://codex.wordpress.org/Styling_Page-Links).



= Why am I seeing an extra Next/Previous navigation element in my theme? =



Your theme contains its own `wp_link_pages()` tag to accomodate Wordpress' built-in post pagination feature. To ensure that this does not interfere with the plugin, please remove any reference to the  `wp_link_pages()` tag from your `single.php` file. Note that it is possible that the tag is inluded in a template part, rather than directly in the `single.php` file itself.



= How can I change the way the slider looks? =



The jQuery Post Splitter is designed to be syled by the user using standard CSS. On the plugin's Settings page, you can choose to use the included styles, but even these are meant only as a basic starting point.



== Screenshots ==



1. Settings Page (Premium Version)

2. Demonstration#1

3. Demonstration#2

4. Navigation Caption is Editable

5. Slider count for both top and bottom

6. Settings overview

7. Specific Post Settings

8. Pro Settings (New Features)

9. New Premium Feature In Action (Left Navigation Menu + Single Post as Multiple Posts)


== Changelog ==
= 2.4.2 =
* SEO Trick Added. [Thanks to Roman from Ukraine]

= 2.4.1 =
* endless-posts-navigation compatibility added. [Thanks to Deepak Jain]

= 2.4 =
* Usability improved.

= 2.3.5 =
* Proivde nextpage to nextpart patch in settings area. [Thanks to Rosanna Montoute]
* Pagebreak icon replaced with the JPS pagebreak icon.


= 2.3.3 =
* jQuery related bug fixed. [Thanks to Ashtyn Evans]

= 2.3.2 =
* Script improved a little more.

= 2.3.0 =
* Structure refined and YouTube embed code issue fixed with jQuery implementation. [Thanks to Brian Stewart from UK]
* Sub pages support added with a shortcode and ensured that it works with all pages too. [Thanks to Rosanna Montoute]

= 2.2.0 =

* nl2br() option provided in settings page.

= 2.1.1 =

* A JavaScript error found in console and fixed. [Thanks to Allan from Brazil]

= 2.1.0 =

* A few new features are added and a few important fixes. [Thanks to Nizar & Ahmed]

= 2.0.7 =

* An important fix related to content formatting.

= 2.0.6 =

* An important fix related to content formatting. [Thanks to Kaye & joopleberry]

= 2.0.5 =

* A serious issue is fixed related to syntax error.

= 2.0.4 =

* View Full Post repetition is fixed. [Thanks to Dorian]

= 2.0.3 =

* An important fix related to content formatting.

= 2.0.2 =

* Next button styled. [Thanks to Noman Ahmad]

= 2.0.1 =

* An important HTML/CSS fix.

= 2.0 =

* An amazing feature is added. [Thanks to Jon Grant]

= 1.3 =

* An important fix related to pagination. [Thanks to Peter Grant]

= 1.2 =

* An important fix related to layout. [Thanks to Ugo Oliver & Ahyat Pelukis]

= 1.1 =

* An important fix related to layout. [Thanks to JokusPokus]



= 1.0 =

* Intial commit.



== Upgrade Notice ==
= 2.4.2 =
SEO Trick Added.

= 2.4.1 =
Endless posts navigation compatibility added.

= 2.4 =
Usability improved.

= 2.3.5 =
Two important updates are available.

= 2.3.3 =
An important jQuery related bug fixed.


= 2.3.2 =
Upgrade will not affect your existings settings. If you are a pro user, download latest copy from the website.

= 2.3.0 =
Please don't update if you don't want to setup the things again.

= 2.2.0 =

nl2br() option provided in settings page.

= 2.1.1 =

A JavaScript error found in console and fixed.

= 2.1.0 =

A few new features are added and a few important fixes.

= 2.0.7 =

An important fix related to content formatting.

= 2.0.6 =

Content formatting related fix.

= 2.0.5 =

A serious issue is fixed.

= 2.0.4 =

View Full Post repetition is fixed.

= 2.0.3 =

Content formatting related fix.

= 2.0.2 =

Next button styled.

= 2.0.1 =

An important HTML/CSS fix.

= 2.0 =

No need to update if you are fine with the current version.

= 1.3 =

You can update fearlessly, it's a bug free version.

= 1.2 =

Get this update if you were facing the layout issue before.

= 1.1 =

An important fix related to layout.

