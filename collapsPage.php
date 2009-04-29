<?php
/*
Plugin Name: Collapsing Pages
Plugin URI: http://blog.robfelty.com/plugins/collapsing-pages
Description: Uses javascript to expand and collapse pages to show the posts that belong to the link category 
Author: Robert Felty
Version: 0.4.2
Author URI: http://robfelty.com
Tags: sidebar, widget, pages

Copyright 2007 Robert Felty

This file is part of Collapsing Pages

		Collapsing Pages is free software; you can redistribute it and/or
    modify it under the terms of the GNU General Public License as published by 
    the Free Software Foundation; either version 2 of the License, or (at your
    option) any later version.

    Collapsing Pages is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Collapsing Pages; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/ 

if (!is_admin()) {
  add_action('wp_head', wp_enqueue_script('scriptaculous-effects'));
  add_action('wp_head', wp_enqueue_script('collapsFunctions',
  "$url/wp-content/plugins/collapsing-pages/collapsFunctions.js",'', '1.2'));
  add_action( 'wp_head', array('collapsPage','get_head'));
  add_action( 'wp_footer', array('collapsPage','get_foot'));
}
add_action('init', array('collapsPage','init_textdomain'));
add_action('activate_collapsing-pages/collapsPage.php', array('collapsPage','init'));
add_action('admin_menu', array('collapsPage','setup'));

class collapsPage {
	function init_textdomain() {
	  $plugin_dir = basename(dirname(__FILE__));
	  load_plugin_textdomain( 'collapsing-pages', 'wp-content/plugins/' . $plugin_dir, $plugin_dir );
	}

	function init() {
	  include('collapsPageStyles.php');
		$defaultStyles=compact('custom','selected','default','block','noArrows');
    if( function_exists('add_option') ) {
      update_option( 'collapsPageOrigStyle', $style);
      update_option( 'collapsPageDefaultStyles', $defaultStyles);
    }
    if (!get_option('collapsPageStyle')) {
      add_option( 'collapsPageStyle', $style);
		}
    if (!get_option('collapsPageSidebarId')) {
      add_option( 'collapsPageSidebarId', 'sidebar');
		}
	}

	function setup() {
		if( function_exists('add_options_page') ) {
			add_options_page(__('Collapsing Pages', 'collapsing-pages'),__('Collapsing
      Pages', 'collapsing-pages'),1,basename(__FILE__),array('collapsPage','ui'));
		}
	}
	function ui() {
		include_once( 'collapsPageUI.php' );
	}

	function get_head() {
    $style=stripslashes(get_option('collapsPageStyle'));
    echo "<style type='text/css'>
    $style
    </style>\n";

	}
  function get_foot() {
		$url = get_settings('siteurl');
		echo "<script type=\"text/javascript\">\n";
		echo "// <![CDATA[\n";
		echo '/* These variables are part of the Collapsing Pages Plugin
		       *version: 0.4.2
		       *revision: $Id$
					 * Copyright 2007 Robert Felty (robfelty.com)
					 */'. "\n";
    $expandSym="<img src='". $url .
         "/wp-content/plugins/collapsing-pages/" . 
         "img/expand.gif' alt='expand' />";
    $collapseSym="<img src='". $url .
         "/wp-content/plugins/collapsing-pages/" . 
         "img/collapse.gif' alt='collapse' />";
    echo "var expandSym=\"$expandSym\";";
    echo "var collapseSym=\"$collapseSym\";";
    echo"
    addLoadEvent(function() {
      autoExpandCollapse('collapsPage');
    });
    ";
		echo ";\n// ]]>\n</script>\n";
  }
}


function collapsPage($number) {
  if (!is_admin()) {
    include( 'collapsPageList.php' );
    list_pages($number);
  }
}
include('collapsPageWidget.php');
?>
