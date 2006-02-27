<?
//
// this file handles all menu related module execution
//
if (isset($_GET["menu_id"])) {
    if (isset($_SESSION["validuser"]) && $_SESSION["validuser"]) {
        // if $menu_id is in the URL
        if ($_GET["menu_id"]) {
            $sql = "select module_id, menu_action from module_menu where menu_id = ".$_GET["menu_id"];
            if ($result = mysql_query($sql)) {
                if (mysql_num_rows($result)) {
                    if (list($module_id, $menu_action) = mysql_fetch_array($result)) {
                        $menu_id = $_GET["menu_id"];
                        $module_exec = "\$".$module_id."->".$menu_action."(\$menu_id, \$_POST, \$_GET,\$_SESSION[\"validuser\"],\$_SESSION[\"isadmin\"]);";
                        eval($module_exec);
                    }
                }
            }
        }
    } else {
        print "<font color='red'>You have no authorization for this page.</font>";
    }
} else {
    //
    // if $menu_id is not in URL,
    //   the following pages are displayed.
    //
    if (isset($_GET["page"])) {
        switch ($_GET["page"]) {
        case "WELCOME":
            $site->welcome();
            break;
        case "ABOUT":
            $site->print_about();
            break;
        case "HOWTO":
            $site->print_howto();
            break;
        case "CREDITS":
            $site->print_credits();
            break;
        case "ADMIN":
            if ($_SESSION["isadmin"]) {
                switch ($_GET["method"]) {
                case "CONTENT":
                    $site->_content($menu_id, $_POST, $_GET, $_SESSION["validuser"], $_SESSION["isadmin"]);
                    break;
                case "LOC":
                    $user->_location($menu_id, $_POST, $_GET);
                    break;
                case "ROLES":
                    $user->_roles($menu_id, $_POST,$_GET);
                    break;
                case "USER":
                default:
                    $user->_game_user($menu_id, $_POST,$_GET);
                }
            } else {
                print "<font color='red'>You have no authorization for this page.</font>";
            }
            break;
        case "MODULES":
            if ($_SESSION["validuser"] && $_SESSION["isadmin"]) {
                $module->_module($_POST, $_GET, $_FILES, $_SESSION["validuser"], $_SESSION["isadmin"]);
            } else {
                print "<font color='red'>You have no authorization for this page.</font>";
            }
            break;
        }
    } else {
        // check directory permissions
        print $module->directory_permissions();
        if (isset($_GET["errorinfo"])) {
            $errorinfo = $_GET["errorinfo"];
            if ($errorinfo) {
                // since this the default page errors appear here
                // after page refresh
                // error codes are stored in errorcodes table
                $module->error_message($errorinfo);
            }
        }
        if (isset($_GET["page"]) && module::in_menu($_GET["page"],array_values($menu_array[0]))) {
            $module->default_action($_GET["page"]);
        } else {
            if (isset($_GET["menu_id"])) {
                $site->deploy_content($_GET["menu_id"], $_POST, $_GET);
            }
        }
    } // end case
}
// end of file
?>