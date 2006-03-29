<?
//error_reporting(E_ALL);
//error_reporting(E_ALL ^ E_NOTICE);
ob_start();
// buffer everything till the end
// -------------------------------------------------------------------------------
// Main Index Page
// Type: internal
// Author: Herman Tolentino MD
// Description: this is level one script for GAME
//              everything starts from here!!!
//
// Version 1.1
// 0.9 nothing done
// 1.0 code reorganization
// 1.1 use web services
//
// TODO
// 1. template based layout using buffer and regular expression functions
// -------------------------------------------------------------------------------

// start session
session_start();

// expire page so no cookies will be stored
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Pragma: no-cache"); // HTTP/1.0

// standard class includes
define("GAME_DIR", '../');
define("GAME_DUMP_DIR", '../dump');
define("GAME_GRAPH_DIR", '../graph');
define("JPGRAPH_DIR", '/home/herman/Documents/Download/jpgraph/jpgraph-1.20.2/src/');
// very important setting for FPDF
define("FPDF_FONTPATH",'../fonts/');

// standard class includes
include GAME_DIR."class.mysqldb.php";
include GAME_DIR."class.user.php";
include GAME_DIR."class.site.php";
include GAME_DIR."class.module.php";
include GAME_DIR."class.datanode.php";
include GAME_DIR."class.gform.php";

// load PDF open source modules
// courtesy of http://www.fpdf.org/
include GAME_DIR."class.fpdf.php";
include GAME_DIR."class.pdf.php";
include GAME_DIR."class.xmlrpc.php"; // use web services

// load session variables
include GAME_DIR."initsession.php";

// initialize database connection
$db = new MySQLDB;
$conn = $db->connid();

// the following file is server-generated
// DO NOT EDIT THIS!
include GAME_DIR."modules/_dbselect.php";

// These are the key modules for game engine.
// We will initialize them here.
$user = new User;
$module = new Module;
$site = new Site;

// load language constants
// for multilingualization
// courtesy of the MBDS Project
// http://www.mbdsnet.org/
// to expand functionality, load/use class.language.php
$site->init_language($_SESSION["user_lang"]);

// check if any users exist
if ($user->check_users()) {
    // redirect to welcome page
    header("location: ".$_SERVER["PHP_SELF"]."?page=WELCOME");
}
//
// this "include" initializes all modules
//
include GAME_DIR."process_module.php";

?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$_SESSION["myencoding"]?>">
<title><?=strtoupper($_SESSION["datanode"]["name"])?> Info Desktop</title>
<?
$form = new GForm;
$form->load_javascript(GAME_DIR."javascript/range.js");
$form->load_javascript(GAME_DIR."javascript/timer.js");
$form->load_javascript(GAME_DIR."javascript/slider.js");
$form->load_css(GAME_DIR."javascript/css/swing/swing.css");
?>
<style type="text/css">
<!--
td { font-size: 10pt; font-family: verdana, sans-serif }
small { font-family: verdana, sans serif}
.textbox { font-family: verdana, arial, sans serif; font-size: 10pt; }
.whitetext { color: white; font-family: verdana, arial, sans serif; font-size: 10pt; }
.error { font-family: verdana, arial, sans serif; font-size: 12pt; color: red; }
.service { font-family: verdana, arial, sans serif; font-size: 12pt; font-weight: bold; color: #585858; }
.pt_menu { font-family: verdana, arial, sans serif; padding-top: 0px; padding-bottom: 0px; font-size: 8pt; font-weight: bold; color: black; }
.topmenu { font-family: verdana, arial, sans serif; font-size: 10pt; text-decoration: none; padding-left: 4px; padding-right: 4px; }
.topmenu:hover { font-family: verdana, arial, sans serif; font-size: 10pt; text-decoration: none; background-color: #FFFF00; border: 1px solid black; padding-left: 3px; padding-right: 3px;}
.groupmenu { font-family: verdana, arial, sans serif; font-size: 8pt; text-decoration: none; padding-left: 4px; padding-right: 4px; }
.groupmenu:hover { font-family: verdana, arial, sans serif; font-size: 8pt; text-decoration: none; background-color: #CCCCFF; border: 1px solid black; padding-left: 3px; padding-right: 3px; }
.complaintmenu { font-family: verdana, arial, sans serif; font-size: 8pt; text-decoration: none; padding-left: 4px; padding-right: 4px; }
.complaintmenu:hover { font-family: verdana, arial, sans serif; font-size: 8pt; text-decoration: none; background-color: #99FF99; border: 1px solid black; padding-left: 3px; padding-right: 3px;}
.sidemenu { font-family: verdana, arial, sans serif; font-size: 10pt; text-decoration: none; padding-left: 3px; padding-right: 3px; }
.sidemenu:hover { font-family: verdana, arial, sans serif; font-size: 10pt; text-decoration: none; background-color: #66FF33; border: 1px solid black; padding-left: 2px; padding-right: 2px;}
.catmenu { font-family: verdana, arial, sans serif; font-size: 10pt; text-decoration: none; padding-left: 3px; padding-right: 3px; }
.catmenu:hover { font-family: verdana, arial, sans serif; font-size: 10pt; text-decoration: none; background-color: #99FFFF; border: 1px solid black; padding-left: 2px; padding-right: 2px;}
.ptmenu { font-family: verdana, arial, sans serif; font-size: 10pt; text-decoration: none; padding-left: 3px; padding-right: 3px; }
.ptmenu:hover { font-family: verdana, arial, sans serif; font-size: 10pt; text-decoration: none; background-color: #FFFF33; border: 1px solid black; padding-left: 2px; padding-right: 2px;}
.boxtitle { font-family: verdana, arial, sans serif; font-size: 8pt; font-weight: bold;}
.tiny { font-family: verdana, arial, sans serif; font-size: 7pt; font-weight: bold; color: black; }
.tinylight { font-family: verdana, arial, sans serif; font-size: 7pt; font-weight: normal; color: black; }
.copyright { font-family: verdana, arial, sans serif; font-size: 7pt; font-weight: normal; color: black; }
.admin { font-family: verdana, arial, sans serif; font-size: 14pt; font-weight: bold; color: #FF3300; }
.module { font-family: verdana, arial, sans serif; font-size: 14pt; font-weight: bold; color: #9999FF; }
.library { font-family: verdana, arial, sans serif; font-size: 14pt; font-weight: bold; color: #999999; }
.patient { font-family: verdana, arial, sans serif; font-size: 14pt; font-weight: bold; color: #99CC66; }
.newstitle { font-family: verdana, arial, sans serif; font-size: 12pt; font-weight: bold; color: #666699; }
.newsbody { font-family: Georgia, Times New Roman, Serif; font-size: 12pt; font-weight: normal; color: black; }
-->
</style>
</head>
<script language="javascript" src="../popups.js"></script>
<script language="JavaScript" src="../ts_picker4.js"></script>
<body text="black" bgcolor="#FFFFCC" link="black" vlink="black">

<br/>
<table border="0" cellspacing="0" bgcolor="#000000" style="border: 4px solid black" width="100%" cellpadding="0">
  <tr bgcolor="#FF0000">
    <td valign="top">
    <?
    print "<img src='".GAME_DIR."images/".$_SESSION["datanode"]["banner"]."' border='0'>";
    ?>
    </td>
  </tr>
  <tr>
    <td>
    </td>
  </tr>
</table><br>
<table  bgcolor="#FFCC00" cellpadding="1" style="border: 1px solid black">
  <tr>
   <td>
   <?
   // horizontal menu
   if ($_SESSION["isadmin"]) {
       // display two-tier admin menu
       $site->displaymenu($_SESSION["validuser"],"ADMIN", $_SESSION["isadmin"], $_GET);
   } else {
       // display menus as top level menu
       $site->displaymenu($_SESSION["validuser"],"USER", $_SESSION["isadmin"], $_GET);
   }
   ?>
   </td>
  </tr>
</table><br>
<table style="border:1px solid black" bgcolor='white' width="100%" cellspacing="2" cellpadding="2">
    <tr>
    <td width="150" valign="top">
    <?
    include "../side_bar.php";
    ?>
    </td>
    <td width="450" valign="top">
    <br/>
    <blockquote>
    <?
    // MAIN BODY/DISPLAY SPACE
    $module->catch_error($_GET, $_POST);
    //$module->process_menu($_GET, $_POST);
    include "../process_menu.php";
    ?>
    </blockquote>
    <br/>
    </td>
    </tr>
</table>
<br/>
<div align="center" class='copyright'>
  &copy;2004 Generic Architecture for Modular Enterprise (GAME) Engine Version <?=$module->get_version()?> Herman Tolentino MD / UPCM Medical Informatics Unit / License - GPL<br>
</div>
</body>
</html>
<?
//phpinfo();
ob_end_flush();
?>

