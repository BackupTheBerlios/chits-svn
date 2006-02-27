<table>
    <tr>
        <td>
        <?
        if (isset($_POST["submitlogin"])) {
            $user = $user->process_auth($_POST["login"], $_POST["passwd"]);
            if (count($user)>0) {
                print_r($user);
                $site->session_user($user);
                $site->record_access($_SESSION["userid"],$_SERVER["HTTP_USER_AGENT"],"ASC","login");
                header("location: ".$_SERVER["PHP_SELF"]);
            } else {
                // Invalid account
                    header("location: ".$_SERVER["PHP_SELF"]."?errorinfo=001");
            }
        }
        if (isset($_POST["submitlogout"])) {
            $user->process_signoff();
            header("location: ".$_SERVER["PHP_SELF"]);
        }
        if (!$_SESSION["validuser"]) {
            $user->authenticate();
        } else {
            $user->signoff($_SESSION["user_first"], $_SESSION["user_last"], $_SESSION["datanode"]["name"], $_SESSION["isadmin"], $_SERVER["REMOTE_ADDR"], $_SESSION["userid"]);
        }
        ?>
        </td>
    </tr>
    <tr>
        <td>
        <?
        $menu_array = module::readconfig(GAME_DIR."config/menu.xml", "menu");
        if ($_SESSION["isadmin"]) {
            $site->main_cat($_SESSION["validuser"], $_SESSION["isadmin"], $_GET, $menu_array);
        }
        ?>
        </td>
    </tr>
    <tr>
        <td>
        <?
        if ($_SESSION["isadmin"]) {
            if (isset($_GET["page"])) {
                $site->main_menu($_SESSION["validuser"], $_SESSION["isadmin"], $_GET["page"], $menu_array);
            }
        }
        ?>
        </td>
    </tr>
    <tr>
        <td>
        <?
        $site->main_stats();
        ?>
        </td>
    </tr>
</table>
