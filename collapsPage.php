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
add_action( 'wp_head', array('collapsPage','get_head'));
add_action('activate_collapsing-pages/collapsPage.php', array('collapsPage','init'));
add_action('admin_menu', array('collapsPage','setup'));

class collapsPage {

	function init() {
    $options=array(
			'showPageCount'=> 'yes' ,
			'catSort'=> 'catName' ,
			'catSortOrder'=> 'ASC' ,
			'sort'=> 'linkName' ,
			'sortOrder'=> 'ASC' ,
			'exclude'=> '' ,
			'expand'=> 0 ,
			'defaultExpand'=> ''
    );
    $collapsPageOptions=$options;
		if( function_exists('add_option') ) {
//      add_option( 'collapsPageOptions', $collapsPageOptions);
		}
	}

	function setup() {
	}

	function get_head() {
		$url = get_settings('siteurl');
    echo "<style type='text/css'>
		@import '$url/wp-content/plugins/collapsing-pages/collapsPage.css';
    </style>\n";
		echo "<script type=\"text/javascript\">\n";
		echo "// <![CDATA[\n";
		echo "// These variables are part of the Collapsing Pages Plugin version: 0.1.4\n// Copyright 2007 Robert Felty (robfelty.com)\n";
    $expandSym="<img src='". get_settings('siteurl') .
         "/wp-content/plugins/collapsing-archives/" . 
         "img/expand.gif' alt='expand' />";
    $collapseSym="<img src='". get_settings('siteurl') .
         "/wp-content/plugins/collapsing-archives/" . 
         "img/collapse.gif' alt='collapse' />";
    echo "function expandPage( e, expand,animate ) {
    if (expand==1) {
      expand='+';
      collapse='—';
    } else if (expand==2) {
      expand='[+]';
      collapse='[—]';
    } else if (expand==3) {
      expand=\"$expandSym\";
      collapse=\"$collapseSym\";
    } else {
      expand='►';
      collapse='▼';
    }
    if( e.target ) {
      src = e.target;
    }
    else {
      src = window.event.srcElement;
    }

    if (src.nodeName.toLowerCase() == 'img') {
      src=src.parentNode;
      //alert('it is an image');
    }
    srcList = src.parentNode;
    //alert(srcList)
    if (srcList.nodeName.toLowerCase() == 'span') {
      srcList= srcList.parentNode;
      src= src.parentNode;
    }
    childList = null;

    for( i = 0; i < srcList.childNodes.length; i++ ) {
      if( srcList.childNodes[i].nodeName.toLowerCase() == 'ul' ) {
        childList = srcList.childNodes[i];
      }
    }

    if( src.getAttribute( 'class' ) == 'collapsPage hide' ) {
      if (animate==1) {
        Effect.BlindUp(childList, {duration: 0.5});
      } else {
        childList.style.display = 'none';
      }
      src.setAttribute('class','collapsPage show');
      src.setAttribute('title','click to expand');
      src.innerHTML=expand;
    }
    else {
      if (animate==1) {
        Effect.BlindDown(childList, {duration: 0.5});
      } else {
        childList.style.display = 'block';
      }
      src.setAttribute('class','collapsPage hide');
      src.setAttribute('title','click to collapse');
      src.innerHTML=collapse;
    }

    if( e.preventDefault ) {
      e.preventDefault();
    }

    return false;
  }\n";

		echo "// ]]>\n</script>\n";
	}
}


		include( 'collapsPageList.php' );
function collapsPage($number) {
	list_pages($number);
}
include('collapsPageWidget.php');
?>
