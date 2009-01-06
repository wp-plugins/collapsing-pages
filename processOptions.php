<?php
if ( -1 == $number ) {
  /* default options go here */
  $number = '%i%';
  $title = 'Pages';
  $showPostCount = 'yes';
  $sortOrder = 'ASC';
  $sort='pageName';
  $defaultExpand='';
  $expand='1';
  $depth='-1';
  $inExcludePage='include';
  $inExcludePages='';
  $showPosts='yes';
  $showPages='no';
  $animate=1;
  $debug=0;
} else {
  $title = attribute_escape($options[$number]['title']);
  $showPostCount = $options[$number]['showPostCount'];
  $expand = $options[$number]['expand'];
  $depth = $options[$number]['depth'];
  $sort = $options[$number]['sort'];
  $sortOrder = $options[$number]['sortOrder'];
  $inExcludePages = $options[$number]['inExcludePages'];
  $inExcludePage = $options[$number]['inExcludePage'];
  $defaultExpand = $options[$number]['defaultExpand'];
  $showPosts = $options[$number]['showPosts'];
  $showPages = $options[$number]['showPages'];
  $animate = $options[$number]['animate'];
  $debug = $options[$number]['debug'];
}
?>
