<?php
if ( -1 == $number ) {
  /* default options go here */
  $number = '%i%';
  $title = 'Pages';
  $showPostCount = 'yes';
  $archSortOrder = 'DESC';
  $defaultExpand='';
  $expand='1';
  $inExcludePage='include';
  $inExcludePages='';
  $showPosts='yes';
  $showPages='no';
  $animate=1;
} else {
  $title = attribute_escape($options[$number]['title']);
  $showPostCount = $options[$number]['showPostCount'];
  $expand = $options[$number]['expand'];
  $inExcludePages = $options[$number]['inExcludePages'];
  $inExcludePage = $options[$number]['inExcludePage'];
  $defaultExpand = $options[$number]['defaultExpand'];
  $showPosts = $options[$number]['showPosts'];
  $showPages = $options[$number]['showPages'];
  $animate = $options[$number]['animate'];
}
?>
