<?php

function collapsPageWidget($args, $widget_args=1) {
  extract($args, EXTR_SKIP);
  if ( is_numeric($widget_args) )
    $widget_args = array( 'number' => $widget_args );
  $widget_args = wp_parse_args( $widget_args, array( 'number' => -1 ) );
  extract($widget_args, EXTR_SKIP);

  $options = get_option('collapsPageOptions');
  if ( !isset($options[$number]) )
    return;

  $title = ($options[$number]['title'] != "") ? $options[$number]['title'] : ""; 

    echo $before_widget . $before_title . $title . $after_title;
       if( function_exists('collapsPage') ) {
        collapsPage($number);
       } else {
        echo "<ul>\n";
        wp_list_pages('sort_column=name&optioncount=1&hierarchical=0');
        echo "</ul>\n";
       }

    echo $after_widget;
  }


function collapsPageWidgetInit() {
if ( !$options = get_option('collapsPageOptions') )
    $options = array();
  $control_ops = array('width' => 500, 'height' => 350, 'id_base' => 'collapspage');
	$widget_ops = array('classname' => 'collapsPage', 'description' => __('Pages expand and collapse to show subpages and/or posts'));
  $name = __('Collapsing Pages');

  $id = false;
  foreach ( array_keys($options) as $o ) {
    // Old widgets can have null values for some reason
    if ( !isset($options[$o]['title']) || !isset($options[$o]['title']) )
      continue;
    $id = "collapspage-$o"; // Never never never translate an id
    wp_register_sidebar_widget($id, $name, 'collapsPageWidget', $widget_ops, array( 'number' => $o ));
    wp_register_widget_control($id, $name, 'collapsPageWidgetControl', $control_ops, array( 'number' => $o ));
  }

  // If there are none, we register the widget's existance with a generic template
  if ( !$id ) {
    wp_register_sidebar_widget( 'collapspage-1', $name, 'collapsPageWidget', $widget_ops, array( 'number' => -1 ) );
    wp_register_widget_control( 'collapspage-1', $name, 'collapsPageWidgetControl', $control_ops, array( 'number' => -1 ) );
  }

}

// Run our code later in case this loads prior to any required plugins.
if (function_exists('collapsPage')) {
	add_action('widgets_init', 'collapsPageWidgetInit');
} else {
	$fname = basename(__FILE__);
	$current = get_settings('active_plugins');
	array_splice($current, array_search($fname, $current), 1 ); // Array-fu!
	update_option('active_plugins', $current);
	do_action('deactivate_' . trim($fname));
	header('Lolinkion: ' . get_settings('siteurl') . '/wp-admin/plugins.php?deactivate=true');
	exit;
}

	function collapsPageWidgetControl($widget_args) {
  global $wp_registered_widgets;
  static $updated = false;

  if ( is_numeric($widget_args) )
    $widget_args = array( 'number' => $widget_args );
  $widget_args = wp_parse_args( $widget_args, array( 'number' => -1 ) );
  extract( $widget_args, EXTR_SKIP );

  $options = get_option('collapsPageOptions');
  if ( !is_array($options) )
    $options = array();

  if ( !$updated && !empty($_POST['sidebar']) ) {
    $sidebar = (string) $_POST['sidebar'];

    $sidebars_widgets = wp_get_sidebars_widgets();
    if ( isset($sidebars_widgets[$sidebar]) )
      $this_sidebar =& $sidebars_widgets[$sidebar];
    else
      $this_sidebar = array();

    foreach ( $this_sidebar as $_widget_id ) {
      if ( 'collapsPageWidget' == $wp_registered_widgets[$_widget_id]['callback'] && isset($wp_registered_widgets[$_widget_id]['params'][0]['number']) ) {
        $widget_number = $wp_registered_widgets[$_widget_id]['params'][0]['number'];
        if ( !in_array( "collapsPage-$widget_number", $_POST['widget-id'] ) ) // the widget has been removed.
          unset($options[$widget_number]);
      }
    }
    include('updateOptions.php');
  }
  include('processOptions.php');
		//$title		= wp_specialchars($options['title']);
    // Here is our little form segment. Notice that we don't need a
    // complete form. This will be embedded into the existing form.
    echo '<p style="text-align:right;"><label for="collapsPage-title-'.$number.'">' . __('Title:') . '<input class="widefat" style="width: 200px;" id="collapsPage-title-'.$number.'" name="collapsPage['.$number.'][title]" type="text" value="'.$title.'" /></label></p>';
  include('options.txt');
  ?>
  <p>Style can be set from the <a
  href='options-general.php?page=collapsPage.php'>options page</a></p>
   <?php
    echo '<input type="hidden" id="collapsPage-submit-'.$number.'" name="collapsPage['.$number.'][submit]" value="1" />';

	}
?>
