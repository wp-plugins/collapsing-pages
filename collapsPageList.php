<?php
/*
Collapsing Pages version: 0.2.5
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
function getSubPage($page, $pages, $parents,$subPageCount,$dropDown, $depth, $expanded) {
  global $expand, $collapse, $autoExpand;
  if ($depth>=get_option('collapsPageDepth') && get_option('collapsPageDepth')!=-1) {
    return;
  }
  $depth++;
  $subPagePosts=array();
  if (in_array($page->id, $parents)) {
    if ($dropDown==TRUE) {
      $subPageLinks.= "\n     <ul>\n";
    } else {
      $subPageLinks.= "\n     <ul style='display:$expanded;'>\n";
    }
    foreach ($pages as $page2) {
      //$subPageLinks.= "page2 =". $page2->term_id;
        $subPageLink2=''; // clear info from subPageLink2
      if ($page->id==$page2->post_parent) {
        if (!in_array($page2->id, $parents)) {
          /* check to see if there are more subpages under this one. If the
           * page id is not in the parents array, then there should be no more
           * subpages, and we do not print a triangle dropdown, otherwise we do
           * */
          $subPageCount++;
          if ($dropDown=TRUE) {
            $subPageLinks.=( "        <li class='collapsPage collapsItem'>" );
            //$subPageLinks.=( "<li>" );
          } else {
            $subPageLinks.=( "<li class='collapsPage collapsItem'>" );
          }
        } else {
          list ($subPageLink2, $subPageCount,$subPagePosts)= getSubPage($page2, $pages, $parents,$subPageCount,$dropDown, $depth,$expanded);
          if ($dropDown==TRUE) {
            $subPageLinks.=( "<li class='submenu'>" );
          } else {
            if (in_array($page2->post_name, $autoExpand) ||
              in_array($page2->title, $autoExpand)) {
              $subPageLinks.=( "<li class='collapsPage'><span class='collapsPage show' onclick='expandPage(event); return false'>foo$collapse&nbsp;</span>" );
            } else {
              $subPageLinks.=( "<li class='collapsPage'><span class='collapsPage show' onclick='expandPage(event); return false'>$expand&nbsp;</span>" );
            }
          }
        }
          $link2 = "<a href='".get_page_link($page2->id)."' ";
        if ( empty($page2->page_description) ) {
          //$link2 .= 'title="'. sprintf(__("View all posts filed under %s"), wp_specialchars($page2->name)) . '"';
        } else {
          //$link2 .= 'title="' . wp_specialchars(apply_filters('page_description',$page2->page_description,$page2)) . '"';
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
      }
    }
    if ($subPageCount>0 ) {
      //$subPageLinks.= "      </ul>\n           </li> <!-- ending subpage -->\n";
      $subPageLinks.= "      </ul><!-- subpagecount = $subPageCount ending subpage -->\n";
    }
      $subPageLinks.= "      </li><!-- subpagecount = $subPageCount ending subpage -->\n";
  }
  return array($subPageLinks,$subPageCount,$subPagePosts);
}

/* the page and tagging database structures changed drastically between wordpress 2.1 and 2.3. We will use different queries for page based vs. term_taxonomy based database structures */
//$taxonomy=false;
function list_pages() {
  global $wpdb, $expand, $collapse;
  // option for what sort of icon to display for expanding and collapsing
  $expand='&#9658;';
  $collapse='&#9660;';

  if (get_option('collapsPageExpand')==1) {
    $expand='+';
    $collapse='&mdash;';
  }
  if (get_option('collapsPageLinkToArchives')=='archives') {
    $archives='archives.php/';
  } elseif (get_option('collapsPageLinkToArchives')=='index') {
    $archives='index.php/';
  } elseif (get_option('collapsPageLinkToArchives')=='root') {
    $archives='';
  }
  $dropDown=FALSE;
  if (get_option('collapsPageDropDown')=='yes') {
    $dropDown=TRUE;
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

  global $autoExpand;
	if (get_option('collapsPageDefaultExpand')!='') {
		$autoExpand = preg_split('/[,]+/',get_option('collapsPageDefaultExpand'));
  } else {
	  $autoExpand = array();
  }

  //$autoExpand=array('plugins', 'about');

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
    } elseif (get_option('collapsPageSort')=='menuOrder') {
      $sortColumn="ORDER BY $wpdb->posts.menu_order";
    }
    $sortOrder = get_option('collapsPageSortOrder');
  } 

  if ($dropDown==TRUE) {
    //echo "\n    <div id='collapsPageDiv'>\n";
  } else {
    echo "\n    <ul id='collapsPageList'>\n";
  }

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
    $thisPage= preg_replace('/\//', '', $_SERVER['REQUEST_URI']);  
      if ($thisPage=='') {
				$thisPage=$wpdb->get_var("SELECT option_value FROM $wpdb->options WHERE
					option_name = 'page_on_front'");
      }
		$self='';
    if ($page->id == $thisPage || $page->post_name == $thisPage) {
      $self='self';
    }
    if ($page->post_parent==0) {
      $url = get_settings('siteurl');
      $home=$url;
      $lastPage= $page->id;
      // print out page name 
      if ($dropDown==TRUE) {
        //$link = "<a  class='dropDownPage show' onhover='dropDownPage(event); return false' href='".get_page_link($page->id)."' ";
        $link = "<a href='".get_page_link($page->id)."' ";
      } else {
        $link = "<a href='".get_page_link($page->id)."' ";
      }
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
      if ($dropDown==TRUE) {
        $link .= $page->post_title.'</a></h2>';
      } else {
        //$link .= "<img src='" . get_bloginfo('template_directory') . 
        //  "/images/" . $page->post_name. "-nav48.gif' alt='" . 
         // $page->post_name . "navigation icon' />";
        $link .= $page->post_title.'</a>';
      }

      // TODO not sure why we are checking for this at all TODO
      $subPageCount=0;
      $depth=0;
      $expanded='none';
      if (in_array($page->post_name, $autoExpand) ||
          in_array($page->title, $autoExpand)) {
        $expanded='inline';
      }
      if (get_option('collapsPageDepth')!=0) {
        list ($subPageLinks, $subPageCount, $subPagePosts)=getSubPage($page, $pages, $parents,$subPageCount,$dropDown, $depth, $expanded);
      }
        if ($subPageCount>0) {
          if ($dropDown==TRUE) {
            print( "      <ul><li class='$self'><h2>" );
          } else {
            if ($expanded=='inline') {
              print ("<li class='collapsPage $self'><span class='collapsPage hide' onclick='expandPage(event); return false'>$collapse&nbsp;</span>" );
            } else {
              print ( "<li class='collapsPage $self'><span class='collapsPage show' onclick='expandPage(event); return false'>$expand&nbsp;</span>" );
            }
          //print( "      <li class='collapsPage'><span class='collapsPage show' onclick='expandPage(event); return false'>$expand&nbsp;</span>" );
          }
        } else {
            //  print $page->title . "is NOT in the array\n";
          if ($dropDown==TRUE) {
            print( "      <ul><li class='$self'><h2>" );
          } else {
            print( "<li id='" . $page->post_name . "-nav'" . 
              " class='collapsPage collapsItem $self'>" );
            //print("<li id='" . $page->post_name . "-nav' " .
              //"class='collapsPage collapsItem'>" );
          }
        } 
      // don't include the triangles if posts are not shown and there are no
      // more subpages
      print( $link );
      if (($subPageCount>0)) {
      //$subPageLinks.= "      </ul>\n           </li> <!-- ending subpage -->\n";
      //$subPageLinks.= "           </li> <!-- ending subpage -->\n";
      //  print( "\n     <ul style=\"display:none;\">\n" );
      }
      echo $subPageLinks;
      // close <ul> and <li> before starting a new page
      if ($dropDown==TRUE) {
        if ($subPageCount>0 ) {
          echo "        </ul>\n";
        } else {
          echo "      </li></ul> <!-- ending page -->\n";
        }
      } else {
        if ($subPageCount==0 ) {
          echo "                  </li> <!-- ending page subcat count = $subPageCount-->\n";
        }
        //echo "            </ul>      </li> <!-- ending page -->\n";
      }
    }
  }
  if ($dropDown==TRUE) {
    echo "    <!-- ending collapsPage -->\n";
  } else {
    echo "    </ul> <!-- ending collapsPage -->\n";
  }
}
?>
