=== WP Slideshow Posts ===
Contributors: Bobjmp
Tags: slideshow,  slides, WP Slideshow Posts, responsive slideshow, wp slideshow, slideshow posts, image gallery, images, gallery, featured content, content gallery, slideshow gallery
Requires at least: 3.0
Tested up to: 3.8
Stable tag: 1.1.2
License: GPLv2 or later

Show your posts on a responsive slideshow

== Description ==

A plugin capable of capturing your posts and show in a very beautiful slideshow with images, titles and summary. Prepared to be simple, uncomplicated and meet the needs of most bloggers.

= Breaking News = 

A small bar titles without images, without summary with only the title of the posts and a random link.

= Full slideshow = 

A slideshow with images, title of the posts, summary, next and previous buttons and pagination.

= Main Features = 

**Easy:** Simplified to any user can use without major difficulties, insert a small piece of code somewhere in your template to start operating the slide. After that you can on or off in the options panel.

**Unlimited Colors:** Choose colors that suit your website, you can choose background colors, text colors and links colors.

**Responsive:** Slideshow totally flexible, adaptable to different types of screens.

**Show Posts:** Display recent posts, popular posts or posts for IDs.

**Show Category:** Select a category and slides show only posts related to it.

**Show Pages:** Show only the most recent pages of your blog or select IDs.

**Show Post Type:** Show only the post type of your blog.

**Individual Configuration:** You can use slides with different styles for each page.  You can choose to mostar a gallery of images without any text and use a slider on another page with text, links and buttons.

== Installation ==

1. Unpack to obtain the 'wp-slideshow-posts' folder
2. Upload 'wp-slideshow-posts' to the '/wp-content/plugins/' directory
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Configure the settings according to your needs on menu 'Settings > WP Slideshow Posts'

= Use the code below to show breaking news slider =

`<?Php if ( function_exists( 'wpsp_breakingnews' ) ) { wpsp_breakingnews(); } ?>`

= Use one of two options to add full slideshow in blog =

* Insert code in template place display:

`<?Php if ( function_exists( 'wpsp_Slideshow' ) ) { wpsp_Slideshow(); } ?>`

* Add shortcodes into the post:

[slideshow-wpsp]

= Use different configuration for each slideshow =

* disable title:

`<?Php if ( function_exists( 'wpsp_Slideshow' ) ) { wpsp_Slideshow('0,1,1,1'); } ?>

[slideshow-wpsp display="0,1,1,1"]`

* disable description:

`<?Php if ( function_exists( 'wpsp_Slideshow' ) ) { wpsp_Slideshow('1,0,1,1'); } ?>

[slideshow-wpsp display="1,0,1,1"]`

* disable NEXT/PREV button:

`<?Php if ( function_exists( 'wpsp_Slideshow' ) ) { wpsp_Slideshow('1,1,0,1'); } ?>

[slideshow-wpsp display="1,1,0,1"]`

* disable pagination:

`<?Php if ( function_exists( 'wpsp_Slideshow' ) ) { wpsp_Slideshow('1,1,1,0'); } ?>

[slideshow-wpsp display="1,1,1,0"]`

== Frequently Asked Questions ==

= Whence the images used by the slider? =

_ Wp Slideshow posts search featured image, if not find use images within posts.

= I use multiple slideshow in my blog? =

_ Yes, but only one per page.

= I use full slideshow and small slideshow together on the same page? =

_ yes

== Screenshots ==

1. Small slide title bar with breaking news

2. Full slide with image and summary

== Changelog ==

= 1.1.2 =

* Tabbed Panel.
* Option Post Type.
* Breaking News Posts Options.
* Set Number of Words for Abstract.
* Option Unnumbered Pagination.
* CSS Enhancements.

= 1.1.1 =

* Bug fix in css style and individualized configuration.

= 1.1.0 =

* Added ToolTip for link random.
* Added options transition time in setting page.
* Disable breaking news for devices 450px.
* CSS improvements for slideshow.
* Implementation icon fonts.
* Unlimited colors.
* individualized configuration slider.

= 1.0.0 =

* Initial release of the WP Slideshow Posts