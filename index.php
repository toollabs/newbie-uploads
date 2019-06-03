<?php
/**
 * @author Steinsplitter / https://commons.wikimedia.org/wiki/User:Steinsplitter
 * @copyright 2015 tool authors
 * @license http://unlicense.org/ Unlicense
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
        <meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
        <title>Newbie uploads</title>
        <link rel="stylesheet" href="//tools-static.wmflabs.org/cdnjs/ajax/libs/twitter-bootstrap/2.3.2/css/bootstrap.min.css">
        <script src="//tools-static.wmflabs.org/tooltranslate/tt.js"></script>
        <script src="//tools-static.wmflabs.org/cdnjs/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <style>
      body {
        padding-top: 62px;
      }
    </style>
<script language='javascript' type='text/javascript'>
     $(window).load(function() {
      $('#loooaaad').hide();
  });
</script>
</head>
<body>

    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="brand" href="index.php"><span tt="nu">Newbie uploads</span></a>
          <div class="nav-collapse collapse">
            <div class="navbar-form pull-right">
               <span class = "i18ntools"><span id='tooltranslate_wrapper'></span></span>
                <a href="index.php?files=0&editcount=1&about=true"><span tt="about">About</span></a>
            </div>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

  <div class="container">
<div id ="loooaaad"><div class="hero-unit"><img src="https://upload.wikimedia.org/wikipedia/commons/d/de/Ajax-loader.gif"></img> <span tt="lc">Loading content...</span></div><br></div>
<?php
// i18n
require_once ( "/data/project/tooltranslate/public_html/tt.php") ;
$tt = new ToolTranslation ( array ( 'tool' => 'newbie_uploads' , 'language' => 'en' , 'fallback' => 'en' , 'highlight_missing' => false ) ) ;
print $tt->getJS('#tooltranslate_wrapper') ;
print $tt->getJS() ;
// Logging access
$hi = ( "new.txt" );
$hii = file( $hi );
$hii[0] ++;
$fp = fopen( $hi , "w" );
fputs( $fp , "$hii[0]" );
fclose( $fp );

// Init
if ( count( $_GET['files'] ) ) {
   $dget = $_GET['files'];
} else {
   $dget = $_GET['files'] = 30;
}

if ( count( $_GET['editcount'] ) ) {
   $dget = $_GET['editcount'];
} else {
   $dget = $_GET['editcount'] = 3000;
}


$edget = $_GET['editcount'];

// Checking file parameter

if ( is_numeric( $dget ) ) {
    $uget = $_GET['files'];
    $num = preg_replace( "/[^0-9]/", "", $uget );
} else {
     $num = "???";
}

// Checking editcount parameter

if ( is_numeric( $edget ) ) {
    $euget = $_GET['editcount'];
    $enum = preg_replace( "/[^0-9]/", "", $euget );
} else {
    $enum = "???";
}

echo "<p tt=\"intro\">Recent $num uploads by users not in <a href=\"//commons.wikimedia.org/wiki/Special:ListGroupRights\">local usergroups</a> (Example: autopatroller, bot) and less than $enum edits.";
echo <<<EOD
<br>
<div class="well form-submit">
<form action="index.php">
<label for="files"><b><p tt="files">Files:</p></b></label><select id="files" name="files">
<option value="$num" selected="">$num</option>
<option value="60">60</option>
<option value="120">120</option>
<option value="300">300</option>
<option value="800">800</option>
<option value="1200">1200</option>
<option value="2000">2000</option>
</select>
<label for="editcount"><b><p tt="let">Less edits than:</p></b></label><select id="editcount" name="editcount">
<option value="$enum" selected="">$enum</option>
<option value="1">1</option>
<option value="5">5</option>
<option value="60">60</option>
<option value="100">100</option>
<option value="200">200</option>
<option value="500">500</option>
<option value="1500">1500</option>
<option value="3000">3000</option>
<option value="5000">5000</option>
</select>
<label for="filter"><b><p tt="filter">Filter:</p></b></label><select id="filter" name="filter">
<option value="0" selected="" > </option>
<option value="1" tt= "hp">hide patrolled</option>
<option value="2" tt= "hnp">hide non-patrolled</option>
<option value="3" tt= "webm">only .webm</option>
<option value="5" tt= "svg">only .svg</option>
<option value="4" tt= "logos">logos only</option>
</select>
<br>
<input class ="btn btn-primary btn-success" type="submit" tt="go" value="Go" /></td></tr></table>
</form>
</div>
EOD;

// Checking file parameter
$dget = $_GET['files'];

if ( is_numeric( $dget ) ) {
    $uget = $_GET['files'];
    $num = preg_replace( "/[^0-9]/", "", $uget );
} else {
     $num = "0";
     echo "<div class=\"alert alert-error\">ERROR: <code>files</code> paramter must be numerical.</div>";
}

if ( $num < 3000 ) {
     $qer = $num;
} else {
     echo "<div class=\"alert alert-error\"><b>Limit exceeded:</b> You can request maximal 3000 files.</div>";
     $qer = "0";
}

// EDITCOUNT

$edget = $_GET['editcount'];

if ( is_numeric( $edget ) ) {
    $euget = $_GET['editcount'];
    $enum = preg_replace( "/[^0-9]/", "", $euget );
} else {
    echo "<div class=\"alert alert-error\">ERROR: <code>editcount</code> parameter must be numerical.</div>";
     $enum = "0";
     die( "</html>" );
}

if ( $enum < 333000 ) {
     $eqer = $enum;
} else {
     echo "<div class=\"alert alert-error\"><b>Limit exceeded:</b> Unlikely that a new user has +333000 edits.</div>";
     $qer = "0";
}

if($_GET["filter"] == "1") {
$isp = "AND rc_patrolled = \"0\"";
}
elseif($_GET["filter"] == "2") {
$isp = "AND rc_patrolled = \"1\"";
}
elseif($_GET["filter"] == "3") {
$isp = "AND rc_title LIKE \"%.webm\"";
}
elseif($_GET["filter"] == "4") {
$isp = "AND rc_title LIKE \"%logo%\"";
}
elseif($_GET["filter"] == "5") {
$isp = "AND rc_title LIKE \".svg%\"";
}
else {
$isp = "";
}

$tools_pw = posix_getpwuid ( posix_getuid () );
$tools_mycnf = parse_ini_file( $tools_pw['dir'] . "/replica.my.cnf" );
$db = new mysqli( 'commonswiki.labsdb', $tools_mycnf['user'], $tools_mycnf['password'], 'commonswiki_p' );
if ( $db->connect_errno )
        die( "<div tt= \"dberror\">Failed to connect to labsdb:</div> (" . $db->connect_errno . ") " . $db->connect_error );
$r = $db->query( 'SELECT DATE_FORMAT(rc_timestamp, "%b %d %Y %h:%i %p") AS timestamp,
rc_title AS file,
actor_name as user,
user_editcount as editcount,
rc_log_action,
rc_patrolled
FROM recentchanges
LEFT JOIN user_groups ON rc_user=ug_user
INNER JOIN actor ON rc_actor = actor_id
INNER JOIN user ON actor_user=user_id
WHERE ug_group IS NULL ' . $isp . '
AND rc_log_type = "upload"
AND user_editcount < "' . $eqer . '"
ORDER BY rc_timestamp DESC
LIMIT ' . $qer . ';' );
unset( $tools_mycnf, $tools_pw );
?>
<table class="table table-hover">
<?php while ( $row = $r->fetch_row() ):
$word =  str_replace( "overwrite", "<span tt=\"filesover\">overwritten</span>", htmlspecialchars( $row[4] ) );
$word2 =  str_replace( "upload", "<span tt=\"filesup\">uploaded</span>", $word );
if ($row[5] == "0") {
   $pt = "<span tt=\"unpatrolled\"><abbr title=\"This upload has not yet been patrolled\">!</abbr></span>";
} else {
   $pt = "";
}
?>
<tr><td>
<p><img class="decoded" onerror="this.style.display = 'none'" src="//commons.wikimedia.org/w/thumb.php?f=<?= htmlspecialchars( urlencode ( $row[1] ) ) ?>&amp;w=80&amp;p=40"></p></td> <td>
<p><?= $pt ?> <a href="//commons.wikimedia.org/wiki/File:<?= htmlspecialchars ( urlencode ( $row[1] ) ) ?>">File:<?= str_replace( "_", " ", htmlspecialchars( $row[1] ) ); ?></a> <?= $word2; ?> <span tt="by">by</span> <a href="//commons.wikimedia.org/wiki/User:<?= htmlspecialchars( $row[2] ) ?>"><?= htmlspecialchars( $row[2] ) ?></a> (<span tt="editcount">Editcount:</span> <?= htmlspecialchars( $row[3] ) ?>) <span tt="at">at</span> <?= htmlspecialchars( $row[0] ) ?>.</p>
</td></tr>
<?php endwhile; ?>
</table>
<?php
if ( isset( $_GET['about'] ) ) {
echo "<b><span tt=\"about\">About:</span></b> <div tt=\"about2\">This tool is intended to help users find newbie uploads. A lot of newbies are not familiar with Commons' policies and therefore sometimes upload copyvios and other content violating Commons' policies. (Special:NewFiles does not allow such filtering.)</div><br>";
echo "<b><span tt=\"klicks\">Klicks:</span></b> ";
include( "new.txt" );
echo " <span tt=\"snc\">since Juli 2015.</span><br>";
echo "<b><span tt=\"version\">Version:</span></b> <span class=\"badge badge-success\">2.5</span><br>";
echo "<b><span tt=\"source\">Source:</span></b> <a href=\"https://github.com/Toollabs/newbie-uploads/\">GitHub</a>";
}
?>
</div>
</div>
</body>
</html>
