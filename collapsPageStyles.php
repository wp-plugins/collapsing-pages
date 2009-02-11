    <?php
$style="span.collapsPage {
        border:0;
        padding:0; 
        margin:0; 
        cursor:pointer;
}
li.collapsPage a.self {font-weight:bold}
ul.collapsPageList ul.collapsPageList:before {content:'';} 
ul.collapsPageList li.collapsPage:before {content:'';} 
ul.collapsPageList li.collapsPage {list-style-type:none}
ul.collapsPageList li.collapsItem {
       margin:0 0 0 2em;}
ul.collapsPageList li.collapsItem:before {content: '\\\\00BB \\\\00A0' !important;} 
ul.collapsPageList li.collapsPage .sym {
   font-size:1.2em;
   font-family:Monaco, 'Andale Mono', 'FreeMono', 'Courier new', 'Courier', monospace;
    padding-right:5px;}";

$default=$style;

$block="li.collapsPage a {
            display:block;
            text-decoration:none;
            margin:0;
            padding:0;
            }
li.collapsPage a:hover {
            background:#CCC;
            text-decoration:none;
          }
span.collapsPage {
        border:0;
        padding:0; 
        margin:0; 
        cursor:pointer;
}
li.collapsPage a.self {font-weight:bold}
ul.collapsPageList ul.collapsPageList:before {content:'';} 
ul.collapsPageList li.collapsPage:before {content:'';} 
ul.collapsPageList li.collapsPage {list-style-type:none}
ul.collapsPageList li.collapsItem {
      }
ul.collapsPageList li.collapsPage .sym {
   font-size:1.2em;
   font-family:Monaco, 'Andale Mono', 'FreeMono', 'Courier new', 'Courier', monospace;
    float:left;
    padding-right:5px;
}
";

$noArrows="span.collapsPage {
        border:0;
        padding:0; 
        margin:0; 
        cursor:pointer;
}
li.collapsPage a.self {font-weight:bold}
ul.collapsPageList ul.collapsPageList:before {content:'';} 
ul.collapsPageList li.collapsPage:before {content:'';} 
ul.collapsPageList li.collapsPage {list-style-type:none}
ul.collapsPageList li.collapsPage .sym {
   font-size:1.2em;
   font-family:Monaco, 'Andale Mono', 'FreeMono', 'Courier new', 'Courier', monospace;
    padding-right:5px;}";
$selected='default';
$custom=get_option('collapsPageStyle');
?>
