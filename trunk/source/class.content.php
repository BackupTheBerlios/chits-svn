<?
class content extends module {

    // Author: Herman Tolentino MD
    // CHITS Project 2004
    // for module guidelines see MODULES.TXT

    function content() {
    //
    // constructor
    // do not forget to update version
    //
        $this->author = 'Herman Tolentino MD';
        $this->version = "0.3-".date("Y-m-d");
        // 0.3 debugged front page empty page
        $this->module = "content";
        $this->description = "CHITS Module - Generic Content";
    }

    // --------------- STANDARD MODULE FUNCTIONS ------------------

    function init_deps() {
    //
    // insert dependencies in module_dependencies
    //
        module::set_dep($this->module, "module");
        module::set_dep($this->module, "user");

    }

    function init_lang() {
    //
    // insert necessary language directives
    // NOTES:
    //
        module::set_lang("FTITLE_NEWS_FORM", "english", "NEWS FORM", "Y");
        module::set_lang("LBL_NEWS_AUTHOR", "english", "NEWS AUTHOR", "Y");
        module::set_lang("LBL_NEWS_TITLE", "english", "NEWS TITLE", "Y");
        module::set_lang("LBL_NEWS_LEAD", "english", "NEWS LEAD", "Y");
        module::set_lang("LBL_NEWS_TEXT", "english", "NEWS TEXT", "Y");
        module::set_lang("LBL_NEWS_ACTIVE", "english", "ACTIVE", "Y");
        module::set_lang("INSTR_CHECK_ACTIVATE", "english", "Check to activate", "Y");
        module::set_lang("FTITLE_SITE_NEWS", "english", "SITE NEWS", "Y");
        module::set_lang("FTITLE_NEWS_ARCHIVE", "english", "NEWS ARCHIVE", "Y");

    }

    function init_help() {
    }

    function init_menu() {
    //
    // menu entries
    // use multiple inserts (watch out for ;)
    //
        if (func_num_args()>0) {
            $arg_list = func_get_args();
        }

        module::set_menu($this->module, "Content Modules", "CONTENT", "_content");

        // put in more details
        module::set_detail($this->description, $this->version, $this->author, $this->module);

    }

    function init_sql() {
    //
    // create module tables
    //
        if (func_num_args()>0) {
            $arg_list = func_get_args();
            $module_id = $arg_list[0];
        }

        module::execsql("CREATE TABLE `m_content` (".
            "`content_id` int(11) NOT NULL auto_increment,".
            "`content_module` varchar(25) NOT NULL default '',".
            "`content_column` int(11) NOT NULL default '0',".
            "`content_active` char(1) NOT NULL default '',".
            "`content_level` int(11) NOT NULL default '0',".
            "PRIMARY KEY  (`content_id`)".
            ") TYPE=MyISAM; ");


        //module::load_sql("vaccine.sql");
    }

    function drop_tables() {
    //
    // called from delete_module()
    //
        $sql = "DROP TABLE `m_content`;";
        module::execsql($sql);

    }

    // --------------- CUSTOM MODULE FUNCTIONS ------------------

    function _content() {
        if (func_num_args()>0) {
            $arg_list = func_get_args();
            $menu_id = $arg_list[0];
            $post_vars = $arg_list[1];
            $get_vars = $arg_list[2];
            $validuser = $arg_list[3];
            $isadmin = $arg_list[4];
        }
        print "<table width='300'>";
        print "<tr valign='top'><td>";
        print "<span class='library'>".FTITLE_SITE_NEWS."</span><br>";
        print "</td></tr>";
        $sql = "select news_id, news_timestamp, news_title, news_author, news_lead from m_news order by news_timestamp desc";
        if ($result = mysql_query($sql)) {
            if (mysql_num_rows($result)) {
                while (list($id, $ts, $title, $author, $lead) = mysql_fetch_array($result)) {
                    print "<tr valign='top'><td>";
                    if (!isset($menu_id)) {
                        $menu_id = module::get_menu_id("_news");
                    }
                    print "<a href='".$_SERVER["SELF"]."?page=CONTENT&menu_id=$menu_id&news_id=$id' class='boxtext'><b>$title</b></a><br />";
                    print "<span class='tiny'><b>$ts ".user::get_username($author)."</b></span><br/>";
                    print "$lead<br />";
                    print "</td></tr>";
                }
            } else {
                print "<font color='red'>No content loaded.</font><br/>";                
            }
        }
        print "</table><br>";

    }

    function _news_archive() {
    //
    // main method for news
    // called from database menu entry
    // calls form_news(), process_news(), display_news()
    //
        // always check dependencies
        if ($exitinfo = module::missing_dependencies('vaccine')) {
            return print($exitinfo);
        }
        if (func_num_args()>0) {
            $arg_list = func_get_args();
            $menu_id = $arg_list[0];
            $post_vars = $arg_list[1];
            $get_vars = $arg_list[2];
            $validuser = $arg_list[3];
            $isadmin = $arg_list[4];
        }
        //static $n;
        $n = new news;

        print "<table width='600' cellspacing='0' cellpadding='0'><tr valign='top'><td>";
        $n->form_news($menu_id, $post_vars, $get_vars, $isadmin);
        print "</td><td>";
        if ($post_vars["submitnews"]) {
            $n->process_news($menu_id, $post_vars, $get_vars);
            header("location: ".$_SERVER["PHP_SELF"]."?page=".$get_vars["page"]."&menu_id=".$get_vars["menu_id"]);
        }
        $n->display_news($menu_id, $post_vars, $get_vars);
        print "</td></tr></table>";
    }

    function display_news() {
    //
    // called from _vaccine()
    //
        if (func_num_args()) {
            $arg_list = func_get_args();
            $menu_id = $arg_list[0];
            $post_vars = $arg_list[1];
            $get_vars = $arg_list[2];
            $validuser = $arg_list[3];
            $isadmin = $arg_list[4];
        }
        print "<table width='300'>";
        print "<tr valign='top'><td colspan='3'>";
        print "<span class='library'>".FTITLE_NEWS_ARCHIVE."</span><br>";
        print "</td></tr>";
        $sql = "select news_id, news_timestamp, news_title from m_news order by news_timestamp desc";
        if ($result = mysql_query($sql)) {
            if (mysql_num_rows($result)) {
                while (list($id, $ts, $title) = mysql_fetch_array($result)) {
                    print "<tr valign='top'><td>$ts</td><td><a href='".$_SERVER["SELF"]."?page=".$get_vars["page"]."&menu_id=".$get_vars["menu_id"]."&news_id=$id'>$title</a></td></tr>";
                }
            }
        }
        print "</table><br>";
    }

    function form_news() {
    //
    // called from _vaccine()
    //
        if (func_num_args()) {
            $arg_list = func_get_args();
            $menu_id = $arg_list[0];
            $post_vars = $arg_list[1];
            $get_vars = $arg_list[2];
            $isadmin = $arg_list[3];
            if ($get_vars["news_id"]) {
                $sql = "select news_id, news_title, news_timestamp, news_author, news_lead, news_text, news_active ".
                       "from m_news where news_id = '".$get_vars["news_id"]."'";
                if ($result = mysql_query($sql)) {
                    if (mysql_num_rows($result)) {
                        $news = mysql_fetch_array($result);
                    }
                }
            }
        }
        print "<table width='300'>";
        print "<form action = '".$_SERVER["SELF"]."?page=".$get_vars["page"]."&menu_id=".$get_vars["menu_id"]."' name='form_vaccine' method='post'>";
        print "<tr valign='top'><td>";
        print "<span class='library'>".FTITLE_NEWS_FORM."</span><br><br>";
        print "</td></tr>";
        print "<tr valign='top'><td>";
        if ($get_vars["news_id"]) {
            print "<b>CREATED:</b> ".$news["news_timestamp"]."<br />";
        } else {
            print "<b>NOTE: Fill up the form with your news item content.</b><br /><br />";
        }
        print "</td></tr>";
        if ($_SESSION["isadmin"]) {
            print "<tr valign='top'><td>";
            print "<span class='boxtitle'>".LBL_NEWS_AUTHOR."</span><br> ";
            print user::show_users($news["news_author"]?$news["news_author"]:$post_vars["user_id"]);
            print "</td></tr>";
        } else {
            print "<input type='hidden' name='user_id' value='".$_SESSION["userid"]."' />";
        }
        print "<tr valign='top'><td>";
        print "<span class='boxtitle'>".LBL_NEWS_ACTIVE."</span><br> ";
        print "<input type='checkbox' name='news_active' ".($news["news_active"]=="Y"?"checked":"")." value='1' > ".INSTR_CHECK_ACTIVATE."<br>";
        print "</td></tr>";
        print "<tr valign='top'><td>";
        print "<span class='boxtitle'>".LBL_NEWS_TITLE."</span><br> ";
        print "<input type='text' class='textbox' size='25' maxlength='50' name='news_title' value='".($news["news_title"]?$news["news_title"]:$post_vars["news_title"])."' style='border: 1px solid #000000'><br>";
        print "</td></tr>";
        print "<tr valign='top'><td>";
        print "<span class='boxtitle'>".LBL_NEWS_LEAD."</span><br> ";
        print "<textarea rows='3' cols='35' name='news_lead' class='textbox' style='border: 1px solid #000000'>".stripslashes(($news["news_lead"]?$news["news_lead"]:$post_vars["news_lead"]))."</textarea>";
        print "</td></tr>";
        print "<tr valign='top'><td>";
        print "<span class='boxtitle'>".LBL_NEWS_TEXT."</span><br> ";
        print "<textarea rows='7' cols='35' name='news_text' class='textbox' style='border: 1px solid #000000'>".stripslashes(($news["news_text"]?$news["news_text"]:$post_vars["news_text"]))."</textarea>";
        print "</td></tr>";
        print "<tr><td><br>";
        if ($get_vars["news_id"]) {
            print "<input type='hidden' name='news_id' value='".$get_vars["news_id"]."'>";
            if ($_SESSION["priv_update"]) {
                print "<input type='submit' value = 'Update News' class='textbox' name='submitnews' style='border: 1px solid #000000'> ";
            }
            if ($_SESSION["priv_delete"]) {
                print "<input type='submit' value = 'Delete News' class='textbox' name='submitnews' style='border: 1px solid #000000'> ";
            }
        } else {
            if ($_SESSION["priv_add"]) {
                print "<input type='submit' value = 'Add News' class='textbox' name='submitnews' style='border: 1px solid #000000'> ";
            }
        }
        print "</td></tr>";
        print "</form>";
        print "</table><br>";
    }

    function process_news() {
    //
    // called from _vaccine()
    //
        if (func_num_args()>0) {
            $arg_list = func_get_args();
            $menu_id = $arg_list[0];
            $post_vars = $arg_list[1];
            $get_vars = $arg_list[2];
            //print_r($arg_list);
        }
        if ($post_vars["submitnews"]) {
            $active = ($post_vars["news_active"]?"Y":"N");
            if ($post_vars["news_title"] && $post_vars["news_lead"]) {
                switch($post_vars["submitnews"]) {
                case "Add News":
                    print $sql = "insert into m_news (news_timestamp, news_title, news_lead, news_text, ".
                           "news_author, news_active) ".
                           "values (sysdate(), ".
                           "'".addslashes(ucwords($post_vars["news_title"]))."', ".
                           "'".addslashes($post_vars["news_lead"])."', ".
                           " '".addslashes($post_vars["news_text"])."', ".
                           " '".$post_vars["user_id"]."', ".
                           " '$active') ";
                    $result = mysql_query($sql);
                    break;
                case "Update News":
                    $sql = "update m_news set ".
                           "news_title = '".addslashes(ucwords($post_vars["news_title"]))."', ".
                           "news_author = '".$post_vars["user_id"]."', ".
                           "news_lead = '".addslashes($post_vars["news_lead"])."', ".
                           "news_text = '".addslashes($post_vars["news_text"])."', ".
                           "news_active= '$active', ".
                           "where news_id = '".$post_vars["news_id"]."'";
                    $result = mysql_query($sql);
                    break;
                case "Delete News":
                    if (module::confirm_delete($menu_id, $post_vars, $get_vars)) {
                        $sql = "delete from m_news ".
                               "where news_id = '".$post_vars["news_id"]."'";
                        $result = mysql_query($sql);
                    } else {
                        if ($post_vars["confirm_delete"]=="No") {
                            header("location: ".$_SERVER["PHP_SELF"]."?page=".$get_vars["page"]."&menu_id=".$get_vars["menu_id"]);
                        }
                    }
                    break;
                }
            }
        }
    }

}
?>
