=== Collapsing Pages ===
Contributors: robfelty
Donate link: http://blog.robfelty.com/plugins
Plugin URI: http://blog.robfelty.com/plugins
Tags: pages, sidebar, widget
Requires at least: 2.3
Tested up to: 2.5
Stable tag: 0.2.1

This plugin uses Javascript to dynamically expand or collapsable the set of
pages for each parent page.

== Description ==

This is a very simple plugin that uses Javascript to form a collapsable set of
links in the sidebar for the pages. Every page corresponding to a given
parent page will be expanded.

It is largely based off of my Collapsing Categories and Collapsing Archives
plugins. 

== Installation ==

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
	  collapsPage();
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

Everything in the dropdown menu is contained in a div called collapsPageDiv,
so you can use that id to style things. For example, say you want the
background to change when you hover over a link: You could add this rule in
your stylesheet (or in your header.php file for your theme)

#collapsPageDiv a:hover {
  background: blue;
  color: white;
}

This will make all the links white text with a blue background when you hover
the mouse over them. If you only want this in the dropdown, and not in the
main links, you could do:

#collapsPageDiv ul ul li a:hover {
  background: blue;
  color: white;
}

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
