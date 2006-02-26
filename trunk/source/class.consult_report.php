<?
class consult_report extends module {

    // Author: Herman Tolentino MD
    // CHITS Project 2004

    function consult_report() {
        //
        // do not forget to update version
        //
        $this->author = 'Herman Tolentino MD';
        $this->version = "0.2-".date("Y-m-d");
        $this->module = "consult_report";
        $this->description = "CHITS Module - Consult Report";
    }

    // --------------- STANDARD MODULE FUNCTIONS ------------------

    function init_deps() {
    //
    // insert dependencies in module_dependencies
    //
        module::set_dep($this->module, "module");
        module::set_dep($this->module, "fpdf");
        module::set_dep($this->module, "healthcenter");
        module::set_dep($this->module, "patient");
        module::set_dep($this->module, "family");
        module::set_dep($this->module, "barangay");
        module::set_dep($this->module, "notes");
        module::set_dep($this->module, "icd10");
        module::set_dep($this->module, "graph");

    }

    function init_lang() {
    //
    // insert necessary language directives
    //
        module::set_lang("FTITLE_CONSULT_REPORTS", "english", "HEALTH CENTER REPORTS", "Y");
        module::set_lang("MENU_TCL", "english", "TARGET CLIENT LIST", "Y");
        module::set_lang("MENU_SUMMARY", "english", "SUMMARY REPORTS", "Y");
        module::set_lang("MENU_GRAPHS", "english", "GRAPHS", "Y");
        module::set_lang("FTITLE_INCLUSIVE_DATES_FORM", "english", "INCLUSIVE DATES FOR THIS REPORT", "Y");
        module::set_lang("LBL_START_DATE", "english", "START DATE", "Y");
        module::set_lang("LBL_END_DATE", "english", "END DATE", "Y");
        module::set_lang("FTITLE_REPORT_DATE_FORM", "english", "SERVICE REPORT FORM", "Y");
        module::set_lang("LBL_REPORT_DATE", "english", "REPORT DATE", "Y");

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
        module::set_menu($this->module, "Consult Reports", "REPORTS", "_consult_report");

        // add more detail
        module::set_detail($this->description, $this->version, $this->author, $this->module);

    }

    function init_sql() {
        if (func_num_args()>0) {
            $arg_list = func_get_args();
        }

        module::execsql("CREATE TABLE `m_consult_report` (".
            "`consult_date` date NOT NULL default '0000-00-00',".
            "`M_less1` int(11) NOT NULL default '0',".
            "`F_less1` int(11) NOT NULL default '0',".
            "`M_1to4` int(11) NOT NULL default '0',".
            "`F_1to4` int(11) NOT NULL default '0',".
            "`M_5to14` int(11) NOT NULL default '0',".
            "`F_5to14` int(11) NOT NULL default '0',".
            "`M_15to49` int(11) NOT NULL default '0',".
            "`F_15to49` int(11) NOT NULL default '0',".
            "`M_50to64` int(11) NOT NULL default '0',".
            "`F_50to64` int(11) NOT NULL default '0',".
            "`M_65plus` int(11) NOT NULL default '0',".
            "`F_65plus` int(11) NOT NULL default '0',".
            "`M_total` int(11) NOT NULL default '0',".
            "`F_total` int(11) NOT NULL default '0', ".
            "PRIMARY KEY  (`consult_date`)".
            ") TYPE=MyISAM; ");

        module::execsql("CREATE TABLE `m_consult_report_dailyservice` (".
            "`patient_id` float NOT NULL default '0',".
            "`patient_name` varchar(100) NOT NULL default '',".
            "`patient_gender` char(1) NOT NULL default '',".
            "`patient_age` varchar(10) NOT NULL default '',".
            "`patient_address` varchar(100) NOT NULL default '',".
            "`patient_bgy` varchar(50) NOT NULL default '0',".
            "`family_id` float NOT NULL default '0',".
            "`notes_cc` varchar(100) NOT NULL default '',".
            "`notes_dx` varchar(100) NOT NULL default '',".
            "`notes_tx` varchar(100) NOT NULL default '',".
            "`service_date` date NOT NULL default '0000-00-00',".
            "PRIMARY KEY  (`patient_id`, `service_date`)".
            ") TYPE=MyISAM; ");

        module::execsql("CREATE TABLE `m_patient_consult_tcl` (".
            "`consult_id` float NOT NULL default '0',".
            "`patient_id` float NOT NULL default '0',".
            "`patient_name` varchar(50) NOT NULL default '',".
            "`consult_date` date NOT NULL default '0000-00-00',".
            "`patient_age` float NOT NULL default '0',".
            "`patient_gender` char(1) NOT NULL default '',".
            "`patient_address` varchar(100) NOT NULL default '',".
            "`barangay_name` varchar(100) NOT NULL default '',".
            "`diagnosis` varchar(255) NOT NULL default '',".
            "`icd10` varchar(100) NOT NULL default '',".
            "PRIMARY KEY  (`consult_id`,`patient_id`),".
            "KEY `key_consult` (`consult_id`),".
            "KEY `key_patient` (`patient_id`),".
            "CONSTRAINT `m_patient_consult_tcl_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `m_patient` (`patient_id`) ON DELETE CASCADE,".
            "CONSTRAINT `m_patient_consult_tcl_ibfk_2` FOREIGN KEY (`consult_id`) REFERENCES `m_consult` (`consult_id`) ON DELETE CASCADE".
            ") TYPE=InnoDB;");

    }

    function drop_tables() {

        module::execsql("DROP TABLE `m_consult_report`;");
        module::execsql("DROP TABLE `m_patient_consult_tcl`;");
        module::execsql("DROP TABLE `m_consult_report_dailyservice`;");

    }


    // --------------- CUSTOM MODULE FUNCTIONS ------------------

    function _consult_report() {
    //
    // main API to reports
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
        if ($exitinfo = $this->missing_dependencies('consult_report')) {
            return print($exitinfo);
        }
        print "<span class='patient'>".FTITLE_CONSULT_REPORTS."</span><br/><br/>";
        $c = new consult_report;
        $g = new graph;
        $c->report_menu($menu_id, $post_vars, $get_vars);
        print "<table><tr valign='top'><td>";
        // column 1
        switch($get_vars["report_menu"]) {
        case "TCL":
            if ($post_vars["submitreport"]) {
                $n->process_tcl_inclusive_dates($menu_id, $post_vars, $get_vars);
            }
            $c->form_tcl_inclusive_dates($menu_id, $post_vars, $get_vars);
            $c->display_tcl_inclusive_dates($menu_id, $post_vars, $get_vars);
            break;
        case "SUMMARY":
            if ($post_vars["submitreport"]) {
                $c->generate_summary($menu_id, $post_vars, $get_vars);
            }
            $c->form_summary_date($menu_id, $post_vars, $get_vars);
            $c->display_summary_reports($menu_id, $post_vars, $get_vars);
            break;
        case "GRAPHS":
            $g->graph_menu($menu_id, $post_vars, $get_vars);
            switch($get_vars["graph"]) {
            case "LINE":
                $get_vars["module"] = $this->module;
                $g->graph_line($menu_id, $post_vars, $get_vars);
                break;
            case "BAR":
                $get_vars["module"] = $this->module;
                $g->graph_bar($menu_id, $post_vars, $get_vars);
                break;
            case "PIE":
                $get_vars["module"] = $this->module;
                $g->graph_pie($menu_id, $post_vars, $get_vars);
                break;
            }
            break;
        }
        print "</td><td>";
        // column 2
        print "<b>CONSULT SUMMARY REPORT NOTES</b><br/>";
        print "<p>The <b>consult summary report</b> gets its contents ".
              "from several modules: <b>patient</b>, <b>notes</b>, <b>ICD10</b>, <b>family</b> ".
              "or <b>clinical reminders</b> and <b>barangay</b>. <font color='red'>Therefore, ".
              "it is very important that data in these modules are completely ".
              "and accurately filled up.</font></p>";
        print "<p>".
              "PATIENT MODULE<br/>".
              "- provides patient name, age and gender<br/><br/>".
              "NOTES MODULE<br/>".
              "- provides complaint list, diagnosis (if ICD10 is not filled up), and treatment plan<br/><br/>".
              "ICD10 MODULE<br/>".
              "- provides diagnosis data<br/><br/>".
              "FAMILY MODULE<br/>".
              "- provides family ID, address and barangay<br/><br/>".
              "CLINICAL REMINDERS MODULE<br/>".
              "- provides address and barangay if family registry contains no corresponding entries<br/>".
              "</p>";
        print "</td></tr></table>";
    }

    function report_menu() {
        if (func_num_args()>0) {
            $arg_list = func_get_args();
            $menu_id = $arg_list[0];
            $post_vars = $arg_list[1];
            $get_vars = $arg_list[2];
            $validuser = $arg_list[3];
            $isadmin = $arg_list[4];
            //print_r($arg_list);
        }
        if (!$get_vars["report_menu"]) {
            header("location: ".$_SERVER["PHP_SELF"]."?page=".$get_vars["page"]."&menu_id=".$get_vars["menu_id"]."&report_menu=TCL");
        }
        print "<table width='600' cellpadding='2' bgcolor='#CCCC99' cellspacing='1' style='border: 2px solid black'><tr align='left'>";
        print "<td><a href='".$_SERVER["PHP_SELF"]."?page=".$get_vars["page"]."&menu_id=".$get_vars["menu_id"]."&report_menu=TCL' class='ptmenu'>".($get_vars["report_menu"]=="TCL"?"<b>".MENU_TCL."</b>":MENU_TCL)."</a></td>";
        print "<td><a href='".$_SERVER["PHP_SELF"]."?page=".$get_vars["page"]."&menu_id=".$get_vars["menu_id"]."&report_menu=SUMMARY' class='ptmenu'>".($get_vars["report_menu"]=="SUMMARY"?"<b>".MENU_SUMMARY."</b>":MENU_SUMMARY)."</a></td>";
        print "<td><a href='".$_SERVER["PHP_SELF"]."?page=".$get_vars["page"]."&menu_id=".$get_vars["menu_id"]."&report_menu=GRAPHS&module=consult_report' class='ptmenu'>".($get_vars["report_menu"]=="GRAPHS"?"<b>".MENU_GRAPHS."</b>":MENU_GRAPHS)."</a></td>";
        print "</tr></table>";
    }

    function generate_summary() {
        if (func_num_args()>0) {
            $arg_list = func_get_args();
            $menu_id = $arg_list[0];
            $post_vars = $arg_list[1];
            $get_vars = $arg_list[2];
            $validuser = $arg_list[3];
            $isadmin = $arg_list[4];
            //print_r($arg_list);
        }
        list($month, $day, $year) = explode("/", $post_vars["report_date"]);
        $report_date = $year."-".str_pad($month, 2, "0", STR_PAD_LEFT)."-".str_pad($day, 2, "0", STR_PAD_LEFT);
        // STEP 1. empty report table for given date
        print $sql_delete = "delete from m_consult_report_dailyservice where service_date = '$report_date'";
        $result_delete = mysql_query($sql_delete);

        // STEP 2. get all consults for specified report date
        // records are unique for patient_id and service_date
        $sql_patient = "select c.patient_id, concat(p.patient_lastname, ', ', p.patient_firstname) patient_name, ".
                    "round((to_days(c.consult_date)-to_days(p.patient_dob))/365,2) patient_age, ".
                    "p.patient_gender ".
                    "from m_consult c, m_patient p ".
                    "where c.patient_id = p.patient_id ".
                    "and to_days(c.consult_date) = to_days('$report_date')";
        if ($result_patient = mysql_query($sql_patient)) {
            if (mysql_num_rows($result_patient)) {
                while ($patient = mysql_fetch_array($result_patient)) {
                    // get family and address
                    if ($family_id = family::get_family_id($patient["patient_id"])) {
                        $patient_address = family::get_family_address($family_id);
                        $barangay_name = family::barangay_name($family_id);
                    } else {
                        $family_id = 0;
                        $patient_address = reminder::get_home_address($patient_id);
                        $barangay_name = reminder::get_barangay($patient_id);
                    }
                    // get chief complaint from notes
                    $complaints = notes::get_complaints($patient["patient_id"], $report_date);
                    // get notes dx list or icd10 list
                    if (!$dx_list = icd10::get_icd10_list($patient["patient_id"], $report_date)) {
                        $dx_list = notes::get_diagnosis_list($patient["patient_id"], $report_date);
                    }
                    // get treatment data from notes
                    $plans = notes::get_plan($patient["patient_id"], $report_date);

                    $sql_insert = "insert into m_consult_report_dailyservice (patient_id, patient_name, patient_gender, ".
                                  "patient_age, patient_address, patient_bgy, family_id, notes_cc, notes_dx, notes_tx, service_date) ".
                                  "values ('".$patient["patient_id"]."', '".$patient["patient_name"]."', ".
                                  "'".$patient["patient_gender"]."', '".$patient["patient_age"]."', ".
                                  "'$patient_address', '$barangay_name', '$family_id', '$complaints', ".
                                  "'$dx_list', '$plans', '$report_date')";
                    $result_insert = mysql_query($sql_insert);
                }
            }
        }
    }

    function display_summary_reports() {
        if (func_num_args()>0) {
            $arg_list = func_get_args();
            $menu_id = $arg_list[0];
            $post_vars = $arg_list[1];
            $get_vars = $arg_list[2];
            $validuser = $arg_list[3];
            $isadmin = $arg_list[4];
            //print_r($arg_list);
        }
        if ($get_vars["service_date"]) {
            $sql = "select service_date, patient_id, family_id, patient_name, patient_gender, patient_age, ".
                   "patient_address, patient_bgy, notes_cc, notes_dx, notes_tx ".
                   "from m_consult_report_dailyservice where service_date = '".$get_vars["report_date"]."'";
            if ($result = mysql_query($sql)) {
                if (mysql_num_rows($result)) {
                    while ($summary = mysql_fetch_array($result)) {

                    }
                }
            }
        } else {
            $sql = "select count(patient_id) records, service_date ".
                   "from m_consult_report_dailyservice ".
                   "group by service_date";
            if ($result = mysql_query($sql)) {
                if (mysql_num_rows($result)) {
                    while ($summary = mysql_fetch_array($result)) {
                        print $summary["service_date"]." (".($summary["records"])." records)<br/>";
                    }
                }
            }
        }
    }

    function display_tcl_inclusive_dates() {
        if (func_num_args()>0) {
            $arg_list = func_get_args();
            $menu_id = $arg_list[0];
            $post_vars = $arg_list[1];
            $get_vars = $arg_list[2];
            $validuser = $arg_list[3];
            $isadmin = $arg_list[4];
            //print_r($arg_list);
        }
        print "<a href='../modules/_uploads/ntp_tcl.pdf' target='_blank'>NTP TCL</a><br/>";
    }

    function form_summary_date() {
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
        print "<form action = '".$_SERVER["SELF"]."?page=".$get_vars["page"]."&menu_id=".$get_vars["menu_id"]."&report_menu=".$get_vars["report_menu"]."' name='form_report_date' method='post'>";
        print "<tr valign='top'><td>";
        print "<input type='hidden' name='patient_id' value='$patient_id'/>";
        print "<b>".FTITLE_REPORT_DATE_FORM."</b><br/><br/>";
        print "</td></tr>";
        print "<tr valign='top'><td>";
        print "<span class='boxtitle'>".LBL_REPORT_DATE."</span><br> ";
        print "<input type='text' size='10' class='textbox' name='report_date' value='' style='border: 1px solid #000000'> ";
        print "<a href=\"javascript:show_calendar4('document.form_report_date.report_date', document.form_report_date.report_date.value);\"><img src='../images/cal.gif' width='16' height='16' border='0' alt='Click Here to Pick up the date'></a><br>";
        print "<small>Click on the calendar icon to select report date. Otherwise use MM/DD/YYYY format.</small><br>";
        print "</td></tr>";
        print "<tr><td>";
        if ($_SESSION["priv_add"]) {
            print "<br><input type='submit' value = 'Generate Daily Report' class='textbox' name='submitreport' style='border: 1px solid #000000'><br>";
        }
        print "</td></tr>";
        print "</form>";
        print "</table><br>";
    }

    function form_tcl_inclusive_dates() {
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
        print "<form action = '".$_SERVER["SELF"]."?page=".$get_vars["page"]."&menu_id=".$get_vars["menu_id"]."&report_menu=".$get_vars["report_menu"]."' name='form_inclusive_dates' method='post'>";
        print "<tr valign='top'><td>";
        print "<input type='hidden' name='patient_id' value='$patient_id'/>";
        print "<b>".FTITLE_INCLUSIVE_DATES_FORM."</b><br/><br/>";
        print "</td></tr>";
        print "<tr valign='top'><td>";
        print "<span class='boxtitle'>".LBL_START_DATE."</span><br> ";
        print "<input type='text' size='10' class='textbox' name='start_date' value='' style='border: 1px solid #000000'> ";
        print "<a href=\"javascript:show_calendar4('document.form_inclusive_dates.start_date', document.form_inclusive_dates.start_date.value);\"><img src='../images/cal.gif' width='16' height='16' border='0' alt='Click Here to Pick up the date'></a><br>";
        print "<small>Click on the calendar icon to select start date. Otherwise use MM/DD/YYYY format.</small><br>";
        print "</td></tr>";
        print "<tr valign='top'><td>";
        print "<span class='boxtitle'>".LBL_END_DATE."</span><br> ";
        print "<input type='text' size='10' class='textbox' name='end_date' value='$thisday' style='border: 1px solid #000000'> ";
        print "<a href=\"javascript:show_calendar4('document.form_inclusive_dates.end_date', document.form_inclusive_dates.end_date.value);\"><img src='../images/cal.gif' width='16' height='16' border='0' alt='Click Here to Pick up the date'></a><br>";
        print "<small>Click on the calendar icon to select end date. Otherwise use MM/DD/YYYY format.</small><br>";
        print "</td></tr>";
        print "<tr><td>";
        if ($_SESSION["priv_add"]) {
            print "<br><input type='submit' value = 'Generate TCL' class='textbox' name='submitreport' style='border: 1px solid #000000'><br>";
        }
        print "</td></tr>";
        print "</form>";
        print "</table><br>";
    }

    function process_tcl_inclusive_dates() {
        if (func_num_args()>0) {
            $arg_list = func_get_args();
            $menu_id = $arg_list[0];
            $post_vars = $arg_list[1];
            $get_vars = $arg_list[2];
            $validuser = $arg_list[3];
            $isadmin = $arg_list[4];
            print_r($arg_list);
        }
        // loop through m_patient_ntp
        if ($post_vars["start_date"] && $post_vars["end_date"]) {
        } else {
            print $sql = "select n.ntp_timestamp, n.ntp_id ntp_id, p.patient_id, ".
                   "concat(p.patient_lastname, ', ', p.patient_firstname) patient_name, ".
                   "round((to_days(now())-to_days(p.patient_dob))/365 , 1) patient_age, p.patient_gender, n.tb_class, n.patient_type_id, ".
                   "n.treatment_category_id, n.outcome_id, n.tb_class, n.treatment_partner_id ".
                   "from m_patient_ntp n, m_patient p ".
                   "where n.patient_id = p.patient_id";
        }
        if ($result = mysql_query($sql)) {
            if (mysql_num_rows($result)) {
                while ($ntp = mysql_fetch_array($result)) {
                    print_r($ntp);
                    // retrieve family address
                    $family_id = family::get_family_id($ntp["patient_id"]);
                    print $patient_address = family::show_address($family_id);
                    // retrieve sputum exams
                    $sputum_beforetx = sputum::get_sputum_results($ntp["ntp_id"], "DX");
                    $sputum_eo2 = sputum::get_sputum_results($ntp["ntp_id"], "EO2");
                    $sputum_eo3 = sputum::get_sputum_results($ntp["ntp_id"], "EO3");
                    $sputum_eo4 = sputum::get_sputum_results($ntp["ntp_id"], "EO4");
                    $sputum_eo5 = sputum::get_sputum_results($ntp["ntp_id"], "EO5");
                    $sputum_7m = sputum::get_sputum_results($ntp["ntp_id"], "7M");
                    $sql_insert = "insert into m_patient_ntp_tcl (ntp_id, ".
                                  "ntp_timestamp, patient_id, patient_name, ".
                                  "patient_age, patient_gender, patient_address, ".
                                  "facility_code, tb_class, patient_type, ".
                                  "treatment_category, sputum_beforetx_result, ".
                                  "sputum_beforetx_date, sputum_eo2_result, ".
                                  "sputum_eo2_date, sputum_eo3_result, sputum_eo3_date, ".
                                  "sputum_eo4_result, sputum_eo4_date, sputum_eo5_result, ".
                                  "sputum_eo5_date, sputum_7m_result, sputum_7m_date, ".
                                  "treatment_outcome, treatment_partner, remarks) ".
                                  "values ('".$ntp["ntp_id"]."', '".$ntp["ntp_timestamp"]."', ".
                                  "'".$ntp["patient_id"]."', '".$ntp["patient_name"]."', ".
                                  "'".$ntp["patient_age"]."', '".$ntp["patient_gender"]."', ".
                                  "'$patient_address', '".$_SESSION["datanode"]["code"]."', ".
                                  "'".$ntp["tb_class"]."','".$ntp["patient_type_id"]."', ".
                                  "'".$ntp["treatment_category_id"]."', '".$sputum_beforetx["lab_diagnosis"]."', ".
                                  "'".$sputum_beforetx["lab_timestamp"]."', '".$sputum_eo2["lab_diagnosis"]."', ".
                                  "'".$sputum_eo2["lab_timestamp"]."', '".$sputum_eo3["lab_diagnosis"]."', ".
                                  "'".$sputum_eo3["lab_timestamp"]."', '".$sputum_eo4["lab_diagnosis"]."', ".
                                  "'".$sputum_eo4["lab_timestamp"]."', '".$sputum_eo5["lab_diagnosis"]."', ".
                                  "'".$sputum_eo5["lab_timestamp"]."', '".$sputum_7m["lab_diagnosis"]."', ".
                                  "'".$sputum_7m["lab_timestamp"]."', '".$ntp["outcome_id"]."', ".
                                  "'".$ntp["treatment_partner_id"]."','')";
                    if ($result_insert = mysql_query($sql_insert)) {
                    } else {
                        $sql_update = "update m_patient_ntp_tcl set ".
                                      "sputum_beforetx_result = '".$sputum_beforetx["lab_diagnosis"]."', ".
                                      "sputum_beforetx_date = '".$sputum_beforetx["lab_timestamp"]."',".
                                      "sputum_eo2_result = '".$sputum_eo2["lab_diagnosis"]."', ".
                                      "sputum_eo2_date = '".$sputum_eo2["lab_timestamp"]."', ".
                                      "sputum_eo3_result = '".$sputum_eo3["lab_diagnosis"]."', ".
                                      "sputum_eo3_date = '".$sputum_eo3["lab_timestamp"]."', ".
                                      "sputum_eo4_result = '".$sputum_eo4["lab_diagnosis"]."', ".
                                      "sputum_eo4_date = '".$sputum_eo4["lab_timestamp"]."', ".
                                      "sputum_eo5_result = '".$sputum_eo5["lab_diagnosis"]."', ".
                                      "sputum_eo5_date = '".$sputum_eo5["lab_timestamp"]."', ".
                                      "sputum_7m_result = '".$sputum_7m["lab_diagnosis"]."', ".
                                      "sputum_7m_date = '".$sputum_7m["lab_timestamp"]."' ".
                                      "where ntp_id = '".$ntp["ntp_id"]."'";
                        $result_update = mysql_query($sql_update) or die(mysql_error());
                    }
                } // while
                $sql = "select date_format(ntp_timestamp, '%Y-%m-%d') 'REG DATE', ntp_id 'ID', patient_name 'NAME', ".
                       "concat(patient_age,'/',patient_gender) 'AGE/SEX', patient_address 'ADDRESS', ".
                       "facility_code 'RHU/BHS', tb_class 'TB CLASS', patient_type 'PT TYPE', treatment_category 'TX CAT', ".
                       "if(sputum_beforetx_result<>'', concat(sputum_beforetx_result,': ',sputum_beforetx_date),'NA') 'DX', ".
                       "if(sputum_eo2_result<>'', concat(sputum_eo2_result,': ',sputum_eo2_date),'NA') 'EO Mo2', ".
                       "if(sputum_eo3_result<>'', concat(sputum_eo3_result,': ',sputum_eo3_date), 'NA') 'EO Mo3', ".
                       "if(sputum_eo4_result<>'', concat(sputum_eo4_result,': ',sputum_eo4_date), 'NA') 'EO Mo4', ".
                       "if(sputum_eo5_result<>'', concat(sputum_eo5_result,': ',sputum_eo5_date), 'NA') 'EO Mo5', ".
                       "if(sputum_7m_result<>'', concat(sputum_7m_result,': ',sputum_7m_date),'NA') '>7Mos', ".
                       "treatment_outcome 'OUTCOME', treatment_partner 'PARTNER'".
                       "from m_patient_ntp_tcl order by ntp_timestamp";
                $pdf = new PDF('L','pt','A3');
                $pdf->SetFont('Arial','',10);
                $pdf->AliasNbPages();
                $pdf->connect('localhost','root','kambing','game');
                $attr=array('titleFontSize'=>14,'titleText'=>'NTP TB REGISTER');
                $pdf->mysql_report($sql,false,$attr, "../modules/_uploads/ntp_tcl.pdf");
                header("location: ".$_SERVER["PHP_SELF"]."?page=".$get_vars["page"]."&menu_id=".$get_vars["menu_id"]."&report_menu=TCL");
            }
        }
    }


// end of class
}
?>
