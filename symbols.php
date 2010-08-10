  <?php
  if ($expand==1) {
    $expandSym='+';
    $collapseSym='&mdash;';
  } elseif ($expand==2) {
    $expandSym='[+]';
    $collapseSym='[&mdash;]';
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
    $expandSym='&#9658;';
    $collapseSym='&#9660;';
  }
  if ($expand==3) {
    $expandSymJS='expandImg';
    $collapseSymJS='collapseImg';
  } else {
    $expandSymJS=$expandSym;
    $collapseSymJS=$collapseSym;
  }
?>
