<?php
/*
Collapsing Pages version: 0.4.2
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
function checkCurrentPage($pageIndex, $pages) {
 /* this function checks whether a given pageIndex refers to the page that is
 * being displayed. If so, it adds all parent pages to the autoExpand array, so
 * that it is automatically expanded 
 */
  global $autoExpand;
	array_push($autoExpand, $pages[$pageIndex]->post_name);
	if ($pages[$pageIndex]->post_parent!=0) {
		for ($pageIndex2=0; $pageIndex2<count($pages); $pageIndex2++) {
		  if ($pages[$pageIndex2]->ID == $pages[$pageIndex]->post_parent) {
			  checkCurrentPage($pageIndex2,$pages);
		  }
		}
	}
}

function getSubPage($page, $pages, $parents,$subPageCount,$dropDown, $curDepth, $expanded) {
  global $expand, $expandSym, $collapseSym, $expandSymJS, $collapseSymJS,
      $autoExpand, $animate, $depth,
  $thisPage, $options;
  extract($options);
  if ($curDepth>=$depth && $depth!=-1) {
    return;
  }
  $curDepth++;
  $subPagePosts=array();
  if (in_array($page->ID, $parents)) {
    if ($dropDown==TRUE) {
      $subPageLinks.= "\n     <ul>\n";
    } else {
      $subPageLinks.= "\n     <ul id='collapsPage-" . $page->ID ."' style='display:$expanded;'>\n";
    }
    foreach ($pages as $page2) {
      //$subPageLinks.= "page2 =". $page2->term_id;
        $subPageLink2=''; // clear info from subPageLink2
      $self='';
      if ($page2->ID == $thisPage) {
        $self="class='self'";
      }
      if ($page->ID==$page2->post_parent) {
        if (!in_array($page2->ID, $parents)) {
          /* check to see if there are more subpages under this one. If the
         * page id is not in the parents array, then there should be no more
         * subpages, and we do not print a triangle dropdown, otherwise we do
         * */
          $subPageCount++;
          $subPageLinks.=( "<li class='collapsItem'>" );
        } else {
          if (in_array($page2->post_name, $autoExpand) ||
              in_array($page2->title, $autoExpand)) {
            $symbol=$collapseSym;
            $expanded = 'block';
            $show = 'hide';
            } else {
            $symbol=$expandSym;
            $expanded = 'none';
            $show = 'show';
          }
          list ($subPageLink2, $subPageCount,$subPagePosts)= getSubPage($page2, $pages, $parents,$subPageCount,$dropDown, $curDepth,$expanded);
					$subPageLinks.="<li class='collapsPage'>" .
							"<span class='collapsPage $show' " .
							"onclick='expandCollapse(" .
							"event, \"$expandSymJS\", \"$collapseSymJS\", $animate, \"collapsPage\");".
							"return false'>";
					$subPageLinks.="<span class='sym'>".$symbol;
					if ($linkToPage) {
						$subPageLinks.="</span></span>";
					} else {
						$subPageLinks.="</span>";
					}
        }
        $link2 = "<a $self href='".get_page_link($page2->ID)."' ";
        $page2PostTitle=apply_filters('the_title',$page2->post_title);
        if ($linkToPage) {
          if ( empty($page2->page_description) ) {
            $link2 .= 'title="' . $page2PostTitle. '"';
          } else {
            $link2 .= 'title="' .
                wp_specialchars(apply_filters('page_description',
                $page2->page_description,$page2)) . '"';
          }
        }
        $link2 .= '>';
        $tmp_text = '';
        if ($postTitleLength>0 && strlen($page2PostTitle)>$postTitleLength) {
          $tmp_text = substr($page2PostTitle, 0, $postTitleLength );
          $tmp_text .= ' &hellip;';
        }

        $titleText = $tmp_text == '' ? $page2PostTitle : $tmp_text;
        $link2 .= $titleText. '</a>';
        if (!$linkToPage) {
          $link2.='</span>';
        }
        $subPageLinks.= $link2 ;
        if (!in_array($page2->ID, $parents)) {
          $subPageLinks.="</li>\n";
        }
        // add in additional subpage information
        $subPageLinks.="$subPageLink2";
        // close <ul> and <li> before starting a new page
      }
    }
    if ($subPageCount>0 ) {
      $subPageLinks.= "      </ul><!-- subpagecount = $subPageCount ending subpage -->\n";
    }
      $subPageLinks.= "      </li><!-- subpagecount = $subPageCount ending subpage -->\n";
  }
  return array($subPageLinks,$subPageCount,$subPagePosts);
}
/* the page and tagging database structures changed drastically between wordpress 2.1 and 2.3. We will use different queries for page based vs. term_taxonomy based database structures */
//$taxonomy=false;
function list_pages($args) {
  global $wpdb, $expand, $expandSym, $collapseSym, $expandSymJS,
      $collapseSymJS, $animate, $depth, $thisPage, $post, $options;
  include('defaults.php');
  $options=wp_parse_args($args, $defaults);
  extract($options);
  $thisPage = $post->ID;

  if ($expand==1) {
    $expandSym='+';
    $collapseSym='—';
  } elseif ($expand==2) {
    $expandSym='[+]';
    $collapseSym='[—]';
  } elseif ($expand==3) {
    $expandSym="<img src='". get_settings('siteurl') .
         "/wp-content/plugins/collapsing-pages/" . 
         "img/expand.gif' alt='expand' />";
    $collapseSym="<img src='". get_settings('siteurl') .
         "/wp-content/plugins/collapsing-pages/" . 
         "img/collapse.gif' alt='collapse' />";
  } elseif ($expand==4) {
    $expandSym=htmlentities($customExpand);
    $collapseSym=htmlentities($customCollapse);
  } else {
    $expandSym='►';
    $collapseSym='▼';
  }
  if ($expand==3) {
    $expandSymJS='expandImg';
    $collapseSymJS='collapseImg';
  } else {
    $expandSymJS=$expandSym;
    $collapseSymJS=$collapseSym;
  }
	$inExclusionsPage = array();
	if ( !empty($inExcludePage) && !empty($inExcludePages) ) {
		$exterms = preg_split('/[,]+/',$inExcludePages);
    if ($inExcludePage=='include') {
      $in='IN';
    } else {
      $in='NOT IN';
    }
		if ( count($exterms) ) {
			foreach ( $exterms as $exterm ) {
				if (empty($inExclusionsPage))
					$inExclusionsPage = "'" . sanitize_title($exterm) . "'";
				else
					$inExclusionsPage .= ", '" . sanitize_title($exterm) . "' ";
			}
		}
	}
	if ( empty($inExclusionsPage) ) {
		$inExcludePageQuery = "AND post_name NOT IN ('')";
  } else {
    $inExcludePageQuery ="AND post_name $in ($inExclusionsPage)
    AND ID $in ($inExclusionsPage)";
  }
  $exclude=$exclude;
	if ( !empty($exclusions) ) {
		$exclusions .= ')';
  }

  global $autoExpand;
	if ($defaultExpand!='') {
		$autoExpand = preg_split('/[,]+/',$defaultExpand);
		for ($i =0; $i<count($autoExpand); $i++) {
			$autoExpand[$i]= sanitize_title($autoExpand[$i]);
		} 
  } else {
	  $autoExpand = array();
  }

  $isPage='';
  //if (get_option('collapsPageIncludePosts')) {
    $isPage="AND $wpdb->posts.post_type='page'";
  //}
  if ($sort!='') {
    if ($sort=='pageName') {
      $sortColumn="ORDER BY $wpdb->posts.post_title";
    } elseif ($sort=='pageId') {
      $sortColumn="ORDER BY $wpdb->posts.ID";
    } elseif ($sort=='pageSlug') {
      $sortColumn="ORDER BY $wpdb->posts.post_name";
    } elseif ($sort=='menuOrder') {
      $sortColumn="ORDER BY $wpdb->posts.menu_order";
    }
    $sortOrder = $sortOrder;
  } 

  echo "\n    <ul class='collapsPageList'>\n";

      $pagequery = "SELECT $wpdb->posts.ID, $wpdb->posts.post_parent, $wpdb->posts.post_title, $wpdb->posts.post_name, date($wpdb->posts.post_date) as 'date' FROM $wpdb->posts WHERE $wpdb->posts.post_status='publish' $inExcludePageQuery $isPage $sortColumn $sortOrder";
  $pages = $wpdb->get_results($pagequery);
  $parents=array();

  for ($pageIndex=0; $pageIndex<count($pages); $pageIndex++) {
    if ($pages[$pageIndex]->post_parent!=0) {
      array_push($parents, $pages[$pageIndex]->post_parent);
    }
    if ($pages[$pageIndex]->ID == $thisPage) {
			checkCurrentPage($pageIndex,$pages);
		}
  }
  if ($debug==1) {
    echo "<pre style='display:none' >";
    printf ("MySQL server version: %s\n", mysql_get_server_info());
    echo "\ncollapsPage options:\n";
    print_r($options);
    echo "PAGE QUERY: \n $pagequery\n";
    echo "\nPAGE QUERY RESULTS\n";
    print_r($pages);
    echo "\nAUTOEXPAND\n";
    print_r($autoExpand);
    echo "</pre>";
  }
  foreach( $pages as $page ) {
		$self='';
    if ($page->ID == $thisPage) {
      $self="class='self'";
    }
    if ($page->post_parent==0) {
      $lastPage= $page->ID;
      // print out page name 
      $link = "<a $self href='".get_page_link($page->ID)."' ";
      $pagePostTitle=apply_filters('the_title',$page->post_title);
			if ($linkToPage) {
				if ( empty($page->page_description) ) {
					$link .= 'title="' . $pagePostTitle. '"';
				} else {
					$link .= 'title="' .
              wp_specialchars(apply_filters('page_description',
              $page->page_description,$page)) . '"';
				}
      }
      $link .= '>';
			$tmp_text = '';
			if ($postTitleLength>0 && strlen($pagePostTitle)>$postTitleLength) {
				$tmp_text = substr($pagePostTitle, 0, $postTitleLength );
				$tmp_text .= ' &hellip;';
			}

			$titleText = $tmp_text == '' ? $pagePostTitle : $tmp_text;
      $link .= $titleText. '</a>';
			if (!$linkToPage) {
			  $link.='</span>';
			}

      $subPageCount=0;
      $expanded='none';
      if (in_array($page->post_name, $autoExpand) ||
          in_array($page->ID, $autoExpand)) {
        $expanded='block';
      }
      $curDepth=0;
      if ($depth!=0) {
        list ($subPageLinks, $subPageCount, $subPagePosts) =
            getSubPage($page, $pages, $parents,$subPageCount,$dropDown,
            $curDepth, $expanded);
      }
      if ($subPageCount>0) {
        if ($expanded=='block') {
          $showing='hide';
          $symbol=$collapseSym;
        } else {
          $showing='show';
          $symbol=$expandSym;
        }
        if (in_array($page->post_name, $autoExpand) ||
            in_array($page->ID, $autoExpand)) {
          $collapseTitle = 'title="' . __('Click to collapse'). '" ';
        } else {
          $collapseTitle = 'title="' . __('Click to expand'). '" ';
        }
        $theLi = "<li class='collapsPage '><span $collapseTitle " .
            "class='collapsPage $showing' " .
            "onclick='expandCollapse(event, \"$expandSymJS\", \"$collapseSymJS\", $animate, ".
            "\"collapsPage\"); return false'><span class='sym'> " .
            "$symbol</span>";
        if ($linkToPage) {
          $theLi.="</span>";
        }
      } else {
        $theLi="<li id='" . $page->post_name . "-nav'" . 
          " class='collapsItem'>";
      } 
      print($theLi);
      // don't include the triangles if posts are not shown and there are no
      // more subpages
      print( $link );
      echo $subPageLinks;
      // close <ul> and <li> before starting a new page
      if ($subPageCount==0 ) {
        echo "                  </li> <!-- ending page subcat count = $subPageCount-->\n";
      }
    }
  }
  echo "    </ul> <!-- ending collapsPage -->\n";
}
?>
