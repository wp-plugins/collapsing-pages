    <?php
$style="#sidebar span.collapsPage {
        border:0;
        padding:0; 
        margin:0; 
        cursor:pointer;
} 

#sidebar li.widget_collapspage h2 span.sym {float:right;padding:0 .5em}
#sidebar li.collapsPage a.self {font-weight:bold}
#sidebar ul.collapsPageList ul.collapsPageList:before {content:'';} 
#sidebar ul.collapsPageList li.collapsPage:before {content:'';} 
#sidebar ul.collapsPageList li.collapsPage {list-style-type:none}
#sidebar ul.collapsPageList li.collapsItem {
       margin:0 0 0 2em;}
#sidebar ul.collapsPageList li.collapsItem:before {content: '\\\\00BB \\\\00A0' !important;} 
#sidebar ul.collapsPageList li.collapsPage .sym {
   font-size:1.2em;
   font-family:Monaco, 'Andale Mono', 'FreeMono', 'Courier new', 'Courier', monospace;
    padding-right:5px;}";

$default=$style;

$block="#sidebar ul.collapsPageList li a {
            display:block;
            text-decoration:none;
            margin:0;
            padding:0;
            }
#sidebar ul.collapsPageList li a:hover {
            background:#CCC;
            text-decoration:none;
          }
#sidebar span.collapsPage {
        border:0;
        padding:0; 
        margin:0; 
        cursor:pointer;
}

#sidebar li.widget_collapspage h2 span.sym {float:right;padding:0 .5em}
#sidebar li.collapsPage a.self {background:#CCC;
                       font-weight:bold}
#sidebar ul.collapsPageList ul.collapsPageList:before {content:'';} 
#sidebar ul.collapsPageList li.collapsPage {list-style-type:none}
#sidebar ul.collapsPageList li.collapsItem:before, 
  #sidebar ul.collapsPageList li.collapsPage:before {
       content:'';
  } 
#sidebar ul.collapsPageList li.collapsPage .sym {
   font-size:1.2em;
   font-family:Monaco, 'Andale Mono', 'FreeMono', 'Courier new', 'Courier', monospace;
    float:left;
    padding-right:5px;
}
";

$noArrows="#sidebar span.collapsPage {
        border:0;
        padding:0; 
        margin:0; 
        cursor:pointer;
}
#sidebar li.collapsPage a.self {font-weight:bold}

#sidebar li.widget_collapspage h2 span.sym {float:right;padding:0 .5em}
#sidebar ul.collapsPageList ul.collapsPageList:before {content:'';} 
#sidebar ul.collapsPageList li.collapsPage:before {content:'';} 
#sidebar ul.collapsPageList li.collapsPage {list-style-type:none}
#sidebar ul.collapsPageList li.collapsPage .sym {
   font-size:1.2em;
   font-family:Monaco, 'Andale Mono', 'FreeMono', 'Courier new', 'Courier', monospace;
    padding-right:5px;}";
$selected='default';
$custom=get_option('collapsPageStyle');
?>
