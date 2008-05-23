<?php

function collapsPageWidget($args) {
  extract($args);
  $options = get_option('collapsPageWidget');
  $title = ($options['title'] != "") ? $options['title'] : ""; 

  //$title = $options['title'];

    echo $before_widget . $before_title . $title . $after_title;
    
       if( function_exists('collapsPage') ) {
        collapsPage();
       } else {
        echo "<ul>\n";
        wp_list_pages('sort_column=name&optioncount=1&hierarchical=0');
        echo "</ul>\n";
       }

    echo $after_widget;
  }


function collapsPageWidgetInit() {
	$widget_ops = array('classname' => 'collapsPageWidget', 'description' => __('Pages expand and collapse to show subpages and/or posts'));
	if (function_exists('register_sidebar_widget')) {
    register_sidebar_widget('Collapsing Pages', 'collapsPageWidget');
    register_widget_control('Collapsing Pages', 'collapsPageWidgetControl','300px');
	}
}

// Run our code later in case this loads prior to any required plugins.
if (function_exists('collapsPage')) {
	add_action('plugins_loaded', 'collapsPageWidgetInit');
} else {
	$fname = basename(__FILE__);
	$current = get_settings('active_plugins');
	array_splice($current, array_search($fname, $current), 1 ); // Array-fu!
	update_option('active_plugins', $current);
	do_action('deactivate_' . trim($fname));
	header('Lopageion: ' . get_settings('siteurl') . '/wp-admin/plugins.php?deactivate=true');
	exit;
}

	function collapsPageWidgetControl() {
		$options = get_option('collapsPageWidget');
    if ( !is_array($options) ) {
      $options = array('title'=>'Pages'
      );
     }

		if ( $_POST['collapsPage-submit'] ) {
			$options['title']	= strip_tags(stripslashes($_POST['collapsPage-title']));
			include('updateOptions.php');
    //print($_POST['collapsPage-title']);
    //print($_POST['archives']);
    //foreach ($_POST as $key=>$value) {
      //echo "key = $key\n";
      //echo "<script type='text/javascript'>alert('value = $value')</script>\n";
    //}
		}
    update_option('collapsPageWidget', $options);
		$title		= wp_specialchars($options['title']);
    // Here is our little form segment. Notice that we don't need a
    // complete form. This will be embedded into the existing form.
    echo '<p style="text-align:right;"><label for="collapsPage-title">' . __('Title:') . '<input class="widefat" style="width: 200px;" id="collapsPage-title" name="collapsPage-title" type="text" value="'.$title.'" /></label></p>';
  echo "<ul style='list-style-type:none;width:300px;margin:0;padding:0;'>";
    include('options.txt');
  echo "</ul>\n";
   ?>
   <?php
    echo '<input type="hidden" id="collapsPage-submit" name="collapsPage-submit" value="1" />';

	}
?>
