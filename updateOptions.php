<?php
      $title=$new_instance['title'];
      $sortOrder= 'ASC' ;
      if ($new_instance['sortOrder'] == 'DESC') {
        $sortOrder= 'DESC' ;
      }
      if ($new_instance['sort'] == 'catName') {
        $sort= 'catName' ;
      } elseif ($new_instance['sort'] == 'catId') {
        $sort= 'catId' ;
      } elseif ($new_instance['sort'] == 'catSlug') {
        $sort= 'catSlug' ;
      } elseif ($new_instance['sort'] == 'catOrder') {
        $sort= 'catOrder' ;
      } elseif ($new_instance['sort'] == 'catCount') {
        $sort= 'catCount' ;
      } elseif ($new_instance['sort'] == '') {
        $sort= '' ;
        $sortOrder= '' ;
      }
      $expand= $new_instance['expand'];
      $customExpand= $new_instance['customExpand'];
      $customCollapse= $new_instance['customCollapse'];
      $catTag= $new_instance['catTag'];
      $inExclude= 'include' ;
      if($new_instance['inExclude'] == 'exclude') {
        $inExclude= 'exclude' ;
      }
      $animate=0;
      if( isset($new_instance['animate'])) {
        $animate= 1 ;
      }
      $debug=false;
      if (isset($new_instance['debug'])) {
        $debug= true ;
      }
      if ($new_instance['linkToPage']=='yes') {
        $linkToPage=true;
      } else {
        $linkToPage=false;
      }
      $inExcludePages=addslashes($new_instance['inExcludePages']);
      $defaultExpand=addslashes($new_instance['defaultExpand']);
      if ($new_instance['showPosts']=='yes') {
        $showPosts= true ;
      } else {
        $showPosts=false;
      }
      $depth=$new_instance['depth'];
      $postTitleLength=$new_instance['postTitleLength'];
      $instance = compact(
          'title','sort','sortOrder','defaultExpand',
          'expand','inExcludePage','inExcludePages', 'depth',
          'animate', 'debug', 'showPosts', 'customExpand', 'customCollapse',
          'linkToPage', 'postTitleLength');

?>
