=== Collapsing Pages ===
Contributors: robfelty
Donate link: http://blog.robfelty.com/plugins
Plugin URI: http://blog.robfelty.com/plugins
Tags: pages, sidebar, widget
Requires at least: 2.6
Tested up to: 2.7beta
Stable tag: 0.2.5

This plugin uses Javascript to dynamically expand or collapsable the set of
pages for each parent page.

== Description ==

This is a very simple plugin that uses Javascript to form a collapsable set of
links in the sidebar for the pages. Every page corresponding to a given
parent page will be expanded.

It is largely based off of my Collapsing Categories and Collapsing Archives
plugins. 

== Installation ==

IMPORTANT!
Please deactivate before upgrading, then re-activate the plugin. Also, note
that in 2.7, adding the widget does not seem to work if you have "show all
widgets" selected, but it does if you select "show unused widgets" from the
widget editing menu. Hopefully this will be corrected eventually

MANUAL INSTALLATION
(the only option for pre 2.3 wordpress, unless you have the widget plugin installed)

Unpackage contents to wp-content/plugins/ so that the files are in
a collapsPage directory. Now enable the plugin. To use the plugin,
change the following where appropriate	(most likely sidebar.php):

	<ul>
	 `<?php wp_list_pages(...); ?>`
	</ul>

To something of the following:
(use a div for the dropdown menu option, or ul for the sidebar nested list
option)
`
	<?php
	  if( function_exists('collapsPage') ) {
    echo "<div id='collapsPageDiv'>\n";
	  collapsPage('%i%');
    echo "</div>\n";
	} else {
	  echo "<ul>\n";
	  wp_list_pages(...);
	  echo "</ul>\n";
	}
	?>
`

The above will fall back to the WP function for pages if you disable
the plugin.

WIDGET INSTALLATION

For those who have widget capabilities, (default in Wordpress 2.3+), installation is easier. 

Unzip contents to wp-content/plugins/ so that the files are in a
collapsing-pages directory.  You must enable the Collapsing Pages plugin,  then
simply go the Presentation > Widgets section and add the Collapsing Pages
Widget.

== Frequently Asked Questions ==

= How do I provide custom styling? =

The default style information is now contained in an option. You can edit this
option from the widget options, or from the settings page. 


== Screenshots ==

1. a few expanded pages with default theme, showing nested pages
2. a few expanded pages with default theme, showing drop down version 

== Demo ==

I use this plugin in my blog at http://blog.robfelty.com


== OPTIONS AND CONFIGURATIONS ==

  * Sort by page name, page slug,  or page id
  * Sort in ascending or descending order

== CAVEAT ==

Currently this plugin relies on Javascript to expand and collapse the links.
If a user's browser doesn't support javascript they won't see the links to the
posts, but the links to the pages will still work (which is the default
behavior in wordpress anyways)

== HISTORY ==

0.3 (2008.12.04)
  * can now use multiple instance of the widget
  * can also use manually
  * added option to animate expanding
  * added more options for expanding characters
  * consolidated javascript to share code with other collapsing plugins
  * moved inline javascript to footer to speed page load time
  * made styling an option (better flexibility and reduce number of http
    requests)

0.2.5 (2008.11.01)
  * fixed bug in that autoExpand was not available to getSubPage

0.2.4 (2008.10.28)
  * fixed bug with missing seventh argument to getSubPage when used recursively

0.2.3 (2008.07.14)
  * Added option to automatically expand some pages
  * Added option to control the number of levels of pages which are expanded
  * Added "self" class to pages in list which match the current page. No link
    is made for these. CSS can
    then be used to style these differently

0.2.2 (2008.05.23)
  * Re-fixed code so that xhtml validates
  * Added option for different expand and collapse icons

0.2.1 (2008.05.01)
  * Link now spans the whole dropdown
  * Now indicates the presence of an additional submenu (doesn't work in IE 6
    or less)
  * fixed html so that it validates correctly

0.2 (2008.04.30)
  * Now includes the possibility of providing a drop-down menu of pages and
    sub-pages, instead of a nested list. Only useful for a header navigation 

0.1.1 (2008.04.25)
  * Can exclude pages (and sub-pages of those pages)

0.1 (2008.04.23):
	Initial Release
