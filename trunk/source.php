<?
// buffer everything till the end
ob_start();

// start session
session_start();

// expire page so no cookies will be stored
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Pragma: no-cache"); // HTTP/1.0
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$HTTP_SESSION_VARS["myencoding"]?>">
<title>CHITS Module Source</title>
<style type="text/css">
<!--
td { font-size: 10pt; font-family: verdana, sans-serif }
small { font-family: verdana, sans serif}
.textbox { font-family: verdana, arial, sans serif; font-size: 10pt; border: 1px solid #000000; }
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
.tiny { font-family: arial, sans serif; font-size: 7pt; font-weight: bold; color: black; }
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
<body text="black" bgcolor="#FFFFFF" link="black" vlink="black">
<?
print "<span class='tinylight'>";
$string_array = explode(".", $HTTP_GET_VARS["class"]);
show_source("modules/".$string_array[1]."/".$HTTP_GET_VARS["class"]);
print "</span>";
?>
</body>
</html>
<?
//phpinfo();
ob_end_flush();
?>
