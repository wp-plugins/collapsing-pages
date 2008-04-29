   <ul style="list-style-type: none;">
    <li>
     <input type="checkbox" name="showPostCount" <?php if(get_option('collapsPageShowPostCount')=='yes') echo 'checked'; ?> id="showPostCount"></input> <label for="showPostCount">Show Post Count in Pageegory Links</label>
    </li>
    <li>
     <input type="checkbox" name="showPages" <?php if(get_option('collapsPageShowPages')=='yes') echo 'checked'; ?> id="showPages"></input> <label for="showPages">Show Pages as well as posts</label>
    </li>
    <li>
     <input type="radio" name="archives" <?php if(get_option('collapsPageLinkToArchives')=='root') echo 'checked'; ?> id="archivesRoot" value='root'></input> <label for="archivesRoot">Links based on site root (default)</label>
     <input type="radio" name="archives" <?php if(get_option('collapsPageLinkToArchives')=='index') echo 'checked'; ?> id="archivesIndex" value='index'></input> <label for="archivesIndex">Links based on index.php </label>
     <input type="radio" name="archives" <?php if(get_option('collapsPageLinkToArchives')=='archives') echo 'checked'; ?> id="archivesArchives" value='archives'></input> <label for="archivesArchives">Links based on archives.php</label>
    </li>
    <li>
     <input type="radio" name="sort" <?php if(get_option('collapsPageSort')=='pageName') echo 'checked'; ?> id="sortPageName" value='pageName'></input> <label for="sortPageName">Sort by page name</label>
     <input type="radio" name="sort" <?php if(get_option('collapsPageSort')=='pageId') echo 'checked'; ?> id="sortPageId" value='pageId'></input> <label for="sortPageId">Sort by page id</label>
    </li>
    <li>
     <input type="radio" name="sortOrder" <?php if(get_option('collapsPageSortOrder')=='ASC') echo 'checked'; ?> id="sortASC" value='ASC'></input> <label for="sortASC">Sort in ascending order</label>
     <input type="radio" name="sortOrder" <?php if(get_option('collapsPageSortOrder')=='DESC') echo 'checked'; ?> id="sortDESC" value='DESC'></input> <label for="sortDESC">Sort in descending order</label>
    </li>
    <li>
     <input type="radio" name="showPosts" <?php if(get_option('collapsPageShowPosts')=='yes') echo 'checked'; ?> id="showPostsYes" value='yes'></input> <label for="showPostsYes">Expanding shows posts</label>
     <input type="radio" name="showPosts" <?php if(get_option('collapsPageShowPosts')=='no') echo 'checked'; ?> id="showPostsNo" value='no'></input> <label for="showPostsNO">Expanding only shows subpages</label>
    </li>
   </ul>
