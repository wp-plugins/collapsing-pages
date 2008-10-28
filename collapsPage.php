<?php
/*
Plugin Name: Collapsing Pages
Plugin URI: http://blog.robfelty.com/plugins
Description: Uses javascript to expand and collapse pages to show the posts that belong to the page 
Author: Robert Felty
Version: 0.2.4
Author URI: http://robfelty.com
Tags: sidebar, widget, pages, pages

Copyright 2007 Robert Felty

This work is largely based on the Fancy Pages plugin by Andrew Rader
(http://nymb.us), which was also distributed under the GPLv2. I have tried
contacting him, but his website has been down for quite some time now. See the
CHANGELOG file for more information.

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

add_action( 'wp_head', array('collapsPage','get_head'));
add_action('activate_collapsing-pages/collapsPage.php', array('collapsPage','init'));
add_action('admin_menu', array('collapsPage','setup'));

class collapsPage {

	function init() {
		if( function_exists('add_option') ) {
			add_option( 'collapsPageShowPostCount', 'yes' );
			add_option( 'collapsPageIncludePosts', 'no' );
			add_option( 'collapsPageLinkToArchives', 'root' );
			add_option( 'collapsPageSort', 'pageName' );
			add_option( 'collapsPageSortOrder', 'ASC' );
			add_option( 'collapsPageShowPosts', 'yes' );
			add_option( 'collapsPageExpand', '0' );
			add_option( 'collapsPageExclude', '' );
			add_option( 'collapsPageDropDown', 'no' );
			add_option( 'collapsPageDepth', '-1' );
			add_option( 'collapsPageDefaultExpand', '' );
		}
	}

	function setup() {
		if( function_exists('add_options_page') ) {
			add_options_page(__('Collapsing Pages'),__('Collapsing Pages'),1,basename(__FILE__),array('collapsPage','ui'));
		}
	}

	function ui() {
		include_once( 'collapsPageUI.php' );
	}


	function get_head() {
		$url = get_settings('siteurl');
    echo "<style type='text/css'>
		@import '$url/wp-content/plugins/collapsing-pages/collapsPage.css';
    /*
    #collapsPageDiv ul ul li.submenu {
      background: url($url/wp-content/plugins/collapsing-pages/submenu.png) no-repeat top right;
    }
    */
    </style>\n";
		echo "<script type=\"text/javascript\">\n";
		echo "// <![CDATA[\n";
		echo "// These variables are part of the Collapsing Pages Plugin version: 0.2.4\n// Copyright 2007 Robert Felty (robfelty.com)\n";
    $expand='&#9658;';
    $collapse='&#9660;';

    if (get_option('collapsPageExpand')==1) {
      $expand='+';
      $collapse='&mdash;';
    }
    echo "function expandPage( e ) {
    if( e.target ) {
      src = e.target;
    }
    else {
      src = window.event.srcElement;
    }

    srcList = src.parentNode;
    childList = null;

    for( i = 0; i < srcList.childNodes.length; i++ ) {
      if( srcList.childNodes[i].nodeName.toLowerCase() == 'ul' ) {
        childList = srcList.childNodes[i];
      }
    }

    if( src.getAttribute( 'class' ) == 'collapsPage hide' ) {
      childList.style.display = 'none';
      src.setAttribute('class','collapsPage show');
      src.setAttribute('title','click to expand');
      src.innerHTML='$expand&nbsp;';
    }
    else {
      childList.style.display = '';
      src.setAttribute('class','collapsPage hide');
      src.setAttribute('title','click to collapse');
      src.innerHTML='$collapse&nbsp;';
    }

    if( e.preventDefault ) {
      e.preventDefault();
    }

    return false;
  }\n";

		echo "// ]]>\n</script>\n";
    if (get_option('collapsPageDropDown')==TRUE) {
      $url = get_settings('siteurl');
      echo "
      <style type='text/css' media='screen'>
      @import '$url/wp-content/plugins/collapsing-pages/cssmenu.css';
      </style>
      <!--[if IE]>
      <style type='text/css' media='screen'>
      /* #collapsPageDiv ul li {float: left; width: 100%;}*/
      </style>
      <![endif]-->
      <!--[if lt IE 7]>
      <style type='text/css' media='screen'>
      body {
      behavior: url($url/wp-content/plugins/collapsing-pages/csshover.htc);
      font-size: 100%;
      }
      #collapsPageDiv ul li a {height: 1%;
       width:100%;} 

      #collapsPageDiv a, #collapsPageDiv h2 {
      font: bold 1.0em/1.4em arial, helvetica, sans-serif;
      }
      #collapsPageDiv ul ul {
      background:transparent;
      width:6em;
      position: absolute;
      top:1.1em;
      z-index: 500;
      text-align:left;
      }

      #collapsPageDiv li li {
      position:relative;
      text-align:left;
      /*padding-right:50em;*/
      width:10em;
      z-index: 1000;
      }
      #collapsPageDiv li li li {z-index:500;
/*      background:white;*/
}

      #collapsPageDiv ul ul ul {
      position: absolute;
      width:6em;
      background:blue;
      top: 0em;
      /*position: absolute;
      top: 0;
      left: 100%;*/
      }

      </style>
      <![endif]-->";
    }

	}
}


		include( 'collapsPageList.php' );
function collapsPage() {
	list_pages();
}
include('collapsPageWidget.php');
?>
