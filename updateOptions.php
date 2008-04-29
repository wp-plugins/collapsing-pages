<?php
  if( isset($_POST['showPageCount']) ) {
    update_option( 'collapsPageShowPageCount', 'yes' );
  }
  else {
    update_option( 'collapsPageShowPageCount', 'no' );
  }
  if( isset($_POST['includePosts']) ) {
    update_option( 'collapsPageIncludePosts', 'yes' );
  }
  else {
    update_option( 'collapsPageIncludePosts', 'no' );
  }
  if($_POST['archives'] == 'root') {
    update_option( 'collapsPageLinkToArchives', 'root' );
  } elseif ($_POST['archives'] == 'archives') {
    update_option( 'collapsPageLinkToArchives', 'archives' );
  } elseif ($_POST['archives'] == 'index') {
    update_option( 'collapsPageLinkToArchives', 'index' );
  }
  if($_POST['sortOrder'] == 'ASC') {
    update_option( 'collapsPageSortOrder', 'ASC' );
  } elseif ($_POST['sortOrder'] == 'DESC') {
    update_option( 'collapsPageSortOrder', 'DESC' );
  }
  if($_POST['sort'] == 'pageName') {
    update_option( 'collapsPageSort', 'pageName' );
  } elseif ($_POST['sort'] == 'pageId') {
    update_option( 'collapsPageSort', 'pageId' );
  } elseif ($_POST['sort'] == 'pageSlug') {
    update_option( 'collapsPageSort', 'pageSlug' );
  } elseif ($_POST['sort'] == '') {
    update_option( 'collapsPageSort', '' );
    update_option( 'collapsPageSortOrder', '' );
  }
  if($_POST['showPosts'] == 'yes') {
    update_option( 'collapsPageShowPosts', 'yes' );
  } elseif ($_POST['showPosts'] == 'no') {
    update_option( 'collapsPageShowPosts', 'no' );
  }
  if($_POST['exclude']) {
    $excludeSafe=addslashes($_POST['exclude']);
    //$excludeSafe=wp_texturize($_POST['exclude']);
    update_option( 'collapsPageExclude', $excludeSafe);
  }
?>
