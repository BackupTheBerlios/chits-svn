<?
class fecalysis extends module {

    // Author: Herman Tolentino MD
    // CHITS Project 2004

    function fecalysis() {
        //
        // do not forget to update version
        //
        $this->author = 'Ariel Betan/Herman Tolentino';
        $this->version = "0.2-".date("Y-m-d");
        $this->module = "fecalysis";
        $this->description = "CHITS Module - Fecalysis";

    }

    // --------------- STANDARD MODULE FUNCTIONS ------------------

    function init_deps() {
    //
    // insert dependencies in module_dependencies
    //
        module::set_dep($this->module, "module");
        module::set_dep($this->module, "lab");

    }

    function init_lang() {
    //
    // insert necessary language directives
    //
    
    }

    function init_stats() {
    }

    function init_help() {
    }

    function init_menu() {
        // use this for updating menu system
        if (func_num_args()>0) {
            $arg_list = func_get_args();
        }

        // menu entries

        // add more detail
        module::set_detail($this->description, $this->version, $this->author, $this->module);

    }

    function init_sql() {
        if (func_num_args()>0) {
            $arg_list = func_get_args();
        }

        module::execsql("CREATE TABLE `m_consult_lab_fecalysis` (".
            "`consult_id` float NOT NULL default '0',".
            "`request_id` float NOT NULL default '0',".
            "`patient_id` float NOT NULL default '0',".
            "`lab_timestamp` timestamp(14) NOT NULL,".
            "`fec_collection_date` date NOT NULL default '0000-00-00',".
            "`fec_macro_findings` text NOT NULL,".
            "`fec_micro_findings` text NOT NULL,".
            "`user_id` float NOT NULL default '0',".
	    "`release_flag` char(1) NOT NULL default '',".
            "PRIMARY KEY  (`request_id`),".
            "KEY `key_patient` (`patient_id`),".
            "KEY `key_consult` (`consult_id`),".
            "KEY `key_user` (`user_id`),".
            ") TYPE=InnoDB; ");

    }

    function drop_tables() {

        module::execsql("DROP TABLE `m_consult_lab_fecalysis`;");
    }


    // --------------- CUSTOM MODULE FUNCTIONS ------------------

    function _consult_lab_fecalysis_results() {
        if (func_num_args()>0) {
            $arg_list = func_get_args();
            $menu_id = $arg_list[0];
            $post_vars = $arg_list[1];
            $get_vars = $arg_list[2];
        }
        $sql = "select l.request_id, l.request_user_id, l.request_done, ".
               "date_format(l.request_timestamp, '%a %d %b %Y, %h:%i%p') request_timestamp, ".
               "f.consult_id, f.patient_id, done_user_id, ".
               "if(l.done_timestamp<>'00000000000000', date_format(l.done_timestamp, '%a %d %b %Y, %h:%i%p'), 'NA') done_timestamp, ".
               "if(l.request_done='Y', (unix_timestamp(l.done_timestamp)-unix_timestamp(l.request_timestamp))/3600,(unix_timestamp(sysdate())-unix_timestamp(l.request_timestamp))/3600) elapsed, ".
               "f.fec_collection_date, ".
               "f.fec_macro_findings, ".
               "f.fec_micro_findings, ".
               "f.user_id, f.request_id ".
               "from m_consult_lab_fecalysis f, m_consult_lab l ".
               "where l.request_id = f.request_id and ".
               "f.request_id = '".$get_vars["request_id"]."'";
        if ($result = mysql_query($sql)) {
            if (mysql_num_rows($result)) {
                $fecalysis = mysql_fetch_array($result);
                print "<a name='fecalysis'>";
                print "<table style='border: 1px dotted black'><tr><td>";
                print "<span class='tinylight'>";
                print "<b>FECALYSIS RESULTS FOR ".strtoupper(patient::get_name($fecalysis["patient_id"]))."</b><br/>";
                print "REQUEST ID: <font color='red'>".module::pad_zero($fecalysis["request_id"],7)."</font><br/>";
                print "DATE REQUESTED: ".$fecalysis["request_timestamp"]."<br/>";
                print "REQUESTED BY: ".user::get_username($fecalysis["request_user_id"])."<br/>";
                print "DATE COMPLETED: ".$fecalysis["done_timestamp"]."<br/>";
                print "PROCESSED BY: ".($fecalysis["done_user_id"]?user::get_username($fecalysis["done_user_id"]):"NA")."<br/>";
                print "RELEASED: ".$fecalysis["release_flag"]."<br/>";
                print "<hr size='1'/>";
                print "SPECIMEN COLLECTION DATE:<br/>";
                print $fecalysis["fec_collection_date"]."<br/>";
                print "<hr size='1'/>";
                print "MACROSCOPIC FINDINGS:<br/>";
                print $fecalysis["fec_macro_findings"]."<br/>";
                print "<hr size='1'/>";
                print "MICROSCOPIC FINDINGS:<br/>";
                print $fecalysis["fec_micro_findings"]."<br/>";
		print "<hr size='1'/>";
                print "</span>";
                print "</td></tr></table>";
            }
        }
    }

    function _consult_lab_fecalysis() {
    //
    // main submodule for sputum
    //
        if (func_num_args()>0) {
            $arg_list = func_get_args();
            $menu_id = $arg_list[0];
            $post_vars = $arg_list[1];
            $get_vars = $arg_list[2];
            $validuser = $arg_list[3];
            $isadmin = $arg_list[4];
            //print_r($arg_list);
        }
        // always check dependencies
        if ($exitinfo = $this->missing_dependencies('fecalysis')) {
            return print($exitinfo);
        }
        $s = new fecalysis;
        if ($post_vars["submitlab"]) {
            $s->process_consult_lab_fecalysis($menu_id, $post_vars, $get_vars);
        }
        $s->form_consult_lab_fecalysis($menu_id, $post_vars, $get_vars);
    }

    function form_consult_lab_fecalysis() {
        if (func_num_args()>0) {
            $arg_list = func_get_args();
            $menu_id = $arg_list[0];
            $post_vars = $arg_list[1];
            $get_vars = $arg_list[2];
            $validuser = $arg_list[3];
            $isadmin = $arg_list[4];
            //print_r($arg_list);
        }
        print "<table width='300'>";
        print "<form action = '".$_SERVER["SELF"]."?page=".$get_vars["page"]."&menu_id=".$get_vars["menu_id"]."&consult_id=".$get_vars["consult_id"]."&module=fecalysis&request_id=".$get_vars["request_id"]."&lab_id=SPT' name='form_lab' method='post'>";
        print "<tr valign='top'><td>";
        print "<b>".FTITLE_LAB_EXAM_FORM."</b><br><br>";
        print "</td></tr>";
        print "<tr valign='top'><td>";
        print "<span class='boxtitle'>".LBL_LAB_REQUEST_DETAILS."</span><br> ";
        $sql = "select lab_id, consult_id, date_format(request_timestamp, '%a %d %b %Y, %h:%i%p') request_timestamp, request_user_id, request_done, ".
               "date_format(done_timestamp, '%a %d %b %Y, %h:%i%p') done_timestamp, done_user_id ".
               "from m_consult_lab ".
               "where request_id = '".$get_vars["request_id"]."'";
        if ($result = mysql_query($sql)) {
            if (mysql_num_rows($result)) {
                $lab = mysql_fetch_array($result);
                print "<table width='250' bgcolor='#FFFF99' style='border: 1px solid black'><tr><td class='tinylight'>";
                print "<b>".LBL_LAB_EXAM.":</b> ".lab::get_lab_name($lab["lab_id"])."<br/>";
                print "<b>".LBL_DATE_REQUESTED.":</b> ".$lab["request_timestamp"]."<br/>";
                print "<b>".LBL_REQUESTED_BY.":</b> ".user::get_username($lab["request_user_id"])."<br/>";
                print "<b>".LBL_DATE_PROCESSED.":</b> ".($lab["done_timestamp"]?$lab["done_timestamp"]:"NA")."<br/>";
                print "<b>".LBL_PROCESSED_BY.":</b> ".($lab["done_user_id"]?user::get_username($lab["done_user_id"]):"NA")."<br/>";
                print "</td></tr></table>";
            }
        }
        print "</td></tr>";
        print "<tr valign='top'><td>";
        if ($get_vars["request_id"]) {
            $sql_fecalysis = "select fec_collection_date, ".
                          "fec_macro_findings, ".
                          "fec_micro_findings,release_flag, ".
                          "from m_consult_lab_fecalysis ".
                          "where request_id = '".$get_vars["request_id"]."'";
            if ($result_fecalysis = mysql_query($sql_fecalysis)) {
                if (mysql_num_rows($result_fecalysis)) {
                    $fecalysis = mysql_fetch_array($result_fecalysis);
                    //print_r($fecalysis);
                    // set up collection dates
                    if ($fecalysis["fec_collection_date"]<>"0000-00-00") {
                        list($year,$month,$day) = explode("-",$fecalysis["fec_collection_date"]);
                        $fec_collection_date = "$month/$day/$year";
                    }
                }
            }
        }
        print "<table width='250' style='border: 1px dotted black'>";
        print "<tr><td class='boxtitle'>".LBL_SPECIMEN."</td><td class='boxtitle'>#1</td><td class='boxtitle'>#2</td><td class='boxtitle'>#3</td></tr>";
        print "<tr><td class='boxtitle'nowrap>".LBL_COLLECTION_DATE."</td>";
        print "<td>";
        print "<input type='text' size='10' class='tinylight' name='fec_collection_date' value='".($fec_collection_date?$fec_collection_date:$post_vars["fec_collection_date"])."' style='border: 1px solid #000000'> ";
        print "<a href=\"javascript:show_calendar4('document.form_lab.fec_collection_date', document.form_lab.fec_collection_date.value);\"><img src='../images/cal.gif' width='16' height='16' border='0' alt='Click Here to Pick up the date'></a> ";
        print "</td>";
        print "</tr>";
       // print "<tr><td class='boxtitle'nowrap>".LBL_MACROSCOPIC_FINDINGS."</td>";
       // print "<td>".fecalysis::load_template(($fecalysis["fec_macro_findings"]?$fecalysis["fec_macro_findings"]:$post_vars["fec_macro_findings"]),'fec_macro_findings')."</td>";
       // print "</tr>";
       // print "<tr><td class='boxtitle'nowrap>".LBL_MICROSCOPIC_FINDINGS."</td>";
       // print "<td>".fecalysis::load_template(($fecalysis["fec_micro_findings"]?$fecalysis["fec_micro_findings"]:$post_vars["fec_micro_findings"]),'fec_micro_findings')."</td>";
       // print "</tr>";
        print "<tr valign='top'><td>";
        print "<br>";
        print "<span class='boxtitle'>".LBL_MACROSCOPIC_FINDINGS."</span><br> ";
        $default_macroscopic = fecalysis::load_template("FEC_MACROSCOPIC");
        print "<textarea class='textbox' rows='8' cols='30' name='FEC_MACROSCOPIC' style='border: 1px solid #000000'>".($fecalysis["FEC_MACROSCOPIC"]?$fecalysis["FEC_MACROSCOPIC"]:($post_vars["FEC_MACROSCOPIC"]?$post_vars["FEC_MACROSCOPIC"]:$default_macroscopic))."</textarea><br>";
        print "</td></tr>";
        print "<tr valign='top'><td>";
        print "<span class='boxtitle'>".LBL_MICROSCOPIC_FINDINGS."</span><br> ";
        $default_microscopic = fecalysis::load_template("FEC_MICROSCOPIC");
        print "<textarea class='textbox' rows='8' cols='30' name='FEC_MICROSCOPIC' style='border: 1px solid #000000'>".($fecalysis["FEC_MICROSCOPIC"]?$fecalysis["FEC_MICROSCOPIC"]:($post_vars["FEC_MICROSCOPIC"]?$post_vars["FEC_MICROSCOPIC"]:$default_microscopic))."</textarea><br>";
        print "</td></tr>";
        print "</table>";
        print "</td></tr>";
        print "<tr valign='top'><td>";
        print "<span class='boxtitle'>".LBL_RELEASE_FLAG."</span><br> ";
        print "<input type='checkbox' name='release_flag' ".(($fecalysis["release_flag"]?$fecalysis["release_flag"]:$post_vars["release_flag"])=="Y"?"checked":"")." value='1'/> ".INSTR_RELEASE_FLAG."<br />";
        print "<br/></td></tr>";
        print "<tr><td><br>";
        if ($get_vars["request_id"]) {
            print "<input type='hidden' name='request_id' value='".$get_vars["request_id"]."'>";
            if ($_SESSION["priv_update"]) {
                print "<input type='submit' value = 'Update Lab Exam' class='textbox' name='submitlab' style='border: 1px solid #000000'> ";
            }
            if ($_SESSION["priv_delete"]) {
                print "<input type='submit' value = 'Delete Lab Exam' class='textbox' name='submitlab' style='border: 1px solid #000000'> ";
            }
        }
        print "</td></tr>";
        print "</form>";
        print "</table><br>";

    }

    function process_consult_lab_fecalysis() {
        if (func_num_args()>0) {
            $arg_list = func_get_args();
            $menu_id = $arg_list[0];
            $post_vars = $arg_list[1];
            $get_vars = $arg_list[2];
            $validuser = $arg_list[3];
            $isadmin = $arg_list[4];
            print_r($arg_list);
        }
        if ($post_vars["submitlab"]) {
            $patient_id = healthcenter::get_patient_id($get_vars["consult_id"]);
            switch($post_vars["submitlab"]) {
            case "Update Lab Exam":
                // enforce transaction
                // specimen 1
                if ($post_vars["fec_collection_date"]) {
                    list($month,$day,$year) = explode("/", $post_vars["fec_collection_date"]);
                    $sp1_collection_date = $year."-".str_pad($month, 2, "0", STR_PAD_LEFT)."-".str_pad($day, 2, "0", STR_PAD_LEFT);
                }

                $release_flag = ($post_vars["release_flag"]?"Y":"N");
                mysql_query("SET autocommit=0;") or die(mysql_error());
                mysql_query("START TRANSACTION;") or die(mysql_error());

                if ($release_flag=="Y") {
                    $sql = "update m_consult_lab set ".
                           "done_timestamp = sysdate(), ".
                           "request_done = 'Y', ".
                           "done_user_id = '".$_SESSION["userid"]."' ".
                           "where request_id = '".$post_vars["request_id"]."'";
                    if ($result = mysql_query($sql)) {
                        // successful.. so just go to next SQL statement in
                        // transaction set
                    } else {
                        mysql_query("ROLLBACK;") or die(mysql_error());
                        mysql_query("SET autocommit=1;") or die(mysql_error());
                        header("location: ".$_SERVER["PHP_SELF"]."?page=".$get_vars["page"]."&menu_id=".$get_vars["menu_id"]."&consult_id=".$get_vars["consult_id"]."&module=".$get_vars["module"]."&request_id=".$post_vars["request_id"]."&lab_id=".$get_vars["lab_id"]);
                    }
                }
                // try insert first, will fail if previous request has been inserted
                // because of primary key constraint - then it will cascade to update below...
                $sql_fecalysis = "insert into m_consult_lab_fecalysis (consult_id, request_id, patient_id, ".
                              "lab_timestamp, fec_collection_date, ".
                              "fec_macro_findings, ".
                              "fec_micro_findings, ".
                              "user_id, release_flag) values ('".$get_vars["consult_id"]."', '".$post_vars["request_id"]."', ".
                              "'$patient_id', sysdate(), '$fec_collection_date', ".
                              "'".$post_vars["fec_macro_findings"]."', ".
                              "'".$post_vars["fec_micro_findings"]."', ".
                              "'".$_SESSION["userid"]."', '$release_flag')";
                if ($result_fecalysis = mysql_query($sql_fecalysis)) {
                    mysql_query("COMMIT;") or die(mysql_error());
                    mysql_query("SET autocommit=1;") or die(mysql_error());
                    header("location: ".$_SERVER["PHP_SELF"]."?page=".$get_vars["page"]."&menu_id=".$get_vars["menu_id"]."&consult_id=".$get_vars["consult_id"]."&module=".$get_vars["module"]."&request_id=".$get_vars["request_id"]."&lab_id=".$get_vars["lab_id"]);
                } else {
                    $sql_update = "update m_consult_lab_fecalysis set ".
                                  "lab_timestamp = sysdate(), ".
                                  "fec_collection_date = '$fec_collection_date', ".
                                  "fec_macro_findings = '".$post_vars["fec_macro_findings"]."', ".
                                  "fec_micro_findings = '".$post_vars["fec_micro_findings"]."', ".
                                  "user_id = '".$_SESSION["userid"]."', ".
                                  "release_flag = '$release_flag' ".
                                  "where request_id = '".$post_vars["request_id"]."'";
                    if ($result_update = mysql_query($sql_update)) {
                        mysql_query("COMMIT;") or die(mysql_error());
                        mysql_query("SET autocommit=1;") or die(mysql_error());
                        //header("location: ".$_SERVER["PHP_SELF"]."?page=".$get_vars["page"]."&menu_id=".$get_vars["menu_id"]."&consult_id=".$get_vars["consult_id"]."&module=".$get_vars["module"]);
                    } else {
                        mysql_query("ROLLBACK;") or die(mysql_error());
                        mysql_query("SET autocommit=1;") or die(mysql_error());
                        header("location: ".$_SERVER["PHP_SELF"]."?page=".$get_vars["page"]."&menu_id=".$get_vars["menu_id"]."&consult_id=".$get_vars["consult_id"]."&module=".$get_vars["module"]);
                    }
                }
                break;
            case "Delete Lab Exam":
                if (module::confirm_delete($menu_id, $post_vars, $get_vars)) {
                    $sql = "delete from m_consult_lab where request_id = '".$post_vars["request_id"]."'";
                    if ($result = mysql_query($sql)) {
                        header("location: ".$_SERVER["PHP_SELF"]."?page=".$get_vars["page"]."&menu_id=".$get_vars["menu_id"]."&consult_id=".$get_vars["consult_id"]."&module=".$get_vars["module"]);
                    }
                } else {
                    if ($post_vars["confirm_delete"]=="No") {
                        header("location: ".$_SERVER["PHP_SELF"]."?page=".$get_vars["page"]."&menu_id=".$get_vars["menu_id"]."&consult_id=".$get_vars["consult_id"]."&module=".$get_vars["module"]);
                    }
                }
                break;
            }
        }
    }

 function load_template() {
        if (func_num_args()) {
            $arg_list = func_get_args();
            $template_key = $arg_list[0];
        }
        $sql = "select template_text from m_template where template_key = '$template_key'";
        if ($result = mysql_query($sql)) {
            if (mysql_num_rows($result)) {
                list($text) = mysql_fetch_array($result);
                return $text;
            }
        }
    }
    
// end of class
}
?>
