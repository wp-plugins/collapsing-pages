<?php 
class collapsPageWidget extends WP_Widget {
  function collapsPageWidget() {
    $widget_ops = array('classname' => 'widget_collapspage', 'description' =>
    'Collapsible page listing' );
		$control_ops = array (
			'width' => '400', 
			'height' => '400'
			);
    $this->WP_Widget('collapspage', 'Collapsing Pages', $widget_ops,
    $control_ops);
  }
 
  function widget($args, $instance) {
    extract($args, EXTR_SKIP);
    $thetitle = empty($instance['title']) ? '&nbsp;' : apply_filters('widget_title', $instance['title']);
    $expandWidget=$instance['expandWidget'];
    if ($expandWidget) {
      $animate=$instance['animate'];
      $expand=$instance['expand'];
      include('symbols.php'); 
      $title ="<span  class='collapsPage collapse'" . 
          "onclick='expandCollapse(event, \"$expandSymJS\", \"$collapseSymJS\", $animate, ".
          "\"collapsPage\"); return false'>" .
          "<span class='sym'>$collapseSym</span>".
      $thetitle . "</span>"; 
    } else {
      $title=$thetitle;
    }
        
    echo $before_widget . $before_title . $title . $after_title;
       if( function_exists('collapsPage') ) {
        collapsPage($instance);
       } else {
        echo "<ul>\n";
        wp_list_pages();
        echo "</ul>\n";
       }

    echo $after_widget;
  }
 
  function update($new_instance, $old_instance) {
    $instance = $old_instance;
    include('updateOptions.php');
    return $instance;
  }
 
  function form($instance) {
  include('defaults.php');
  $options=wp_parse_args($instance, $defaults);
  extract($options);
?>
      <p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input  id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
<?php
    include('collapsPageOptions.php');
?>
  <p>Style can be set from the <a
  href='options-general.php?page=collapsPage.php'>options page</a></p>
<?php
  }
}
function registerCollapsPageWidget() {
  register_widget('collapsPageWidget');
}
	add_action('widgets_init', 'registerCollapsPageWidget');
