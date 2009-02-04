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
  $animate=1;
  if(!isset($widget_collapsPage['animate']) ) {
    $animate=0;
  }
  $debug=0;
  if(isset($widget_collapsPage['debug']) ) {
    $debug=1;
  }
  $linkToPage=$widget_collapsPage['linkToPage'];
  $sortOrder=$widget_collapsPage['sortOrder'];
  $sort=$widget_collapsPage['sort'];
  $depth=$widget_collapsPage['depth'];
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
  $defaultExpand=addslashes($widget_collapsPage['defaultExpand']);
  $options[$widget_number] = compact( 'title','showPageCount', 'debug',
      'includePosts', 'sortOrder', 'sort', 'expand', 'depth', 'linkToPage',
      'defaultExpand','animate', 'inExcludePage', 'inExcludePages');
}
update_option('collapsPageOptions', $options);
$updated = true;
?>
