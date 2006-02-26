<?
// ADMIN
ob_start("ob_gzhandler");
session_start();
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Pragma: no-cache"); // HTTP/1.0

include "../class.mysqldb.php";
include "../class.referrer.php";
include "../class.shoutbox.php";
include "../class.news.php";
include "../class.patient.php";
include "../class.anesthesiologist.php";
include "../class.site.php";
include "../class.kbase.php";
include "../class.nurse.php";
include "../initsession.php";

$db = new MySQLDB;
$conn = $db->connid();
$db->selectdb("openaims");
$referrer = new Referrer;
$anes = new Anes;
$nurse = new Nurse;
$patient = new Patient;
$site = new Site;
$kbase = new Kbase;
$shoutbox = new Shoutbox;

if (!$site->apply_iprestriction($_SERVER["REMOTE_ADDR"],"DSS")) {
    session_destroy();
    header("location: warning.html");
}

?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
<title>Anesthesia DSS Console</title>
<style type="text/css">
<!--
td { font-size: 10pt; font-family: verdana, sans-serif }
small { font-family: verdana, sans serif}
.whitetext { color: white; font-family: verdana, arial, sans serif; font-size: 10pt; }
.textbox { font-family: verdana, arial, sans serif; font-size: 10pt; border: 1px solid #000000; }
.error { font-family: verdana, arial, sans serif; font-size: 10pt; color: red; }
.service { font-family: verdana, arial, sans serif; font-size: 12pt; font-weight: bold; color: #585858; }
.member_menu { font-family: arial, sans serif; padding-top: 0px; padding-bottom: 0px; font-size: 8pt; font-weight: bold; color: black; }
.smallbutton { font-family: verdana, arial, sans serif; font-size: 7pt; border: 1px solid #000000; background-color: #FFCC66; }
.formbox { border: 3px dotted #999999; padding: 5px; width: 100%; }
.memberbox { border: 3px solid #999999; padding: 5px; width: 100%; }
.membermenu { font-family: verdana, arial, sans serif; font-size: 8pt; text-decoration: none; border: 1px solid black; padding-left: 2px; padding-right: 2px;}
.sidemenu { font-family: verdana, arial, sans serif; font-size: 10pt; text-decoration: none; padding-left: 3px; padding-right: 3px; }
.sidemenu:hover { font-family: verdana, arial, sans serif; font-size: 10pt; text-decoration: none; background-color: #66FF33; border: 1px solid black; padding-left: 2px; padding-right: 2px;}
.topmenu { font-family: verdana, arial, sans serif; font-size: 10pt; text-decoration: none; padding-left: 4px; padding-right: 4px; }
.topmenu:hover { font-family: verdana, arial, sans serif; font-size: 10pt; text-decoration: none; background-color: #FFFF00; border: 1px solid black; padding-left: 3px; padding-right: 3px;}
.formtitle { font-family: verdana, arial, sans serif; font-size: 14pt; font-weight: bold; color: #CC0033; }
-->
</style>
</head>
<script language="javascript" src="../popups.js"></script>
<script language="JavaScript" src="../ts_picker4.js"></script>
<script language="JavaScript">
function check_casetype (field) {
    if (field.value=='M') {
        document.form_referral.proc_room.value='TBA';
        document.form_referral.anes_service.value='EMERG';
    } else {
        document.form_referral.proc_room.selectedIndex=0;
        document.form_referral.anes_service.selectedIndex=0;
    }
}

</script>
<body text="black" bgcolor="#CCFFCC" link="black" vlink="black">
<br/>
<table border="0" cellspacing="0" width="650" cellpadding="0">
  <tr>
    <td valign="top">
    <?
    $flash_shape = new SWFGradient();
    ?>
    <h1><font face="Georgia, Times New Roman">Anesthesia DSS Console</font><br><font size="3" face="Tahoma, Arial, Sans Serif">Creating knowledge at your fingertips.</font></h1>
    </td>
  </tr>
</table><br>
<div align="left">
<table  bgcolor="#FFCC00" style="border: 1px solid black">
  <tr>
   <td>
   <?
   $site->displaymenu($_SESSION["validuser"],"NAV", $_SESSION["isadmin"]);
   ?>
   </td>
  </tr>
</table><br>
</div>
<table style="border:1px solid black" bgcolor='white' width="100%" cellspacing="2" cellpadding="2">
    <tr>
    <td width="150" valign="top">
    <table>
        <tr>
            <td>
            <?
            if ($HTTP_POST_VARS["submitlogin"]) {
                $user = $anes->process_auth($HTTP_POST_VARS["login"], $HTTP_POST_VARS["passwd"]);
                if (count($user)>0) {
                    $_SESSION["isadmin"] = $user["isadmin"];
                    if ($_SESSION["isadmin"]=="Y") {
                        $_SESSION["validuser"] = true;
                        $_SESSION["userid"] = $user["userid"];
                        $_SESSION["anes_first"] = $user["firstname"];
                        $_SESSION["anes_last"] = $user["lastname"];
                        $_SESSION["anes_cellular"] = $user["cellphone"];
                        $_SESSION["anes_email"] = $user["email"];
                        $site->record_access($_SESSION["userid"],$HTTP_USER_AGENT,"DSS","login");
                        header("location: ".$_SERVER["PHP_SELF"]);
                    } else {
                        $anes->print_error("<span class='error'>Invalid account. Admins only.</span>");
                    }
                } else {
                    $anes->print_error("<span class='error'>Invalid account. Admins only.</span>");
                }
            }
            if ($HTTP_POST_VARS["submitlogout"]) {
                $anes->process_signoff();
                header("location: ".$_SERVER["PHP_SELF"]);
            }
            if (!$_SESSION["validuser"]) {
                $anes->authenticate();
            } else {
                $anes->signoff($_SESSION["anes_first"], $_SESSION["anes_last"], "Anesthesia", $_SESSION["isadmin"], $_SERVER["REMOTE_ADDR"]);
            }
            ?>
            </td>
        <tr>
            <td>
            <?
            if ($_SESSION["validuser"]) {
                if ($main && ($_SESSION["mainparam"] <> $main)) {
                    $_SESSION["mainparam"] = $main;
                }
                $site->main_menu($_SESSION["validuser"], $_SESSION["mainparam"]);
                //print "selected: ".$_SESSION["mainparam"];
            }
            ?>
            </td>
        </tr>
        <tr>
            <td>
            <?
            $site->main_stats($_SESSION["validuser"]);
            ?>
            </td>
        </tr>
        <tr>
            <td>
            <?
            $anes->display_team(date("Y-m-d"));
            ?>
            </td>
        </tr>
    </table>
    </td>
    <td width="450" valign="top">
    <br/>
    <blockquote>
    <?
    switch ($page) {
    case "ABOUT":
        $site->print_about("DSS");
        break;
    case "DUPLIC":
        if ($_SESSION["validuser"]) {
            print "<h3>Duplicate Records</h3>";
            $patient->show_duplicates();
        } else {
            header("location: ".$_SERVER["SELF"]);
        }
        break;
    case "TEAM":
        if ($_SESSION["validuser"]) {
            if ($HTTP_POST_VARS["submitteam"]) {
                $anes->process_team($HTTP_POST_VARS);
                header("location: ".$_SERVER["SELF"]."?page=TEAM");
            }
            $anes->register_team($HTTP_POST_VARS);
        } else {
            header("location: ".$_SERVER["SELF"]);
        }
        break;
    case "SHOUT":
        if ($_SESSION["validuser"]) {
            if ($HTTP_POST_VARS["submitdelete"]) {
                $shoutbox->process_shoutdelete($HTTP_POST_VARS);
                header("location: ".$_SERVER["SELF"]."?page=SHOUT");
            }
            $shoutbox->display_shoutdelete();
        } else {
            header("location: ".$_SERVER["SELF"]);
        }
        break;
    case "NURSE":
        if ($_SESSION["validuser"]) {
            if ($HTTP_POST_VARS["submitnurse"]) {
                $nurse->process_nurse($HTTP_POST_VARS);
                header("location: ".$_SERVER["SELF"]."?page=NURSE");
           }
            $nurse->form_nurse($HTTP_POST_VARS, $nurse_id);
            $nurse->display_nurses();
        } else {
            header("location: ".$_SERVER["SELF"]);
        }
        break;
    case "ANES":
        if ($_SESSION["validuser"]) {
            if ($HTTP_POST_VARS["submitanes"]) {
                $anes->process_anes($HTTP_POST_VARS);
                header("location: ".$_SERVER["SELF"]."?page=ANES");
            }
            $anes->form_anes($HTTP_POST_VARS, $anes_id);
            $anes->display_anes();
        } else {
            header("location: ".$_SERVER["SELF"]);
        }
        break;
    case "REFERRER":
        if ($_SESSION["validuser"]) {
            if ($HTTP_POST_VARS["submitreferrer"]) {
                $referrer->process_referrer($HTTP_POST_VARS);
                header("location: ".$_SERVER["SELF"]."?page=REFERRER");
            }
            $referrer->form_referrer($HTTP_POST_VARS, $ref_id);
            $referrer->display_referrers();
        } else {
            header("location: ".$_SERVER["SELF"]);
        }
        break;
    case "DEFERRALS":
        if ($_SESSION["validuser"]) {
            if ($HTTP_POST_VARS["submitdefer"]) {
                $kbase->process_defer($HTTP_POST_VARS);
                header("location: ".$_SERVER["SELF"]."?page=DEFERRALS");
            }
            $kbase->form_defer($HTTP_POST_VARS, $defer_id);
            $kbase->display_defer();
        } else {
            header("location: ".$_SERVER["SELF"]);
        }
        break;
    case "TERMS":
        if ($_SESSION["validuser"]) {
            if ($HTTP_POST_VARS["submitterm"]) {
                $kbase->process_term($HTTP_POST_VARS);
                header("location: ".$_SERVER["SELF"]."?page=TERMS");
            }
            $kbase->form_term($HTTP_POST_VARS, $term_id);
            $kbase->display_terms();
        } else {
            header("location: ".$_SERVER["SELF"]);
        }
        break;
    case "ANCIL":
        if ($_SESSION["validuser"]) {
            if ($HTTP_POST_VARS["submitancil"]) {
                $kbase->process_ancil($HTTP_POST_VARS);
                header("location: ".$_SERVER["SELF"]."?page=ANCIL");
            } 
            $kbase->form_ancil($HTTP_POST_VARS, $proc_id);
            $kbase->display_ancil();
        } else {
            header("location: ".$_SERVER["SELF"]);
        }
        break;
    case "PAINC":
        if ($_SESSION["validuser"]) {
            if ($HTTP_POST_VARS["submitpain"]) {
                $kbase->process_pain($HTTP_POST_VARS);
                header("location: ".$_SERVER["SELF"]."?page=PAINC");
            }
            $kbase->form_pain($HTTP_POST_VARS, $pain_id);
            $kbase->display_pain();
        } else {
            header("location: ".$_SERVER["SELF"]);
        }
        break;
    case "ROOM":
        if ($_SESSION["validuser"]) {
            if ($HTTP_POST_VARS["submitroom"]) {
                $kbase->process_room($HTTP_POST_VARS);
                header("location: ".$_SERVER["SELF"]."?page=ROOM");
            }
            $kbase->form_room($HTTP_POST_VARS, $room_id);
            $kbase->display_rooms();
        } else {
            header("location: ".$_SERVER["SELF"]);
        }
        break;
    case "IPADDR":
        if ($_SESSION["validuser"]) {
            // allowed IP address for DSS Console
            if ($HTTP_POST_VARS["submitipaddress"]) {
                $kbase->process_ipaddress($HTTP_POST_VARS);
                header("location: ".$_SERVER["SELF"]."?page=IPADDR");
            }
            $kbase->form_ipaddress($HTTP_POST_VARS, $ipaddress, $sitecode);
            $kbase->display_ipaddress();
        } else {
            header("location: ".$_SERVER["SELF"]);
        }
        break;
    case "CONCEPTS":
        if ($_SESSION["validuser"]) {
            if ($HTTP_POST_VARS["submitconcept"]) {
                $kbase->process_concept($HTTP_POST_VARS);
                header("location: ".$_SERVER["SELF"]."?page=CONCEPTS");
            }
            $kbase->form_concept($HTTP_POST_VARS, $concept_id);
            $kbase->display_concepts();
        } else {
            header("location: ".$_SERVER["SELF"]);
        }
        break;
    case "TEMPL":
        if ($_SESSION["validuser"]) {
            if ($HTTP_POST_VARS["submittemplate"]) {
                $kbase->process_template($HTTP_POST_VARS);
                header("location: ".$_SERVER["SELF"]."?page=TEMPL");
            }
            $kbase->form_template($HTTP_POST_VARS, $template_id);
            $kbase->display_templates();
        } else {
            header("location: ".$_SERVER["SELF"]);
        }
        break;
    case "IMAGE":
        if ($_SESSION["validuser"]) {
            if ($HTTP_POST_VARS["submitimage"]) {
                $kbase->process_image($HTTP_POST_VARS, $HTTP_POST_FILES,"dss_mmobjects/images/");
                header("location: ".$_SERVER["SELF"]."?page=IMAGE");
            }
            $kbase->form_image($HTTP_POST_VARS, $image_id);
            $kbase->display_images();
        } else {
            header("location: ".$_SERVER["SELF"]);
        }
        break;
    case "KBASE":
        if ($_SESSION["validuser"]) {
            if ($HTTP_POST_VARS["submitkbase"]) {
                $kbase->process_kbase($HTTP_POST_VARS);
                //header("location: ".$_SERVER["SELF"]."?page=KBASE");
            }
            $kbase->form_kbase($HTTP_POST_VARS, $kbase_id);
            $kbase->display_kbase();
        } else {
            header("location: ".$_SERVER["SELF"]);
        }
        break;
    case "DEFERRAL":
        if ($_SESSION["validuser"]) {
            if ($HTTP_POST_VARS["submitdeferral"]) {
                $kbase->process_deferral($HTTP_POST_VARS);
                header("location: ".$_SERVER["SELF"]."?page=DEFERRAL");
            }
            $kbase->form_deferral($HTTP_POST_VARS, $defer_id);
            $kbase->display_deferral();
        } else {
            header("location: ".$_SERVER["SELF"]);
        }
        break;
    case "CONSULTANT":
        if ($_SESSION["validuser"]) {
            if ($HTTP_POST_VARS["submitconsultant"]) {
                $kbase->process_consultant($HTTP_POST_VARS);
                header("location: ".$_SERVER["SELF"]."?page=CONSULTANT");
            }
            $kbase->form_consultant($HTTP_POST_VARS, $consultant_id, $service_year, $service_id);
            $kbase->display_consultants();
        } else {
            header("location: ".$_SERVER["SELF"]);
        }
        break;
    case "LOCATION":
        if ($_SESSION["validuser"]) {
            if ($HTTP_POST_VARS["submitlocation"]) {
                $kbase->process_location($HTTP_POST_VARS);
                header("location: ".$_SERVER["SELF"]."?page=LOCATION");
            }
            $kbase->form_location($HTTP_POST_VARS, $location_id);
            $kbase->display_location();
        } else {
            header("location: ".$_SERVER["SELF"]);
        }
        break;
    case "MONITORS":
        if ($_SESSION["validuser"]) {
            if ($HTTP_POST_VARS["submitmonitor"]) {
                $kbase->process_monitor($HTTP_POST_VARS);
                header("location: ".$_SERVER["SELF"]."?page=MONITORS");
            }
            $kbase->form_monitor($HTTP_POST_VARS, $monitor_id);
            $kbase->display_monitors();
        } else {
            header("location: ".$_SERVER["SELF"]);
        }
        break;
    case "TECH":
        if ($_SESSION["validuser"]) {
            if ($HTTP_POST_VARS["submittechnique"]) {
                $kbase->process_technique($HTTP_POST_VARS);
                header("location: ".$_SERVER["SELF"]."?page=TECH");
            }
            $kbase->form_technique($HTTP_POST_VARS, $tech_id);
            $kbase->display_techniques();
        } else {
            header("location: ".$_SERVER["SELF"]);
        }
        break;
    case "POSITION":
        if ($_SESSION["validuser"]) {
            if ($HTTP_POST_VARS["submitposition"]) {
                $kbase->process_position($HTTP_POST_VARS);
                header("location: ".$_SERVER["SELF"]."?page=POSITION");
            }
            $kbase->form_position($HTTP_POST_VARS, $position_id);
            $kbase->display_positions();
        } else {
            header("location: ".$_SERVER["SELF"]);
        }
        break;
    case "SERVICE":
        if ($_SESSION["validuser"]) {
            if ($HTTP_POST_VARS["submitservice"]) {
                $kbase->process_service($HTTP_POST_VARS);
                header("location: ".$_SERVER["SELF"]."?page=SERVICE");
            }
            $kbase->form_service($HTTP_POST_VARS, $service_id);
            $kbase->display_services();
        } else {
            header("location: ".$_SERVER["SELF"]);
        }
        break;
    case "DEPT":
        if ($_SESSION["validuser"]) {
            if ($HTTP_POST_VARS["submitdept"]) {
                $kbase->process_department($HTTP_POST_VARS);
                header("location: ".$_SERVER["SELF"]."?page=DEPT");
            }
            $kbase->form_department($HTTP_POST_VARS, $dept_id);
            $kbase->display_departments();
        } else {
            header("location: ".$_SERVER["SELF"]);
        }
        break;
    case "PROC":
        if ($_SESSION["validuser"]) {
            if ($HTTP_POST_VARS["submitclass"]) {
                $kbase->process_proc($HTTP_POST_VARS);
                header("location: ".$_SERVER["SELF"]."?page=PROC");
            }
            $kbase->form_proc($HTTP_POST_VARS, $class_id);
            $kbase->display_proc();
        } else {
            header("location: ".$_SERVER["SELF"]);
        }
        break;
    case "DRUGS":
        if ($_SESSION["validuser"]) {
            if ($HTTP_POST_VARS["submitdrug"]) {
                $kbase->process_drug($HTTP_POST_VARS);
                header("location: ".$_SERVER["SELF"]."?page=DRUGS");
            }
            $kbase->form_drugs($HTTP_POST_VARS, $drug_id);
            $kbase->display_drugs();
        } else {
            header("location: ".$_SERVER["SELF"]);
        }
        break;
    case "RISK":
        if ($_SESSION["validuser"]) {
            if ($HTTP_POST_VARS["submitrisk"]) {
                $kbase->process_risk($HTTP_POST_VARS);
                header("location: ".$_SERVER["SELF"]."?page=RISK");
            }
            $kbase->form_risk($HTTP_POST_VARS, $risk_id);
            $kbase->display_risk();
        } else {
            header("location: ".$_SERVER["SELF"]);
        }
        break;
    case "ROUTES":
        if ($_SESSION["validuser"]) {
            if ($HTTP_POST_VARS["submitroute"]) {
                $kbase->process_route($HTTP_POST_VARS);
                header("location: ".$_SERVER["SELF"]."?page=ROUTES");
            }
            $kbase->form_route($HTTP_POST_VARS, $route_id);
            $kbase->display_routes();
        } else {
            header("location: ".$_SERVER["SELF"]);
        }
        break;
    case "CHK":
        if ($_SESSION["validuser"]) {
            if ($HTTP_POST_VARS["submitchecklist"]) {
                $kbase->process_checklist($HTTP_POST_VARS);
                header("location: ".$_SERVER["SELF"]."?page=CHK");
            }
            $kbase->form_checklist($HTTP_POST_VARS, $checklist_id);
            $kbase->display_checklist();
        } else {
            header("location: ".$_SERVER["SELF"]);
        }
        break;
    case "CREDITS":
        $site->print_credits();
        break;
    case "REPORT":
        break;
    case "PACU":
        $site->display_pacuscore();
        break;
    case "SEARCH":
        if ($_SESSION["validuser"]) {
            print "<h3>Patient Search</h3>";
            if ($HTTP_POST_VARS["submitsearch"]) {
                $patient->displaylist("SEARCH",$_SESSION["referrer_id"], $HTTP_POST_VARS);
            }
            $patient->newsearch();
        } else {
            header("location: ".$_SERVER["SELF"]);
        }
        break;
    case "HOWTO":
        $site->print_howto("DSS");
        break;
    case "LOGINS":
        if ($_SESSION["validuser"]) {
            $site->form_logins();
            if ($HTTP_POST_VARS["submitlogins"]) {
                $site->record_access($_SESSION["userid"],$HTTP_USER_AGENT,"DSS","loginhx");
                $site->display_logins($HTTP_POST_VARS);
            }
        } else {
            header("location: ".$_SERVER["SELF"]);
        }
        break;
    case "ALLREFERRALS":
        if ($_SESSION["validuser"]) {
            if ($HTTP_POST_VARS["ptmenu"]) {
                $patient->process_menu($HTTP_POST_VARS,$referral_id);
            } else {
                print "<h3>Patient Referrals</h3>";
                if ($HTTP_POST_VARS["submitdeletereferral"]) {
                    $patient->process_referral_delete($HTTP_POST_VARS);
                    header("location: ".$_SERVER["PHP_SELF"]."?page=ALLREFERRALS");
                }
                $patient->displaylist("DSS",$_SESSION["userid"], $HTTP_POST_VARS);
            }
        } else {
            header("location: ".$_SERVER["PHP_SELF"]."?page=HOWTO");
        }
        break;
    default:
        print "<h3>Patient List as of ".date("D, M j, Y")."</h3>";
        $patient->displaylist("APRS",$_SESSION["referrer_id"]);
        print "<h3>ShoutBox</h3>";
        if ($HTTP_POST_VARS["submitmessage"]) {
            $shoutbox->process_shout($HTTP_POST_VARS, $_SESSION["userid"], "ASC");
            header("location: ".$_SERVER["PHP_SELF"]);
        }
        $shoutbox->listmessages();
        if ($_SESSION["validuser"]) {
            $shoutbox->newshout();
        } else {
            $shoutbox->print_error("<span class='error'>You have to login to post messages.</span><br>");
        }
    }
    ?>
    </blockquote>
    <br/>
    </td>
    </tr>
</table>
<br/>
<div align="center">
  <small>
  <b>&copy;2004 UPCM Medical Informatics Unit, Department of Anesthesiology</b>
  </small>
</div>
</body>
</html>
<?
ob_end_flush();
?>

