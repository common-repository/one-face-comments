=== One-Face Comments ===
Contributors: SergeyBiryukov
Tags: comments, login
Requires at least: 2.6
Tested up to: 2.8
Stable tag: 1.5

Allows visitors to leave comments via One-Face authorization service.

== Description ==

**Since One-Face service ceased to exist, this plugin is deprecated and available for reference only.**

Allows visitors to leave comments via [One-Face](http://one-face.ru/) authorization service.
Shows the login block written in Flash, which fills the standard login forms using JavaScript.

== Installation ==

1. Upload `one-face-comments` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Open 'One-Face Comments' item under the 'Options' menu where you can set up the following options:
   * Block URL (a link to block examples is provided)
   * Width and height
   * Background color
   * Whether to use the [SWFObject](http://blog.deconcept.com/swfobject/) script for block embedding

Plugin uses the `comment_form` action to display the login block.
To insert the block manually, read [the introducing post](http://uplift.ru/2007/11/one-face-comments-15/) for version 1.5.

== Frequently Asked Questions ==

= What is One-Face? =

[One-Face](http://one-face.ru/) is a simple service that allows you to register once and then use the data you provided to login on any site with One-Face support.

Unlike OpenID, One-Face is merely a form filler, it doesn't replace your standard authorization procedure.

== Screenshots ==

1. Default login block.
2. Simple human test.
3. Compact block.

== Changelog ==

= 1.5 =
* Created options page
* Added automatic display of the authorization block
* Used localization functions

= 1.0 =
* Initial release
