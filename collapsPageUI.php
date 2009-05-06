<?php
/*
Collapsing Pages version: 0.4.3
Copyright 2007 Robert Felty

This work is largely based on the Fancy Pages plugin by Andrew Rader
(http://nymb.us), which was also distributed under the GPLv2. I have tried
contacting him, but his website has been down for quite some time now. See the
CHANGELOG file for more information.

This file is part of Collapsing Pages

    Collapsing Pages is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    Collapsing Pages is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Collapsing Pages; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

check_admin_referer();

$number = '%i%';
$widgetOn=0;
$options=get_option('collapsPageOptions');
/*
echo "<pre>\n";
print_r($options);
echo "</pre>\n";
*/
if (empty($options)) {
  $number = -1;
} elseif (!isset($options['%i%']['title']) || 
    count($options) > 1) {
  $widgetOn=1; 
}
if( isset($_POST['resetOptions']) ) {
  echo "resetting";
  if (isset($_POST['reset'])) {
    delete_option('collapsPageOptions');   
		$widgetOn=0;
  }
} elseif( isset($_POST['infoUpdate']) ) {
  $style=$_POST['collapsPageStyle'];
	$defaultStyles=get_option('collapsPageDefaultStyles');
	$selectedStyle=$_POST['collapsPageSelectedStyle'];
	$defaultStyles['selected']=$selectedStyle;
	$defaultStyles['custom']=$_POST['collapsPageStyle'];
  update_option('collapsPageStyle', $style);
  update_option('collapsPageSidebarId', $_POST['collapsPageSidebarId']);
  update_option('collapsPageDefaultStyles', $defaultStyles);
  if ($widgetOn==0) {
    include('updateOptions.php');
  }
  $options=get_option('collapsPageOptions');
}
include('processOptions.php');
?>
<div class=wrap>
 <form method="post">
  <h2><?php _e('Collapsing Pages Options', 'collapsing-pages'); ?></h2>
  <fieldset name="<?php _e('Collapsing Pages Options', 'collapsing-pages'); ?>">
   <legend><?php _e('Display Options:','collapsing-pages'); ?></legend>
   <ul style="list-style-type: none;">
   <?php
   if ($widgetOn==1) {
     echo "
    <div style='width:60em; background:#FFF; color:#444;border: 1px solid
    #444;padding:0 1em'>
    <p>" . __('If you wish to use the collapsing categories plugin as a widget, you
    should set the options in the widget page (except for custom styling,
    which is set here). If you would like to use it manually (that is, you
    modify your theme), then click below to delete the current widget options.','collapsing-pages') .
    "</p>
    <form method='post'>
    <p>
       <input type='hidden' name='reset' value='true' />
       <input type='submit' name='resetOptions' value='" . __('reset options','collapsing-pages') . "' />
       </p>
    </form>
    </div>
    ";
    } else {
      include('collapsPageOptions.php'); 
    }
   ?>
	 <?php _e('Id of the sidebar where collapsing pages appears:', 'collapsing-pages'); ?> 
	 <input id='collapsPageSidebarId' name='collapsPageSidebarId' type='text' size='20' value="<?php echo
	 get_option('collapsPageSidebarId')?>" onchange='changeStyle();' />
	 <table>
	   <tr>
		   <td>
  <input type='hidden' id='collapsPageCurrentStyle' value="<?php echo
stripslashes(get_option('collapsPageStyle')) ?>" />
  <input type='hidden' id='collapsPageSelectedStyle'
	name='collapsPageSelectedStyle' />
<label for="collapsPageStyle"><?php _e('Select style:', 'collapsing-pages'); ?> </label>
			 </td>
			 <td>
			 <select name='collapsPageDefaultStyles' id='collapsPageDefaultStyles' 
			   onchange='changeStyle();' >
			 <?php
		$url = get_settings('siteurl') . '/wp-content/plugins/collapsing-pages';
			 $styleOptions=get_option('collapsPageDefaultStyles');
			 //print_r($styleOptions);
			 $selected=$styleOptions['selected'];
			 foreach ($styleOptions as $key=>$value) {
			   if ($key!='selected') {
           if ($key==$selected) {
					   $select=' selected=selected ';
					 } else {
						 $select=' ';
					 }
					 echo '<option' .  $select . 'value="'.
					     stripslashes($value) . '" >'.$key . '</option>';
         }
       }
			 ?>
			 </select>
	     </td>
			 <td><?php _e('Preview', 'collapsing-pages'); ?><br />
			 <img style='border:1px solid' id='collapsPageStylePreview' alt='preview' />
			 </td>
		</tr>
		</table>
		<?php _e('You may also customize your style below if you wish', 'collapsing-pages'); ?><br />
   <input type='button' value='<?php _e("restore current style", "collapsing-pages"); ?>'
onclick='restoreStyle();' /><br />
   <textarea onfocus='customStyle();' cols='78' rows='10' id="collapsPageStyle" name="collapsPageStyle"><?php echo stripslashes(get_option('collapsPageStyle')) ?></textarea>
    </p>
<script type='text/javascript'>
function changeStyle() {
	var preview = document.getElementById('collapsPageStylePreview');
	var pageStyles = document.getElementById('collapsPageDefaultStyles');
	var selectedStyle;
	var hiddenStyle=document.getElementById('collapsPageSelectedStyle');
	for(i=0; i<pageStyles.options.length; i++) {
		if (pageStyles.options[i].selected == true) {
			selectedStyle=pageStyles.options[i];
		}
	}
	hiddenStyle.value=selectedStyle.innerHTML
	preview.src='<?php echo $url ?>/img/'+selectedStyle.innerHTML+'.png';
  var pageStyle = document.getElementById('collapsPageStyle');
	// add in the name of the sidebar
  var sidebarId=document.getElementById('collapsPageSidebarId').value;
	var theStyle='#' + sidebarId +
			' ul.collapsPageList li:before {content: \'\'}\n' + selectedStyle.value;
  pageStyle.value=theStyle;
}
function restoreStyle() {
  var defaultStyle = document.getElementById('collapsPageCurrentStyle').value;
  var pageStyle = document.getElementById('collapsPageStyle');
  pageStyle.value=defaultStyle;
}
function customStyle() {
	var hiddenStyle=document.getElementById('collapsPageSelectedStyle');
	hiddenStyle.value='custom';
}
	changeStyle();
</script>
   </ul>
  </fieldset>
  <div class="submit">
   <input type="submit" name="infoUpdate" value="<?php _e('Update options', 'collapsing-pages'); ?> &raquo;" />
  </div>
 </form>
</div>
