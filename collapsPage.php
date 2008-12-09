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
add_action( 'wp_footer', array('collapsPage','get_foot'));
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
    $style="span.collapsPage {border:0;
padding:0; 
margin:0; 
cursor:pointer;
/* font-family: Monaco, 'Andale Mono', Courier, monospace;*/
}

#sidebar li.collapsPage:before {content:'';} 
#sidebar li.collapsPage {list-style-type:none}
#sidebar li.collapsPagePost {
       text-indent:-1em;
       margin:0 0 0 1em;}
li.widget.collapsPage ul {margin-left:.5em;}
#sidebar li.collapsItem :before {content: \"\\00BB \\00A0\" !important;} 
#sidebar li.collapsPage .sym {
   font-size:1.2em;
   font-family:Monaco, 'Andale Mono', 'FreeMono', 'Courier new', 'Courier', monospace;
    padding-right:5px;}";
    if( function_exists('add_option') ) {
      add_option( 'collapsPageStyle', $style);
    }
	}

	function setup() {
	}

	function get_head() {
		$url = get_settings('siteurl');
    $style=get_option('collapsPageStyle');
    echo "<style type='text/css'>
    $style
    </style>\n";

	}
  function get_foot() {
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
