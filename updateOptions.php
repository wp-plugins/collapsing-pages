<?php
foreach ( (array) $_POST['collapsPage'] as $widget_number => $widget_collapsPage ) {
  if (!isset($widget_collapsPage['title']) && isset($options[$widget_number]) ) { // user clicked cancel
    continue;
  }
      $title = strip_tags(stripslashes($widget_collapsPage['title']));
  $showPageCount='no';
  if( isset($widget_collapsPage['showPageCount']) ) {
    $showPageCount='yes';
  }
  $includePosts='no';
  if( isset($widget_collapsPage['includePosts']) ) {
    $includePosts='yes';
  }
  $sortOrder=$widget_collapsPage['sortOrder'];
  $sortBy=$widget_collapsPage['sortBy'];
  $showPosts='no';
  if($widget_collapsPage['showPosts'] == 'yes') {
    $showPosts='yes';
  }
  $inExcludePage= 'include' ;
  if($widget_collapsPage['inExcludePage'] == 'exclude') {
    $inExcludePage= 'exclude' ;
  }
  $inExcludePages=addslashes($widget_collapsPage['inExcludePages']);
  
  $expand= $widget_collapsPage['expand'];
    $exclude=addslashes($widget_collapsPage['collapsPageExclude']);
    $defaultExpand=addslashes($widget_collapsPage['collapsPageDefaultExpand']);
  $options[$widget_number] = compact( 'title','showPageCount',
      'includePosts', 'sortOrder', 'sortBy', 'expand',
      'exclude', 'defaultExpand','animate', 'inExcludePage', 'inExcludePages');
}
update_option('collapsPageOptions', $options);
$updated = true;
?>
