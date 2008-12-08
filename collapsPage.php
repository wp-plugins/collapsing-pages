<?php
/*
Plugin Name: Collapsing Pages
Plugin URI: http://blog.robfelty.com/plugins/collapsing-pages
Description: Uses javascript to expand and collapse pages to show the posts that belong to the link category 
Author: Robert Felty
Version: 0.3
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

add_action('wp_head', wp_enqueue_script('scriptaculous-effects'));
add_action('wp_head', wp_enqueue_script('collapsFunctions', "$url/wp-content/plugins/collapsing-pages/collapsFunctions.js"));
add_action( 'wp_head', array('collapsPage','get_head'));
add_action('activate_collapsing-pages/collapsPage.php', array('collapsPage','init'));
add_action('admin_menu', array('collapsPage','setup'));

class collapsPage {

	function init() {
    if (!get_option('collapsPage')) {
      $options=array('%i%' => array(
        'title' => 'Pages', 
        'showPostCount'=> 'yes' ,
        'sortOrder'=> 'ASC' ,
        'sort'=> 'pageName' ,
        'defaultExpand'=> '',
        'expand' => '1',
        'depth' =>'-1',
        'inExcludePage' => 'include',
        'inExcludePages' => '',
        'showPosts' => 'yes',
        'showPages' => 'no',
        'animate' => 1,
      ));
      if( function_exists('add_option') ) {
        add_option( 'collapsPageOptions', $options);
      }
    }
	}

	function setup() {
	}

	function get_head() {
		$url = get_settings('siteurl');
		//echo "<script type ='text/javascript' src='$url/wp-content/plugins/collapsing-pages/collapsPage.js'></script>";
    echo "<style type='text/css'>
		@import '$url/wp-content/plugins/collapsing-pages/collapsPage.css';
    </style>\n";
		echo "<script type=\"text/javascript\">\n";
		echo "// <![CDATA[\n";
		echo "// These variables are part of the Collapsing Pages Plugin version: 0.3\n// Copyright 2007 Robert Felty (robfelty.com)\n";
    $expandSym="<img src='". get_settings('siteurl') .
         "/wp-content/plugins/collapsing-pages/" . 
         "img/expand.gif' alt='expand' />";
    $collapseSym="<img src='". get_settings('siteurl') .
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


		include( 'collapsPageList.php' );
function collapsPage($number) {
	list_pages($number);
}
include('collapsPageWidget.php');
?>
