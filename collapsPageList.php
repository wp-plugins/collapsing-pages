<?php
/*
Collapsing Pages version: 0.1.1
Copyright 2007 Robert Felty

This work is largely based on the Collapsing Pages plugin by Andrew Rader
(http://voidsplat.org), which was also distributed under the GPLv2. I have tried
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

// Helper functions
function getSubPage($page, $pages, $parents,$subPageCount) {
  $subPagePosts=array();
  if (in_array($page->id, $parents)) {
						$subPageLinks.= "\n     <ul style='display:none;'>\n";
    foreach ($pages as $page2) {
      //$subPageLinks.= "page2 =". $page2->term_id;
        $subPageLink2=''; // clear info from subPageLink2
      if ($page->id==$page2->post_parent) {
        if (!in_array($page2->id, $parents)) {
          // check to see if there are more subpages under this one
          $subPageCount++;
            $subPageLinks.=( "<li class='collapsPage collapsItem'>" );
        } else {
          list ($subPageLink2, $subPageCount,$subPagePosts)= getSubPage($page2, $pages, $parents,$subPageCount);
          $subPageLinks.=( "<li class='collapsPage'><span class='collapsPage show' onclick='expandPage(event); return false'>&#9658;&nbsp;</span>" );
        }
          $link2 = "<a href='".get_page_link($page2->id)."' ";
        if ( empty($page2->page_description) ) {
          $link2 .= 'title="'. sprintf(__("View all posts filed under %s"), wp_specialchars($page2->name)) . '"';
        } else {
          $link2 .= 'title="' . wp_specialchars(apply_filters('page_description',$page2->page_description,$page2)) . '"';
        }
        $link2 .= '>';
        $link2 .= $page2->post_title. "</a>";
        $subPageLinks.= $link2 ;
        if (!in_array($page2->id, $parents)) {
          $subPageLinks.="</li>\n";
        }
        // add in additional subpage information
        $subPageLinks.="$subPageLink2";
        // close <ul> and <li> before starting a new page
        $subPageLinks.= "      </ul>\n           </li> <!-- ending subpage -->\n";
      }
    }
  }
  return array($subPageLinks,$subPageCount,$subPagePosts);
}

/* the page and tagging database structures changed drastically between wordpress 2.1 and 2.3. We will use different queries for page based vs. term_taxonomy based database structures */
//$taxonomy=false;
function list_pages() {
  global $wpdb;
  if (get_option('collapsPageLinkToArchives')=='archives') {
    $archives='archives.php/';
  } elseif (get_option('collapsPageLinkToArchives')=='index') {
    $archives='index.php/';
  } elseif (get_option('collapsPageLinkToArchives')=='root') {
    $archives='';
  }
  $exclude=get_option('collapsPageExclude');
	$exclusions = '';
	if ( !empty($exclude) ) {
		$exterms = preg_split('/[,]+/',$exclude);
		if ( count($exterms) ) {
			foreach ( $exterms as $exterm ) {
				if (empty($exclusions))
					$exclusions = " AND ( $wpdb->posts.post_name <> '" . sanitize_title($exterm) . "' ";
				else
					$exclusions .= " AND $wpdb->posts.post_name <> '" . sanitize_title($exterm) . "' ";
			}
		}
	}
	if ( !empty($exclusions) ) {
		$exclusions .= ')';
  }

  $isPage='';
  //if (get_option('collapsPageIncludePosts'=='yes')) {
    $isPage="AND $wpdb->posts.post_type='page'";
  //}
  if (get_option('collapsPageSort')!='') {
    if (get_option('collapsPageSort')=='pageName') {
      $sortColumn="ORDER BY $wpdb->posts.post_title";
    } elseif (get_option('collapsPageSort')=='pageId') {
      $sortColumn="ORDER BY $wpdb->posts.id";
    } elseif (get_option('collapsPageSort')=='pageSlug') {
      $sortColumn="ORDER BY $wpdb->posts.post_name";
    }
    $sortOrder = get_option('collapsPageSortOrder');
  } 

  echo "\n    <ul id='collapsPageList'>\n";

      //$categoryquery = "SELECT $wpdb->terms.term_id, $wpdb->terms.name, $wpdb->terms.slug, $wpdb->term_taxonomy.parent FROM $wpdb->terms, $wpdb->term_taxonomy WHERE $wpdb->terms.term_id = $wpdb->term_taxonomy.term_id AND $wpdb->term_taxonomy.count >0 AND $wpdb->terms.name != 'Blogroll' AND $wpdb->term_taxonomy.taxonomy = 'category' $exclusions $sortColumn $sortOrder";
      //$postquery = "SELECT $wpdb->terms.term_id, $wpdb->terms.name, $wpdb->terms.slug, $wpdb->term_taxonomy.count, $wpdb->posts.id, $wpdb->posts.post_title, $wpdb->posts.post_name, date($wpdb->posts.post_date) as 'date' FROM $wpdb->posts, $wpdb->terms, $wpdb->term_taxonomy, $wpdb->term_relationships  WHERE $wpdb->posts.id = $wpdb->term_relationships.object_id AND $wpdb->posts.post_status='publish' AND $wpdb->terms.term_id = $wpdb->term_taxonomy.term_id AND $wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id AND $wpdb->term_taxonomy.taxonomy = 'category' $isPage";
      $pagequery = "SELECT $wpdb->posts.id, $wpdb->posts.post_parent, $wpdb->posts.post_title, $wpdb->posts.post_name, date($wpdb->posts.post_date) as 'date' FROM $wpdb->posts WHERE $wpdb->posts.post_status='publish' $exclusions $isPage $sortColumn $sortOrder";

    /* changing to use only one query 
     * don't forget to exclude pages if so desired
     */
  $pages = $wpdb->get_results($pagequery);
  $parents=array();
  foreach ($pages as $page) {
    if ($page->post_parent!=0) {
      array_push($parents, $page->post_parent);
    }
  }
  foreach( $pages as $page ) {
    if ($page->post_parent==0) {
      $url = get_settings('siteurl');
      $home=$url;
      $lastPage= $page->id;
      // print out page name 
        $link = "<a href='".get_page_link($page->id)."' ";
      if ( empty($page->page_description) ) {
        if( get_option('collapsPageShowPostCount')=='yes') {
          $link .= 'title="'. sprintf(__("View all posts filed under %s"), wp_specialchars($page->post_title)) . '"';
        } else {
          $link .= "title='View all subpages'";
        }
      } else {
        $link .= 'title="' . wp_specialchars(apply_filters('page_description',$page->page_description,$page)) . '"';
      }
      $link .= '>';
        $link .= $page->post_title.'</a>';

      // TODO not sure why we are checking for this at all TODO
      $subPageCount=0;
      list ($subPageLinks, $subPageCount, $subPagePosts)=getSubPage($page, $pages, $parents,$subPageCount);
        if ($subPageCount>0) {
          print( "      <li class='collapsPage'><span class='collapsPage show' onclick='expandPage(event); return false'>&#9658;&nbsp;</span>" );
        } else {
          print( "      <li class='collapsPage collapsItem'>" );
        } 
      // don't include the triangles if posts are not shown and there are no
      // more subpages
      print( $link );
      if (($subPageCount>0)) {
      //  print( "\n     <ul style=\"display:none;\">\n" );
      }
      echo $subPageLinks;
      // close <ul> and <li> before starting a new page
      if ($subPageCount>0 ) {
        echo "        </ul>\n";
      }
      echo "      </li> <!-- ending page -->\n";
      }
  }
  echo "    </ul> <!-- ending collapsPage -->\n";
}
?>
