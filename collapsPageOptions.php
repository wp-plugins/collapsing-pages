    <p>
     <input type="checkbox" name="collapsPage[<?php echo $number ?>][includePosts]" <?php if($includePosts=='yes') echo 'checked'; ?> id="collapsPage-includePosts-<?php echo $number ?>"></input> <label for="showPosts"><?php _e('Show posts as well as pages', 'collapsing-pages');?></label>
   &nbsp;&nbsp;
   <input type="checkbox" name="collapsPage[<?php echo $number
   ?>][animate]" <?php if ($animate==1) echo
   'checked'; ?> id="animate-<?php echo $number ?>"></input> <label
   for="animate"><?php _e('Animate collapsing and expanding', 'collapsing-pages');?></label>
   </p>
    <p><?php _e('Sort by:', 'collapsing-pages');?>&nbsp;&nbsp;
     <input type="radio" name="collapsPage[<?php echo $number ?>][sort]" <?php if($sort=='pageName') echo 'checked'; ?> id="collapsPage-sortPageName-<?php echo $number ?>" value='pageName'></input> <label for="sortPageName"><?php _e('Page name', 'collapsing-pages');?></label>
     <input type="radio" name="collapsPage[<?php echo $number ?>][sort]" <?php if($sort=='pageId') echo 'checked'; ?> id="collapsPage-sortPageId-<?php echo $number ?>" value='pageId'></input> <label for="sortPageId"><?php _e('Page id', 'collapsing-pages');?></label>
     <input type="radio" name="collapsPage[<?php echo $number ?>][sort]" <?php if($sort=='pageSlug') echo 'checked'; ?> id="collapsPage-sortPageSlug-<?php echo $number ?>" value='pageSlug'></input> <label for="sortPageSlug"><?php _e('Page Slug', 'collapsing-pages');?></label>
     <input type="radio" name="collapsPage[<?php echo $number ?>][sort]" <?php if($sort=='menuOrder') echo 'checked'; ?> id="collapsPage-sortMenuOrder-<?php echo $number ?>" value='menuOrder'></input> <label for="sortMenuOrder"><?php _e('Menu Order', 'collapsing-pages');?></label>
    </p>
    <p><?php _e('Sort order:', 'collapsing-pages');?>&nbsp;&nbsp
     <input type="radio" name="collapsPage[<?php echo $number ?>][sortOrder]" <?php if($sortOrder=='ASC') echo 'checked'; ?> id="collapsPage-sortASC-<?php echo $number ?>" value='ASC'></input> <label for="sortASC"><?php _e('Ascending', 'collapsing-pages');?></label>
     <input type="radio" name="collapsPage[<?php echo $number ?>][sortOrder]" <?php if($sortOrder=='DESC') echo 'checked'; ?> id="collapsPage-sortDESC-<?php echo $number ?>" value='DESC'></input> <label for="sortDESC"><?php _e('Descending', 'collapsing-pages');?></label>
    </p>
    <p><?php _e('Expanding and collapse characters:', 'collapsing-pages');?><br />
     html: <input type="radio" name="collapsPage[<?php echo $number ?>][expand]" <?php if($expand==0) echo 'checked'; ?> id="expand0" value='0'></input> <label for="expand0">&#9658;&nbsp;&#9660;</label>
     <input type="radio" name="collapsPage[<?php echo $number ?>][expand]" <?php if($expand==1) echo 'checked'; ?> id="expand1" value='1'></input> <label for="expand1">+&nbsp;&mdash;</label>
     <input type="radio" name="collapsPage[<?php echo $number ?>][expand]"
     <?php if($expand==2) echo 'checked'; ?> id="expand2" value='2'></input>
     <label for="expand2">[+]&nbsp;[&mdash;]</label>&nbsp;&nbsp;
     <?php _e('images:', 'collapsing-pages');?>
     <input type="radio" name="collapsPage[<?php echo $number ?>][expand]"
     <?php if($expand==3) echo 'checked'; ?> id="expand0" value='3'></input>
     <label for="expand3"><img src='<?php echo get_settings('siteurl') .
     "/wp-content/plugins/collapsing-pages/" ?>img/collapse.gif' />&nbsp;<img
     src='<?php echo get_settings('siteurl') .
     "/wp-content/plugins/collapsing-pages/" ?>img/expand.gif' /></label>
    </p>
    <p><?php _e('Include pages at this depth:', 'collapsing-pages');?>&nbsp;&nbsp;
     <select name="collapsPage[<?php echo $number ?>][depth]"  id="collapsPage-depth-<?php echo $number ?>">
        <option <?php if ($depth==-1) echo "selected='selected'" ?> value="-1"><?php _e('All levels (default)', 'collapsing-pages');?></option>
        <option <?php if ($depth==0) echo "selected='selected'" ?> value="0"><?php _e('Only main pages', 'collapsing-pages');?></option>
        <option <?php if ($depth==1) echo "selected='selected'" ?> value="1"><?php _e('Sub-pages', 'collapsing-pages');?></option>
        <option <?php if ($depth==2) echo "selected='selected'" ?> value="2"><?php _e('Sub-sub-pages', 'collapsing-pages');?></option>
        <option <?php if ($depth==3) echo "selected='selected'" ?>value="3"><?php _e('Sub-sub-sub-pages', 'collapsing-pages');?></option>
    </select> 
    </p>
    <p>
     <select name="collapsPage[<?php echo $number ?>][inExcludePage]">
     <option  <?php if($inExcludePage=='include') echo 'selected'; ?> id="inExcludePageInclude-<?php echo $number ?>" value='include'><?php _e('Include', 'collapsing-pages');?></option>
     <option  <?php if($inExcludePage=='exclude') echo 'selected'; ?> id="inExcludePageExclude-<?php echo $number ?>" value='exclude'><?php _e('Exclude', 'collapsing-pages');?></option>
     </select>
     <?php _e('these pages (input slug or ID separated by commas):', 'collapsing-pages');?><br />
    <input type="text" name="collapsPage[<?php echo $number
    ?>][inExcludePages]" value="<?php echo $inExcludePages ?>"  
    id="collapsPage-inExcludePages-<?php echo $number ?>"></input> 
    </p>
    <p><?php _e('Auto-expand these categories (input slug or ID separated by commas):', 'collapsing-pages');?><br />
     <input type="text" name="collapsPage[<?php echo $number ?>][defaultExpand]" value="<?php echo $defaultExpand ?>" id="collapsPage-defaultExpand-<?php echo $number ?>"></input> 
    </p>
    <p><?php _e('Clicking on page name:', 'collapsing-pages');?><br />
     <input type="radio" name="collapsPage[<?php echo $number ?>][linkToPage]"
     <?php if($linkToPage=='yes') echo 'checked'; ?>
     id="collapsPage-linkToPageYes-<?php echo $number ?>"
     value='yes'></input> <label for="collapsPage-linkToPageYes"><?php _e('Links to page', 'collapsing-pages');?></label>
     <input type="radio" name="collapsPage[<?php echo $number ?>][linkToPage]"
     <?php if($linkToPage=='no') echo 'checked'; ?>
     id="collapsPage-linkToPageNo-<?php echo $number ?>"
     value='no'></input> <label for="linkToPageNo"><?php _e('Expands to show
     sub-pages', 'collapsing-pages');?> </label>
    </p>
   <p>
    <p>
     <input type="checkbox" name="collapsPage[<?php echo $number ?>][debug]"
<?php if ($debug=='1')  echo 'checked'; ?> id="collapsPage-debug-<?php echo
$number ?>"></input> <label for="collapsPageDebug"><?php _e('Show debugging information
(shows up as a hidden pre right after the title)', 'collapsing-pages');?></label>
    </p>
