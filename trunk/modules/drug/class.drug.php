<?
class drug extends module {

    // Author: Herman Tolentino MD
    // CHITS Project 2004

    function drug() {
        //
        // do not forget to update version
        //
        $this->author = 'Herman Tolentino MD';
        $this->version = "0.2-".date("Y-m-d");
        $this->module = "drug";
        $this->description = "CHITS Module - Drug Inventory";
        // 0.3 added drug supply intake monitoring

    }

    // --------------- STANDARD MODULE FUNCTIONS ------------------

    function init_deps() {
    //
    // insert dependencies in module_dependencies
    //
        module::set_dep($this->module, "module");
        module::set_dep($this->module, "healthcenter");
        module::set_dep($this->module, "patient");
    }

    function init_lang() {
    //
    // insert necessary language directives
    //
        module::set_lang("FTITLE_EDUCATION_FORM", "english", "EDUCATION LEVEL FORM", "Y");
        module::set_lang("LBL_EDUC_ID", "english", "EDUCATION LEVEL ID", "Y");
        module::set_lang("LBL_EDUC_NAME", "english", "EDUCATION LEVEL NAME", "Y");
        module::set_lang("FTITLE_EDUCATION_LEVEL__LIST", "english", "EDUCATION LEVEL LIST", "Y");
        module::set_lang("THEAD_ID", "english", "ID", "Y");
        module::set_lang("THEAD_NAME", "english", "NAME", "Y");
        module::set_lang("FTITLE_DRUGCAT_LIST", "english", "DRUG CATEGORY LIST", "Y");
        module::set_lang("FTITLE_DRUGCAT_FORM", "english", "DRUG CATEGORY FORM", "Y");
        module::set_lang("LBL_DRUGCAT_ID", "english", "DRUG CATEGORY ID", "Y");
        module::set_lang("LBL_DRUGCAT_NAME", "english", "DRUG CATEGORY NAME", "Y");
        module::set_lang("FTITLE_DRUGFORM_LIST", "english", "DRUG FORMULATION LIST", "Y");
        module::set_lang("FTITLE_DRUGFORM_FORM", "english", "DRUG FORMULATION FORM", "Y");
        module::set_lang("LBL_DRUGFORM_ID", "english", "DRUG FORMULATION ID", "Y");
        module::set_lang("LBL_DRUGFORM_NAME", "english", "DRUG FORMULATION NAME", "Y");
        module::set_lang("FTITLE_DRUGPREP_LIST", "english", "DRUG PREPARATION LIST", "Y");
        module::set_lang("FTITLE_DRUGPREP_FORM", "english", "DRUG PREPARATION FORM", "Y");
        module::set_lang("LBL_DRUGPREP_ID", "english", "DRUG PREPARATION ID", "Y");
        module::set_lang("LBL_DRUGPREP_NAME", "english", "DRUG PREPARATION NAME", "Y");
        module::set_lang("FTITLE_DRUGMAN_LIST", "english", "DRUG MANUFACTURER LIST", "Y");
        module::set_lang("FTITLE_DRUGMAN_FORM", "english", "DRUG MANUFACTURER FORM", "Y");
        module::set_lang("LBL_DRUGMAN_ID", "english", "DRUG MANUFACTURER ID", "Y");
        module::set_lang("LBL_DRUGMAN_NAME", "english", "DRUG MANUFACTURER NAME", "Y");
        module::set_lang("FTITLE_DRUGSOURCE_LIST", "english", "DRUG SOURCE LIST", "Y");
        module::set_lang("FTITLE_DRUGSOURCE_FORM", "english", "DRUG SOURCE FORM", "Y");
        module::set_lang("LBL_DRUGSOURCE_ID", "english", "DRUG SOURCE ID", "Y");
        module::set_lang("LBL_DRUGSOURCE_NAME", "english", "DRUG SOURCE NAME", "Y");
        module::set_lang("FTITLE_DRUG_FORM", "english", "DRUG FORM", "Y");
        module::set_lang("LBL_DRUG_CATEGORY", "english", "DRUG CATEGORY", "Y");
        module::set_lang("LBL_DRUG_PREPARATION", "english", "DRUG PREPARATION", "Y");
        module::set_lang("LBL_DRUG_FORMULATION", "english", "DRUG FORMULATION", "Y");
        module::set_lang("LBL_DRUG_MANUFACTURER", "english", "DRUG MANUFACTURER", "Y");
        module::set_lang("LBL_DRUG_NAME", "english", "DRUG NAME", "Y");
        module::set_lang("LBL_ADMIN_DESC", "english", "ADMINISTRATION HOWTO", "Y");
        module::set_lang("FTITLE_DRUG_LIST", "english", "DRUG LIST", "Y");
        module::set_lang("THEAD_NAME", "english", "NAME", "Y");
        module::set_lang("THEAD_PREP", "english", "PREP", "Y");
        module::set_lang("THEAD_FORM", "english", "FORM", "Y");
        module::set_lang("THEAD_SOURCE", "english", "SOURCE", "Y");
        module::set_lang("THEAD_MAN", "english", "MAKER", "Y");
        module::set_lang("LBL_DRUG_SOURCE", "english", "SOURCE", "Y");
        module::set_lang("MENU_DRUGINV_STATS", "english", "INVENTORY STATS", "Y");
        module::set_lang("MENU_DRUGINV_ADD", "english", "ADD STOCK", "Y");
        module::set_lang("INSTR_DRUG_LIST", "english", "CLICK ON DRUG NAME", "Y");

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
        module::set_menu($this->module, "Drug Category", "LIBRARIES", "_drug_cat");
        module::set_menu($this->module, "Drug Formulation", "LIBRARIES", "_drug_formulation");
        module::set_menu($this->module, "Drug Preparation", "LIBRARIES", "_drug_preparation");
        module::set_menu($this->module, "Drug Packaging", "LIBRARIES", "_drug_packaging");
        module::set_menu($this->module, "Drug Manufacturer", "LIBRARIES", "_drug_manufacturer");
        module::set_menu($this->module, "Drug Source", "LIBRARIES", "_drug_source");
        module::set_menu($this->module, "Drugs", "LIBRARIES", "_drugs");
        module::set_menu($this->module, "Drug Inventory", "SUPPORT", "_drug_inventory");

        // add more detail
        module::set_detail($this->description, $this->version, $this->author, $this->module);

    }

    function init_sql() {
        if (func_num_args()>0) {
            $arg_list = func_get_args();
        }

        // inventory
        module::execsql("CREATE TABLE `m_lib_drug_inventory` (".
            "`transaction_id` float NOT NULL auto_increment,".
            "`drug_id` float NOT NULL,".
            "`user_id` float NOT NULL default '0',".
            "`transaction_timestamp` timestamp(14) NOT NULL,".
            "`transaction_date` datetime NOT NULL default '0000-00-00 00:00:00',".
            "`package_id` int default '0',".
            "`drug_quantity` float NOT NULL default '0',".
            "PRIMARY KEY  (`transaction_id`),".
            "KEY (package_id),".
            "CONSTRAINT `m_lib_drug_packaging_ibfk_1` FOREIGN KEY (`package_id`) REFERENCES `m_lib_drug_packaging` (`package_id`) ON DELETE RESTRICT".
            ") TYPE=InnoDB; ");
            
        module::execsql("CREATE TABLE `m_lib_drug_packaging` (".
            "`package_id` int NOT NULL auto_increment,".
            "`package_name` varchar(50) NOT NULL default '',".
            "`package_quantity` int NOT NULL default '0',".
            "PRIMARY KEY  (`package_id`)".
            ") TYPE=InnoDB; ");
            
        // load initial data
        module::execsql("INSERT INTO m_lib_drug_packaging VALUES (1, 'Box 100s', 100);");
        module::execsql("INSERT INTO m_lib_drug_packaging VALUES (2, 'Box 300s', 200);");
        module::execsql("INSERT INTO m_lib_drug_packaging VALUES (3, 'Box 300s', 300);");
        module::execsql("INSERT INTO m_lib_drug_packaging VALUES (4, 'Box 400s', 400);");
        module::execsql("INSERT INTO m_lib_drug_packaging VALUES (5, 'Box 500s', 500);");
        module::execsql("INSERT INTO m_lib_drug_packaging VALUES (6, 'Box 1000s', 1000);");
        
        module::execsql("CREATE TABLE `m_lib_drug_category` (".
            "`cat_id` varchar(10) NOT NULL default '',".
            "`cat_name` varchar(50) NOT NULL default '',".
            "PRIMARY KEY  (`cat_id`)".
            ") TYPE=InnoDB; ");

        // load initial data
        module::execsql("INSERT INTO m_lib_drug_category VALUES ('ABIO','Antibiotics');");
        module::execsql("INSERT INTO m_lib_drug_category VALUES ('AHELM','Anti-helminthic');");
        module::execsql("INSERT INTO m_lib_drug_category VALUES ('AHIST','Antihistamines');");
        module::execsql("INSERT INTO m_lib_drug_category VALUES ('AHPN','Anti-hypertensives');");
        module::execsql("INSERT INTO m_lib_drug_category VALUES ('ANALG','Analgesic/Anti-inflammatory');");
        module::execsql("INSERT INTO m_lib_drug_category VALUES ('ANTITB','Antituberculous Agents');");
        module::execsql("INSERT INTO m_lib_drug_category VALUES ('APYR','Antipyretic');");
        module::execsql("INSERT INTO m_lib_drug_category VALUES ('ASPASM','Antispasmodic Agents');");
        module::execsql("INSERT INTO m_lib_drug_category VALUES ('ASTHMA','Anti-asthmatics');");
        module::execsql("INSERT INTO m_lib_drug_category VALUES ('CONTR','Contraceptive Agents');");
        module::execsql("INSERT INTO m_lib_drug_category VALUES ('EYE','Opthalmic Solutions/Drops');");
        module::execsql("INSERT INTO m_lib_drug_category VALUES ('HYDR','Rehydration Solutions');");
        module::execsql("INSERT INTO m_lib_drug_category VALUES ('VIT','Vitamins');");

        module::execsql("CREATE TABLE `m_lib_drug_formulation` (".
            "`form_id` int(11) NOT NULL auto_increment,".
            "`form_name` varchar(100) NOT NULL default '',".
            "PRIMARY KEY  (`form_id`)".
            ") TYPE=InnoDB; ");

        // load initial data
        module::execsql("INSERT INTO m_lib_drug_formulation VALUES (1,'125mg/5ml x 100ml');");
        module::execsql("INSERT INTO m_lib_drug_formulation VALUES (2,'250mg/5ml x 100ml');");
        module::execsql("INSERT INTO m_lib_drug_formulation VALUES (3,'200mg + 40mg / 5ml x 100ml');");
        module::execsql("INSERT INTO m_lib_drug_formulation VALUES (4,'100mg/ml x 30ml');");
        module::execsql("INSERT INTO m_lib_drug_formulation VALUES (5,'100mg/ml x 60ml');");
        module::execsql("INSERT INTO m_lib_drug_formulation VALUES (6,'100mg/ml x 10ml');");
        module::execsql("INSERT INTO m_lib_drug_formulation VALUES (7,'500mg/tab');");
        module::execsql("INSERT INTO m_lib_drug_formulation VALUES (8,'500mg/cap');");
        module::execsql("INSERT INTO m_lib_drug_formulation VALUES (9,'100,000IU/cap');");
        module::execsql("INSERT INTO m_lib_drug_formulation VALUES (10,'200,000IU/cap');");
        module::execsql("INSERT INTO m_lib_drug_formulation VALUES (11,'800mg + 160mg / tab');");
        module::execsql("INSERT INTO m_lib_drug_formulation VALUES (12,'400mg + 80mg / tab');");
        module::execsql("INSERT INTO m_lib_drug_formulation VALUES (13,'2mg/5ml x 60ml');");
        module::execsql("INSERT INTO m_lib_drug_formulation VALUES (14,'400mg/tab');");
        module::execsql("INSERT INTO m_lib_drug_formulation VALUES (15,'60mg/tab');");
        module::execsql("INSERT INTO m_lib_drug_formulation VALUES (16,'2mg/tab');");
        module::execsql("INSERT INTO m_lib_drug_formulation VALUES (17,'27.9g/sachet (see sachet for details)');");
        module::execsql("INSERT INTO m_lib_drug_formulation VALUES (18,'10,000IU/cap');");
        module::execsql("INSERT INTO m_lib_drug_formulation VALUES (19,'150mg/ml x 1 vial');");
        module::execsql("INSERT INTO m_lib_drug_formulation VALUES (20,'0.3mg norgestrel + 0.03mg ethinyl estradiol/tab x 21 tabs');");
        module::execsql("INSERT INTO m_lib_drug_formulation VALUES (21,'Type 1, R450mg x 7 caps + I300mg x 7 tabs + P500mg x 14 tabs / blister pack');");
        module::execsql("INSERT INTO m_lib_drug_formulation VALUES (22,'Type 2, R450mg x 7 caps + I300mg x 7 tabs / blister pack');");
        module::execsql("INSERT INTO m_lib_drug_formulation VALUES (23,'1gm/vial');");
        module::execsql("INSERT INTO m_lib_drug_formulation VALUES (24,'200mg/5ml x 60ml');");

        module::execsql("CREATE TABLE `m_lib_drug_manufacturer` (".
            "`manufacturer_id` varchar(10) NOT NULL default '',".
            "`manufacturer_name` varchar(50) NOT NULL default '',".
            "PRIMARY KEY  (`manufacturer_id`)".
            ") TYPE=InnoDB;");

        // load initial data
        module::execsql("INSERT INTO m_lib_drug_manufacturer VALUES ('UNK','Unknown');");
        module::execsql("INSERT INTO m_lib_drug_manufacturer VALUES ('UNILABG','Unilab Generics');");
        
        module::execsql("CREATE TABLE `m_lib_drug_preparation` (".
            "`prep_id` varchar(10) NOT NULL default '',".
            "`prep_name` varchar(50) NOT NULL default '',".
            "PRIMARY KEY  (`prep_id`)".
            ") TYPE=MyISAM;");

        // load initial data
        module::execsql("INSERT INTO m_lib_drug_preparation VALUES ('SUSP','Suspension');");
        module::execsql("INSERT INTO m_lib_drug_preparation VALUES ('TAB','Tablet');");
        module::execsql("INSERT INTO m_lib_drug_preparation VALUES ('CAP','Capsule');");
        module::execsql("INSERT INTO m_lib_drug_preparation VALUES ('BPACK','Blister pack');");
        module::execsql("INSERT INTO m_lib_drug_preparation VALUES ('SACH','Sachet');");
        module::execsql("INSERT INTO m_lib_drug_preparation VALUES ('VIAL','Vial');");
        module::execsql("INSERT INTO m_lib_drug_preparation VALUES ('NEB','Nebule/Respule');");

        module::execsql("CREATE TABLE `m_lib_drug_source` (".
            "`source_id` varchar(10) NOT NULL default '',".
            "`source_name` varchar(40) NOT NULL default '',".
            "PRIMARY KEY  (`source_id`)".
            ") TYPE=InnoDB; ");

        // load initial data

        module::execsql("INSERT INTO m_lib_drug_source VALUES ('CDS','DOH');");
        module::execsql("INSERT INTO m_lib_drug_source VALUES ('LGU','LGU');");

        module::execsql("CREATE TABLE `m_lib_drugs` (".
            "`drug_id` float NOT NULL auto_increment,".
            "`drug_cat` varchar(10) NOT NULL default '',".
            "`drug_name` varchar(50) NOT NULL default '',".
            "`drug_preparation` varchar(10) NOT NULL default '',".
            "`drug_formulation` varchar(10) NOT NULL default '',".
            "`manufacturer_id` varchar(10) NOT NULL default '',".
            "`drug_source` varchar(10) NOT NULL default '',".
            "`admin_desc` text, ".
            "PRIMARY KEY  (`drug_id`)".
            ") TYPE=InnoDB;");

        module::execsql("CREATE TABLE `m_consult_drug_dispensing` (".
            "`consult_id` float NOT NULL default '0',".
            "`patient_id` float NOT NULL default '0',".
            "`drug_id` float NOT NULL default '0',".
            "`drug_quantity` int(11) NOT NULL default '0',".
            "`user_id` int(11) NOT NULL default '0',".
            "`dispense_date` datetime NOT NULL default '0000-00-00 00:00:00',".
            "`dispense_timestamp` timestamp(14) NOT NULL,".
            "PRIMARY KEY  (`consult_id`,`drug_id`),".
            "KEY `key_consult` (`consult_id`),".
            "KEY `key_patient` (`patient_id`),".
            "KEY `key_drug` (`drug_id`),".
            "CONSTRAINT `m_consult_drug_dispensing_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `m_patient` (`patient_id`) ON DELETE CASCADE,".
            "CONSTRAINT `m_consult_drug_dispensing_ibfk_2` FOREIGN KEY (`consult_id`) REFERENCES `m_consult` (`consult_id`) ON DELETE CASCADE,".
            "CONSTRAINT `m_consult_drug_dispensing_ibfk_3` FOREIGN KEY (`drug_id`) REFERENCES `m_lib_drugs` (`drug_id`) ON DELETE CASCADE".
            ") TYPE=InnoDB;");
            
    }

    function drop_tables() {

        module::execsql("DROP TABLE `m_lib_drug_category`;");
        module::execsql("DROP TABLE `m_lib_drug_formulation`;");
        module::execsql("DROP TABLE `m_lib_drug_manufacturer`;");
        module::execsql("DROP TABLE `m_lib_drug_preparation`;");
        module::execsql("DROP TABLE `m_lib_drug_source`;");
        module::execsql("DROP TABLE `m_lib_drugs`;");
        module::execsql("DROP TABLE `m_consult_drug_dispensing`;");
    }


    // --------------- CUSTOM MODULE FUNCTIONS ------------------

    function _drug_inventory() {
    //
    // main submodule for drug inventory
    //
        // always check dependencies
        if ($exitinfo = $this->missing_dependencies('drug')) {
            return print($exitinfo);
        }
        if (func_num_args()>0) {
            $arg_list = func_get_args();
            $menu_id = $arg_list[0];
            $post_vars = $arg_list[1];
            $get_vars = $arg_list[2];
            $validuser = $arg_list[3];
            $isadmin = $arg_list[4];
            //print_r($arg_list);
        }
        $d = new drug;
        print "<span class='library'>DRUG INVENTORY</span><br/><br/>";
        $d->drug_inventory_menu($menu_id, $post_vars, $get_vars, $validuser, $isadmin);
        if ($get_vars["drug_menu"] && $get_vars["drug_id"]) {
            // if drug is selected
            switch ($get_vars["drug_menu"]) {
            case "ADD":
                // display stock add form
                break;
            case "STATS":
            default:
            }
        }
        $d->display_drug_inventory($menu_id, $post_vars, $get_vars, $validuser, $isadmin);

    }
    
    function drug_inventory_menu() {
        if (func_num_args()>0) {
            $arg_list = func_get_args();
            $menu_id = $arg_list[0];
            $post_vars = $arg_list[1];
            $get_vars = $arg_list[2];
            $validuser = $arg_list[3];
            $isadmin = $arg_list[4];
            //print_r($arg_list);
        }
        if (!$get_vars["drug_menu"]) {
            header("location: ".$_SERVER["PHP_SELF"]."?page=".$get_vars["page"]."&menu_id=".$get_vars["menu_id"]."&drug_menu=STATS");
        }
        print "<table width='600' cellpadding='2' bgcolor='#CCCC99' cellspacing='1' style='border: 2px solid black'><tr align='left'><td align='left'>";
        print "<a href='".$_SERVER["PHP_SELF"]."?page=".$get_vars["page"]."&menu_id=".$get_vars["menu_id"]."&drug_menu=STATS' class='ptmenu'>".($get_vars["drug_menu"]=="STATS"?"<b>".MENU_DRUGINV_STATS."</b>":MENU_DRUGINV_STATS)."</a> | ";
        print "<a href='".$_SERVER["PHP_SELF"]."?page=".$get_vars["page"]."&menu_id=".$get_vars["menu_id"]."&drug_menu=ADD' class='ptmenu'>".($get_vars["drug_menu"]=="ADD"?"<b>".MENU_DRUGINV_ADD."</b>":MENU_DRUGINV_ADD)."</a>";
        print "</td></tr></table>";
        print "<br/>";
    }
    
    function display_drug_inventory() {
        if (func_num_args()) {
            $arg_list = func_get_args();
            $menu_id = $arg_list[0];
            $post_vars = $arg_list[1];
            $get_vars = $arg_list[2];
            $validuser = $arg_list[3];
            $isadmin = $arg_list[4];
        }
        print "<table width='550' cellspacing='0' cellpadding='2'>";
        print "<tr valign='top'><td colspan='3'>";
        print "<span class='boxtext'>".INSTR_DRUG_LIST."</span><br>";
        print "</td></tr>";
        print "<tr valign='top' bgcolor='#CCCCCC'><td><b>ID</b></td>".
              "<td><b>".THEAD_NAME."</b></td>".
              "<td><b>".THEAD_PREP."</b></td>".
              "<td><b>".THEAD_FORM."</b></td>".
              "<td><b>".THEAD_SOURCE."</b></td>".
              "<td><b>".THEAD_MAN."</b></td>".
              "</tr>";
        $sql = "select drug_id, drug_name, drug_cat, drug_preparation, drug_formulation, ".
               "manufacturer_id, drug_source, admin_desc ".
               "from m_lib_drugs order by drug_cat, drug_name";
        if ($result = mysql_query($sql)) {
            if (mysql_num_rows($result)) {
                while (list($id, $name, $cat, $prep, $form, $man, $src) = mysql_fetch_array($result)) {
                    if ($prev_cat<>$cat) {
                        print "<tr valign='top' bgcolor='#FFCC00'><td colspan='6'><b>".strtoupper(drug::get_category_name($cat))."</b></td></tr>";
                    }
                    print "<tr valign='top' bgcolor='white'>";
                    print "<td>$id</td><td><a href='".$_SERVER["SELF"]."?page=LIBRARIES&menu_id=$menu_id&drug_menu=".$get_vars["drug_menu"]."&drug_id=$id'>$name</a></td>";
                    print "<td>".$prep."</td>";
                    print "<td>".drug::get_formulation_name($form)."</td>";
                    print "<td>".$src."</td>";
                    print "<td>".$man."</td>";
                    print "</tr>";
                    $prev_cat = $cat;
                }
            } else {
                print "<tr><td colspan='6'><font color='red'>No drugs in database.</font></td></tr>";
            }
        }
        print "</table><br>";
    }
    
    function _consult_drug() {
    //
    // main submodule for consult drug
    // left panel
    //
        // always check dependencies
        if ($exitinfo = $this->missing_dependencies('drug')) {
            return print($exitinfo);
        }
        if (func_num_args()>0) {
            $arg_list = func_get_args();
            $menu_id = $arg_list[0];
            $post_vars = $arg_list[1];
            $get_vars = $arg_list[2];
            $validuser = $arg_list[3];
            $isadmin = $arg_list[4];
            //print_r($arg_list);
        }
        $d = new drug;
        $d->drug_menu($menu_id, $post_vars, $get_vars, $validuser, $isadmin);
        if ($post_vars["submitdrug"]) {
            $d->process_drug($menu_id, $post_vars, $get_vars);
        }

    }

    function drug_menu() {
        if (func_num_args()>0) {
            $arg_list = func_get_args();
            $menu_id = $arg_list[0];
            $post_vars = $arg_list[1];
            $get_vars = $arg_list[2];
            $validuser = $arg_list[3];
            $isadmin = $arg_list[4];
            //print_r($arg_list);
        }
        if (!isset($get_vars["drug"])) {
            header("location: ".$_SERVER["PHP_SELF"]."?page=".$get_vars["page"]."&menu_id=".$get_vars["menu_id"]."&consult_id=".$get_vars["consult_id"]."&ptmenu=".$get_vars["ptmenu"]."&module=".$get_vars["module"]."&drug=DISP".($get_vars["drug_id"]?"&drug_id=".$get_vars["drug_id"]:""));
        }
        print "<table cellpadding='1' cellspacing='1' width='300' bgcolor='#9999FF' style='border: 1px solid black'><tr valign='top'><td nowrap>";
        print "<a href='".$_SERVER["PHP_SELF"]."?page=".$get_vars["page"]."&menu_id=".$get_vars["menu_id"]."&consult_id=".$get_vars["consult_id"]."&ptmenu=DRUGS&module=drug&drug=DISP".($get_vars["drug_id"]?"&drug_id=".$get_vars["drug_id"]:"")."' class='groupmenu'>".strtoupper(($get_vars["drug"]=="DISP"?"<b>DISPENSING</b>":"DISPENSING"))."</a>";
        if ($get_vars["drug_id"]) {
        }
        print "</td></tr></table><br/>";
    }

    function _details_drug() {
    //
    // main submodule for consult drug
    // right panel
    //
        // always check dependencies
        if ($exitinfo = $this->missing_dependencies('drug')) {
            return print($exitinfo);
        }
        if (func_num_args()>0) {
            $arg_list = func_get_args();
            $menu_id = $arg_list[0];
            $post_vars = $arg_list[1];
            $get_vars = $arg_list[2];
            $validuser = $arg_list[3];
            $isadmin = $arg_list[4];
            //print_r($arg_list);
        }
    }

    // ----------------- LIBRARY METHODS --------------------

    function _drug_cat() {
    //
    // main method for drug category
    // calls form_drugcat, process_drugcat, display_drugcat
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
        if ($exitinfo = $this->missing_dependencies('drug')) {
            return print($exitinfo);
        }

        if ($post_vars["submitcat"]) {
            $this->process_drugcat($menu_id, $post_vars, $get_vars);
        }
        $this->display_drugcat($menu_id, $post_vars, $get_vars);
        $this->form_drugcat($menu_id, $post_vars, $get_vars);
    }

    function show_drugcat() {
        if (func_num_args()) {
            $arg_list = func_get_args();
            $cat_id = $arg_list[0];
        }
        $sql = "select cat_id, cat_name from m_lib_drug_category order by cat_name";
        if ($result = mysql_query($sql)) {
            if (mysql_num_rows($result)) {
                $retval .= "<select name='drugcat' class='textbox'>";
                $retval .= "<option value=''>Select Category</option>";
                while (list($id, $name) = mysql_fetch_array($result)) {
                    $retval .= "<option value='$id' ".($cat_id==$id?"selected":"").">$name</option>";
                }
                $retval .= "</select>";
                return $retval;
            } else {
                print "<font color='red'>No drug categories in database.</font>";
            }
        }
    }
    
    function get_category_name() {
        if (func_num_args()) {
            $arg_list = func_get_args();
            $cat_id = $arg_list[0];
        }
        $sql = "select cat_name from m_lib_drug_category where cat_id = '$cat_id'";
        if ($result = mysql_query($sql)) {
            if (mysql_num_rows($result)) {
                if (list($name) = mysql_fetch_array($result)) {
                    return $name;
                } else {
                    return "noname";
                }
            }
        }
    }
    
    function display_drugcat() {
        if (func_num_args()) {
            $arg_list = func_get_args();
            $menu_id = $arg_list[0];
            $post_vars = $arg_list[1];
            $get_vars = $arg_list[2];
            $validuser = $arg_list[3];
            $isadmin = $arg_list[4];
        }
        print "<table width='400'>";
        print "<tr valign='top'><td colspan='3'>";
        print "<span class='library'>".FTITLE_DRUGCAT_LIST."</span><br>";
        print "</td></tr>";
        print "<tr valign='top'><td><b>ID</b></td><td><b>".THEAD_NAME."</b></td></tr>";
        $sql = "select cat_id, cat_name from m_lib_drug_category order by cat_name";
        if ($result = mysql_query($sql)) {
            if (mysql_num_rows($result)) {
                while (list($id, $name) = mysql_fetch_array($result)) {
                    print "<tr valign='top'><td>$id</td><td><a href='".$_SERVER["SELF"]."?page=LIBRARIES&menu_id=$menu_id&drugcat_id=$id'>$name</a></td></tr>";
                }
            }
        }
        print "</table><br>";
    }

    function process_drugcat() {
        if (func_num_args()>0) {
            $arg_list = func_get_args();
            $menu_id = $arg_list[0];
            $post_vars = $arg_list[1];
            $get_vars = $arg_list[2];
            $validuser = $arg_list[3];
            $isadmin = $arg_list[4];
            //print_r($arg_list);
        }
        if ($post_vars["submitcat"]) {
            if ($post_vars["cat_id"] && $post_vars["cat_name"]) {
                switch($post_vars["submitcat"]) {
                case "Add Category":
                    $sql = "insert into m_lib_drug_category (cat_id, cat_name) ".
                           "values ('".strtoupper($post_vars["cat_id"])."', '".ucwords($post_vars["cat_name"])."')";
                    if ($result = mysql_query($sql)) {
                        header("location: ".$_SERVER["PHP_SELF"]."?page=".$get_vars["page"]."&menu_id=".$get_vars["menu_id"]);
                    }
                    break;
                case "Update Category":
                    $sql = "update m_lib_drug_category set ".
                           "cat_name = '".ucwords($post_vars["cat_name"])."' ".
                           "where cat_id = '".$post_vars["cat_id"]."'";
                    if ($result = mysql_query($sql)) {
                        header("location: ".$_SERVER["PHP_SELF"]."?page=".$get_vars["page"]."&menu_id=".$get_vars["menu_id"]);
                    }
                    break;
                case "Delete Category":
                    if (module::confirm_delete($menu_id, $post_vars, $get_vars)) {
                        $sql = "delete from m_lib_drug_category where cat_id = '".$post_vars["cat_id"]."'";
                        if ($result = mysql_query($sql)) {
                            header("location: ".$_SERVER["PHP_SELF"]."?page=".$get_vars["page"]."&menu_id=".$get_vars["menu_id"]);
                        }
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

    function form_drugcat() {
        if (func_num_args()) {
            $arg_list = func_get_args();
            $menu_id = $arg_list[0];
            $post_vars = $arg_list[1];
            $get_vars = $arg_list[2];
            if ($get_vars["drugcat_id"]) {
                $sql = "select cat_id, cat_name ".
                       "from m_lib_drug_category where cat_id = '".$get_vars["drugcat_id"]."'";
                if ($result = mysql_query($sql)) {
                    if (mysql_num_rows($result)) {
                        $drugcat = mysql_fetch_array($result);
                    }
                }
            }
        }
        print "<table width='400'>";
        print "<form action = '".$_SERVER["SELF"]."?page=LIBRARIES&menu_id=$menu_id' name='form_drugcat' method='post'>";
        print "<tr valign='top'><td>";
        print "<span class='library'>".FTITLE_DRUGCAT_FORM."</span><br><br>";
        print "</td></tr>";
        print "<tr valign='top'><td>";
        print "<span class='boxtitle'>".LBL_DRUGCAT_ID."</span><br> ";
        if ($drugcat["cat_id"]) {
            $disable = "disabled";
            print "<input type='hidden' name='cat_id' value='".$drugcat["cat_id"]."'>";
        } else {
            $disable = "";
        }
        print "<input type='text' class='textbox' size='5' $disable maxlength='5' name='cat_id' value='".($drugcat["cat_id"]?$drugcat["cat_id"]:$post_vars["cat_id"])."' style='border: 1px solid #000000'><br>";
        print "</td></tr>";
        print "<tr valign='top'><td>";
        print "<span class='boxtitle'>".LBL_DRUGCAT_NAME."</span><br> ";
        print "<input type='text' class='textbox' size='25' maxlength='50' name='cat_name' value='".($drugcat["cat_name"]?$drugcat["cat_name"]:$post_vars["Cat_name"])."' style='border: 1px solid #000000'><br>";
        print "</td></tr>";
        print "<tr><td><br>";
        if ($get_vars["drugcat_id"]) {
            print "<input type='hidden' name='cat_id' value='".$get_vars["drugcat_id"]."'>";
            if ($_SESSION["priv_update"]) {
                print "<input type='submit' value = 'Update Category' class='textbox' name='submitcat' style='border: 1px solid #000000'> ";
            }
            if ($_SESSION["priv_delete"]) {
                print "<input type='submit' value = 'Delete Category' class='textbox' name='submitcat' style='border: 1px solid #000000'> ";
            }
        } else {
            if ($_SESSION["priv_add"]) {
                print "<input type='submit' value = 'Add Category' class='textbox' name='submitcat' style='border: 1px solid #000000'> ";
            }
        }
        print "</td></tr>";
        print "</form>";
        print "</table><br>";
    }

    function _drug_formulation() {
    //
    // main method for drug formulation
    // calls form_drugform, process_drugform, display_drugform
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
        if ($exitinfo = $this->missing_dependencies('drug')) {
            return print($exitinfo);
        }

        if ($post_vars["submitformulation"]) {
            $this->process_drugform($menu_id, $post_vars, $get_vars);
        }
        $this->display_drugform($menu_id, $post_vars, $get_vars);
        $this->form_drugform($menu_id, $post_vars, $get_vars);
    }

    function show_drugform() {
        if (func_num_args()) {
            $arg_list = func_get_args();
            $form_id = $arg_list[0];
        }
        $sql = "select form_id, form_name from m_lib_drug_formulation order by form_name";
        if ($result = mysql_query($sql)) {
            if (mysql_num_rows($result)) {
                $retval .= "<select name='drugform' size='7' class='textbox'>";
                while (list($id, $name) = mysql_fetch_array($result)) {
                    $retval .= "<option value='$id' ".($form_id==$id?"selected":"").">$name</option>";
                }
                $retval .= "</select>";
                return $retval;
            } else {
                print "<font color='red'>No formulations in database.</font>";
            }
        }
    }
    
    function get_formulation_name() {
        if (func_num_args()) {
            $arg_list = func_get_args();
            $form_id = $arg_list[0];
        }
        $sql = "select form_name from m_lib_drug_formulation where form_id = '$form_id'";
        if ($result = mysql_query($sql)) {
            if (mysql_num_rows($result)) {
                if (list($name) = mysql_fetch_array($result)) {
                    return $name;
                } else {
                    return "noname";
                }
            }
        }
    }
    
    function display_drugform() {
        if (func_num_args()) {
            $arg_list = func_get_args();
            $menu_id = $arg_list[0];
            $post_vars = $arg_list[1];
            $get_vars = $arg_list[2];
            $validuser = $arg_list[3];
            $isadmin = $arg_list[4];
        }
        print "<table width='400'>";
        print "<tr valign='top'><td colspan='3'>";
        print "<span class='library'>".FTITLE_DRUGFORM_LIST."</span><br>";
        print "</td></tr>";
        print "<tr valign='top'><td><b>ID</b></td><td><b>".THEAD_NAME."</b></td></tr>";
        $sql = "select form_id, form_name from m_lib_drug_formulation order by form_name";
        if ($result = mysql_query($sql)) {
            if (mysql_num_rows($result)) {
                while (list($id, $name) = mysql_fetch_array($result)) {
                    print "<tr valign='top'><td>$id</td><td><a href='".$_SERVER["SELF"]."?page=LIBRARIES&menu_id=$menu_id&drugform_id=$id'>$name</a></td></tr>";
                }
            }
        }
        print "</table><br>";
    }

    function process_drugform() {
        if (func_num_args()>0) {
            $arg_list = func_get_args();
            $menu_id = $arg_list[0];
            $post_vars = $arg_list[1];
            $get_vars = $arg_list[2];
            $validuser = $arg_list[3];
            $isadmin = $arg_list[4];
            //print_r($arg_list);
        }
        if ($post_vars["submitformulation"]) {
            if ($post_vars["form_id"] && $post_vars["form_name"]) {
                switch($post_vars["submitformulation"]) {
                case "Add Formulation":
                    $sql = "insert into m_lib_drug_formulation (form_id, form_name) ".
                           "values ('".strtoupper($post_vars["form_id"])."', '".ucwords($post_vars["form_name"])."')";
                    if ($result = mysql_query($sql)) {
                        header("location: ".$_SERVER["PHP_SELF"]."?page=".$get_vars["page"]."&menu_id=".$get_vars["menu_id"]);
                    }
                    break;
                case "Update Formulation":
                    $sql = "update m_lib_drug_formulation set ".
                           "form_name = '".ucwords($post_vars["form_name"])."' ".
                           "where form_id = '".$post_vars["form_id"]."'";
                    if ($result = mysql_query($sql)) {
                        header("location: ".$_SERVER["PHP_SELF"]."?page=".$get_vars["page"]."&menu_id=".$get_vars["menu_id"]);
                    }
                    break;
                case "Delete Formulation":
                    if (module::confirm_delete($menu_id, $post_vars, $get_vars)) {
                        $sql = "delete from m_lib_drug_formulation where form_id = '".$post_vars["form_id"]."'";
                        if ($result = mysql_query($sql)) {
                            header("location: ".$_SERVER["PHP_SELF"]."?page=".$get_vars["page"]."&menu_id=".$get_vars["menu_id"]);
                        }
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

    function form_drugform() {
        if (func_num_args()) {
            $arg_list = func_get_args();
            $menu_id = $arg_list[0];
            $post_vars = $arg_list[1];
            $get_vars = $arg_list[2];
            if ($get_vars["drugform_id"]) {
                $sql = "select form_id, form_name ".
                       "from m_lib_drug_formulation where form_id = '".$get_vars["drugform_id"]."'";
                if ($result = mysql_query($sql)) {
                    if (mysql_num_rows($result)) {
                        $drugform = mysql_fetch_array($result);
                    }
                }
            }
        }
        print "<table width='400'>";
        print "<form action = '".$_SERVER["SELF"]."?page=LIBRARIES&menu_id=$menu_id' name='form_drugform' method='post'>";
        print "<tr valign='top'><td>";
        print "<span class='library'>".FTITLE_DRUGFORM_FORM."</span><br><br>";
        print "</td></tr>";
        print "<tr valign='top'><td>";
        print "<span class='boxtitle'>".LBL_DRUGFORM_ID."</span><br> ";
        if ($drugform["form_id"]) {
            $disable = "disabled";
            print "<input type='hidden' name='form_id' value='".$drugform["form_id"]."'>";
        } else {
            $disable = "";
        }
        print "<input type='text' class='textbox' size='5' $disable maxlength='5' name='form_id' value='".($drugform["form_id"]?$drugform["form_id"]:$post_vars["form_id"])."' style='border: 1px solid #000000'><br>";
        print "</td></tr>";
        print "<tr valign='top'><td>";
        print "<span class='boxtitle'>".LBL_DRUGFORM_NAME."</span><br> ";
        print "<input type='text' class='textbox' size='25' maxlength='50' name='form_name' value='".($drugform["form_name"]?$drugform["form_name"]:$post_vars["form_name"])."' style='border: 1px solid #000000'><br>";
        print "</td></tr>";
        print "<tr><td><br>";
        if ($get_vars["drugform_id"]) {
            print "<input type='hidden' name='form_id' value='".$get_vars["drugform_id"]."'>";
            if ($_SESSION["priv_update"]) {
                print "<input type='submit' value = 'Update Formulation' class='textbox' name='submitformulation' style='border: 1px solid #000000'> ";
            }
            if ($_SESSION["priv_delete"]) {
                print "<input type='submit' value = 'Delete Formulation' class='textbox' name='submitformulation' style='border: 1px solid #000000'> ";
            }
        } else {
            if ($_SESSION["priv_add"]) {
                print "<input type='submit' value = 'Add Formulation' class='textbox' name='submitformulation' style='border: 1px solid #000000'> ";
            }
        }
        print "</td></tr>";
        print "</form>";
        print "</table><br>";
    }

    function _drug_preparation() {
    //
    // main method for drug preparation
    // calls form_drugprep, process_drugprep, display_drugprep
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
        if ($exitinfo = $this->missing_dependencies('drug')) {
            return print($exitinfo);
        }

        if ($post_vars["submitpreparation"]) {
            $this->process_drugprep($menu_id, $post_vars, $get_vars);
        }
        $this->display_drugprep($menu_id, $post_vars, $get_vars);
        $this->form_drugprep($menu_id, $post_vars, $get_vars);
    }

    function show_drugprep() {
        if (func_num_args()) {
            $arg_list = func_get_args();
            $prep_id = $arg_list[0];
        }
        $sql = "select prep_id, prep_name from m_lib_drug_preparation order by prep_name";
        if ($result = mysql_query($sql)) {
            if (mysql_num_rows($result)) {
                $retval .= "<select name='drugprep' class='textbox'>";
                $retval .= "<option value=''>Select Preparation</option>";
                while (list($id, $name) = mysql_fetch_array($result)) {
                    $retval .= "<option value='$id' ".($prep_id==$id?"selected":"").">$name</option>";
                }
                $retval .= "</select>";
                return $retval;
            } else {
                print "<font color='red'>No drug preparations in database.</font>";
            }
        }
    }
    
    function display_drugprep() {
        if (func_num_args()) {
            $arg_list = func_get_args();
            $menu_id = $arg_list[0];
            $post_vars = $arg_list[1];
            $get_vars = $arg_list[2];
            $validuser = $arg_list[3];
            $isadmin = $arg_list[4];
        }
        print "<table width='400'>";
        print "<tr valign='top'><td colspan='3'>";
        print "<span class='library'>".FTITLE_DRUGPREP_LIST."</span><br>";
        print "</td></tr>";
        print "<tr valign='top'><td><b>ID</b></td><td><b>".THEAD_NAME."</b></td></tr>";
        $sql = "select prep_id, prep_name from m_lib_drug_preparation order by prep_name";
        if ($result = mysql_query($sql)) {
            if (mysql_num_rows($result)) {
                while (list($id, $name) = mysql_fetch_array($result)) {
                    print "<tr valign='top'><td>$id</td><td><a href='".$_SERVER["SELF"]."?page=LIBRARIES&menu_id=$menu_id&drugprep_id=$id'>$name</a></td></tr>";
                }
            }
        }
        print "</table><br>";
    }

    function process_drugprep() {
        if (func_num_args()>0) {
            $arg_list = func_get_args();
            $menu_id = $arg_list[0];
            $post_vars = $arg_list[1];
            $get_vars = $arg_list[2];
            $validuser = $arg_list[3];
            $isadmin = $arg_list[4];
            //print_r($arg_list);
        }
        if ($post_vars["submitpreparation"]) {
            if ($post_vars["prep_id"] && $post_vars["prep_name"]) {
                switch($post_vars["submitpreparation"]) {
                case "Add Preparation":
                    $sql = "insert into m_lib_drug_preparation (prep_id, prep_name) ".
                           "values ('".strtoupper($post_vars["prep_id"])."', '".ucwords($post_vars["prep_name"])."')";
                    if ($result = mysql_query($sql)) {
                        header("location: ".$_SERVER["PHP_SELF"]."?page=".$get_vars["page"]."&menu_id=".$get_vars["menu_id"]);
                    }
                    break;
                case "Update Preparation":
                    $sql = "update m_lib_drug_preparation set ".
                           "prep_name = '".ucwords($post_vars["prep_name"])."' ".
                           "where prep_id = '".$post_vars["prep_id"]."'";
                    if ($result = mysql_query($sql)) {
                        header("location: ".$_SERVER["PHP_SELF"]."?page=".$get_vars["page"]."&menu_id=".$get_vars["menu_id"]);
                    }
                    break;
                case "Delete Preparation":
                    if (module::confirm_delete($menu_id, $post_vars, $get_vars)) {
                        $sql = "delete from m_lib_drug_preparation where prep_id = '".$post_vars["prep_id"]."'";
                        if ($result = mysql_query($sql)) {
                            header("location: ".$_SERVER["PHP_SELF"]."?page=".$get_vars["page"]."&menu_id=".$get_vars["menu_id"]);
                        }
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

    function form_drugprep() {
        if (func_num_args()) {
            $arg_list = func_get_args();
            $menu_id = $arg_list[0];
            $post_vars = $arg_list[1];
            $get_vars = $arg_list[2];
            if ($get_vars["drugprep_id"]) {
                $sql = "select prep_id, prep_name ".
                       "from m_lib_drug_preparation where prep_id = '".$get_vars["drugprep_id"]."'";
                if ($result = mysql_query($sql)) {
                    if (mysql_num_rows($result)) {
                        $drugprep = mysql_fetch_array($result);
                    }
                }
            }
        }
        print "<table width='400'>";
        print "<form action = '".$_SERVER["SELF"]."?page=LIBRARIES&menu_id=$menu_id' name='form_drugprep' method='post'>";
        print "<tr valign='top'><td>";
        print "<span class='library'>".FTITLE_DRUGPREP_FORM."</span><br><br>";
        print "</td></tr>";
        print "<tr valign='top'><td>";
        print "<span class='boxtitle'>".LBL_DRUGPREP_ID."</span><br> ";
        if ($drugprep["prep_id"]) {
            $disable = "disabled";
            print "<input type='hidden' name='prep_id' value='".$drugprep["prep_id"]."'>";
        } else {
            $disable = "";
        }
        print "<input type='text' class='textbox' size='5' $disable maxlength='5' name='prep_id' value='".($drugprep["prep_id"]?$drugprep["prep_id"]:$post_vars["prep_id"])."' style='border: 1px solid #000000'><br>";
        print "</td></tr>";
        print "<tr valign='top'><td>";
        print "<span class='boxtitle'>".LBL_DRUGPREP_NAME."</span><br> ";
        print "<input type='text' class='textbox' size='25' maxlength='50' name='prep_name' value='".($drugprep["prep_name"]?$drugprep["prep_name"]:$post_vars["prep_name"])."' style='border: 1px solid #000000'><br>";
        print "</td></tr>";
        print "<tr><td><br>";
        if ($get_vars["drugprep_id"]) {
            print "<input type='hidden' name='prep_id' value='".$get_vars["drugprep_id"]."'>";
            if ($_SESSION["priv_update"]) {
                print "<input type='submit' value = 'Update Preparation' class='textbox' name='submitpreparation' style='border: 1px solid #000000'> ";
            }
            if ($_SESSION["priv_delete"]) {
                print "<input type='submit' value = 'Delete Preparation' class='textbox' name='submitpreparation' style='border: 1px solid #000000'> ";
            }
        } else {
            if ($_SESSION["priv_add"]) {
                print "<input type='submit' value = 'Add Preparation' class='textbox' name='submitpreparation' style='border: 1px solid #000000'> ";
            }
        }
        print "</td></tr>";
        print "</form>";
        print "</table><br>";
    }
    
    function _drug_manufacturer() {
    //
    // main method for drug manufacturer
    // calls form_drugman, process_drugman, display_drugman
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
        if ($exitinfo = $this->missing_dependencies('drug')) {
            return print($exitinfo);
        }

        if ($post_vars["submitmanufacturer"]) {
            $this->process_drugman($menu_id, $post_vars, $get_vars);
        }
        $this->display_drugman($menu_id, $post_vars, $get_vars);
        $this->form_drugman($menu_id, $post_vars, $get_vars);
    }
    
    function show_drugmanufacturer() {
        if (func_num_args()) {
            $arg_list = func_get_args();
            $manufacturer_id = $arg_list[0];
        }
        $sql = "select manufacturer_id, manufacturer_name from m_lib_drug_manufacturer order by manufacturer_name";
        if ($result = mysql_query($sql)) {
            if (mysql_num_rows($result)) {
                $retval .= "<select name='drugman' class='textbox'>";
                $retval .= "<option value=''>Select Manufacturer</option>";
                while (list($id, $name) = mysql_fetch_array($result)) {
                    $retval .= "<option value='$id' ".($manufacturer_id==$id?"selected":"").">$name</option>";
                }
                $retval .= "</select>";
                return $retval;
            } else {
                print "<font color='red'>No manufacturers in database.</font>";
            }
        }
    }
    
    function display_drugman() {
        if (func_num_args()) {
            $arg_list = func_get_args();
            $menu_id = $arg_list[0];
            $post_vars = $arg_list[1];
            $get_vars = $arg_list[2];
            $validuser = $arg_list[3];
            $isadmin = $arg_list[4];
        }
        print "<table width='400'>";
        print "<tr valign='top'><td colspan='3'>";
        print "<span class='library'>".FTITLE_DRUGMAN_LIST."</span><br>";
        print "</td></tr>";
        print "<tr valign='top'><td><b>ID</b></td><td><b>".THEAD_NAME."</b></td></tr>";
        $sql = "select manufacturer_id, manufacturer_name from m_lib_drug_manufacturer order by manufacturer_name";
        if ($result = mysql_query($sql)) {
            if (mysql_num_rows($result)) {
                while (list($id, $name) = mysql_fetch_array($result)) {
                    print "<tr valign='top'><td>$id</td><td><a href='".$_SERVER["SELF"]."?page=LIBRARIES&menu_id=$menu_id&drugman_id=$id'>$name</a></td></tr>";
                }
            }
        }
        print "</table><br>";
    }

    function process_drugman() {
        if (func_num_args()>0) {
            $arg_list = func_get_args();
            $menu_id = $arg_list[0];
            $post_vars = $arg_list[1];
            $get_vars = $arg_list[2];
            $validuser = $arg_list[3];
            $isadmin = $arg_list[4];
            //print_r($arg_list);
        }
        if ($post_vars["submitmanufacturer"]) {
            if ($post_vars["manufacturer_id"] && $post_vars["manufacturer_name"]) {
                switch($post_vars["submitmanufacturer"]) {
                case "Add Manufacturer":
                    $sql = "insert into m_lib_drug_manufacturer (manufacturer_id, manufacturer_name) ".
                           "values ('".strtoupper($post_vars["manufacturer_id"])."', '".ucwords($post_vars["manufacturer_name"])."')";
                    if ($result = mysql_query($sql)) {
                        header("location: ".$_SERVER["PHP_SELF"]."?page=".$get_vars["page"]."&menu_id=".$get_vars["menu_id"]);
                    }
                    break;
                case "Update Manufacturer":
                    $sql = "update m_lib_drug_manufacturer set ".
                           "manufacturer_name = '".ucwords($post_vars["manufacturer_name"])."' ".
                           "where manufacturer_id = '".$post_vars["manufacturer_id"]."'";
                    if ($result = mysql_query($sql)) {
                        header("location: ".$_SERVER["PHP_SELF"]."?page=".$get_vars["page"]."&menu_id=".$get_vars["menu_id"]);
                    }
                    break;
                case "Delete Manufacturer":
                    if (module::confirm_delete($menu_id, $post_vars, $get_vars)) {
                        $sql = "delete from m_lib_drug_manufacturer where manufacturer_id = '".$post_vars["manufacturer_id"]."'";
                        if ($result = mysql_query($sql)) {
                            header("location: ".$_SERVER["PHP_SELF"]."?page=".$get_vars["page"]."&menu_id=".$get_vars["menu_id"]);
                        }
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

    function form_drugman() {
        if (func_num_args()) {
            $arg_list = func_get_args();
            $menu_id = $arg_list[0];
            $post_vars = $arg_list[1];
            $get_vars = $arg_list[2];
            if ($get_vars["drugman_id"]) {
                $sql = "select manufacturer_id, manufacturer_name ".
                       "from m_lib_drug_manufacturer where manufacturer_id = '".$get_vars["drugman_id"]."'";
                if ($result = mysql_query($sql)) {
                    if (mysql_num_rows($result)) {
                        $drugman = mysql_fetch_array($result);
                    }
                }
            }
        }
        print "<table width='400'>";
        print "<form action = '".$_SERVER["SELF"]."?page=LIBRARIES&menu_id=$menu_id' name='form_drugman' method='post'>";
        print "<tr valign='top'><td>";
        print "<span class='library'>".FTITLE_DRUGMAN_FORM."</span><br><br>";
        print "</td></tr>";
        print "<tr valign='top'><td>";
        print "<span class='boxtitle'>".LBL_DRUGMAN_ID."</span><br> ";
        if ($drugman["manufacturer_id"]) {
            $disable = "disabled";
            print "<input type='hidden' name='manufacturer_id' value='".$drugman["manufacturer_id"]."'>";
        } else {
            $disable = "";
        }
        print "<input type='text' class='textbox' size='5' $disable maxlength='5' name='manufacturer_id' value='".($drugman["manufacturer_id"]?$drugman["manufacturer_id"]:$post_vars["form_id"])."' style='border: 1px solid #000000'><br>";
        print "</td></tr>";
        print "<tr valign='top'><td>";
        print "<span class='boxtitle'>".LBL_DRUGMAN_NAME."</span><br> ";
        print "<input type='text' class='textbox' size='25' maxlength='50' name='manufacturer_name' value='".($drugman["manufacturer_name"]?$drugman["manufacturer_name"]:$post_vars["manufacturer_name"])."' style='border: 1px solid #000000'><br>";
        print "</td></tr>";
        print "<tr><td><br>";
        if ($get_vars["drugman_id"]) {
            print "<input type='hidden' name='manufacturer_id' value='".$get_vars["drugman_id"]."'>";
            if ($_SESSION["priv_update"]) {
                print "<input type='submit' value = 'Update Manufacturer' class='textbox' name='submitmanufacturer' style='border: 1px solid #000000'> ";
            }
            if ($_SESSION["priv_delete"]) {
                print "<input type='submit' value = 'Delete Manufacturer' class='textbox' name='submitmanufacturer' style='border: 1px solid #000000'> ";
            }
        } else {
            if ($_SESSION["priv_add"]) {
                print "<input type='submit' value = 'Add Manufacturer' class='textbox' name='submitmanufacturer' style='border: 1px solid #000000'> ";
            }
        }
        print "</td></tr>";
        print "</form>";
        print "</table><br>";
    }

    function _drug_source() {
    //
    // main method for drug source
    // calls form_drugsource, process_drugsource, display_drugsource
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
        if ($exitinfo = $this->missing_dependencies('drug')) {
            return print($exitinfo);
        }

        if ($post_vars["submitsource"]) {
            $this->process_drugsource($menu_id, $post_vars, $get_vars);
        }
        $this->display_drugsource($menu_id, $post_vars, $get_vars);
        $this->form_drugsource($menu_id, $post_vars, $get_vars);
    }
    
    function show_drugsource() {
        if (func_num_args()) {
            $arg_list = func_get_args();
            $source_id = $arg_list[0];
        }
        $sql = "select source_id, source_name from m_lib_drug_source order by source_name";
        if ($result = mysql_query($sql)) {
            if (mysql_num_rows($result)) {
                $retval .= "<select name='drugsource' class='textbox'>";
                $retval .= "<option value=''>Select Drug Source</option>";
                while (list($id, $name) = mysql_fetch_array($result)) {
                    $retval .= "<option value='$id' ".($source_id==$id?"selected":"").">$name</option>";
                }
                $retval .= "</select>";
                return $retval;
            } else {
                print "<font color='red'>No drug source in database.</font>";
            }
        }
    }
    
    function display_drugsource() {
        if (func_num_args()) {
            $arg_list = func_get_args();
            $menu_id = $arg_list[0];
            $post_vars = $arg_list[1];
            $get_vars = $arg_list[2];
            $validuser = $arg_list[3];
            $isadmin = $arg_list[4];
        }
        print "<table width='400'>";
        print "<tr valign='top'><td colspan='3'>";
        print "<span class='library'>".FTITLE_DRUGSOURCE_LIST."</span><br>";
        print "</td></tr>";
        print "<tr valign='top'><td><b>ID</b></td><td><b>".THEAD_NAME."</b></td></tr>";
        $sql = "select source_id, source_name from m_lib_drug_source order by source_name";
        if ($result = mysql_query($sql)) {
            if (mysql_num_rows($result)) {
                while (list($id, $name) = mysql_fetch_array($result)) {
                    print "<tr valign='top'><td>$id</td><td><a href='".$_SERVER["SELF"]."?page=LIBRARIES&menu_id=$menu_id&drugsource_id=$id'>$name</a></td></tr>";
                }
            }
        }
        print "</table><br>";
    }

    function process_drugsource() {
        if (func_num_args()>0) {
            $arg_list = func_get_args();
            $menu_id = $arg_list[0];
            $post_vars = $arg_list[1];
            $get_vars = $arg_list[2];
            $validuser = $arg_list[3];
            $isadmin = $arg_list[4];
            //print_r($arg_list);
        }
        if ($post_vars["submitsource"]) {
            if ($post_vars["source_id"] && $post_vars["source_name"]) {
                switch($post_vars["submitsource"]) {
                case "Add Source":
                    $sql = "insert into m_lib_drug_source (source_id, source_name) ".
                           "values ('".strtoupper($post_vars["source_id"])."', '".ucwords($post_vars["source_name"])."')";
                    if ($result = mysql_query($sql)) {
                        header("location: ".$_SERVER["PHP_SELF"]."?page=".$get_vars["page"]."&menu_id=".$get_vars["menu_id"]);
                    }
                    break;
                case "Update Source":
                    $sql = "update m_lib_drug_source set ".
                           "source_name = '".ucwords($post_vars["source_name"])."' ".
                           "where source_id = '".$post_vars["source_id"]."'";
                    if ($result = mysql_query($sql)) {
                        header("location: ".$_SERVER["PHP_SELF"]."?page=".$get_vars["page"]."&menu_id=".$get_vars["menu_id"]);
                    }
                    break;
                case "Delete Source":
                    if (module::confirm_delete($menu_id, $post_vars, $get_vars)) {
                        $sql = "delete from m_lib_drug_source where source_id = '".$post_vars["source_id"]."'";
                        if ($result = mysql_query($sql)) {
                            header("location: ".$_SERVER["PHP_SELF"]."?page=".$get_vars["page"]."&menu_id=".$get_vars["menu_id"]);
                        }
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

    function form_drugsource() {
        if (func_num_args()) {
            $arg_list = func_get_args();
            $menu_id = $arg_list[0];
            $post_vars = $arg_list[1];
            $get_vars = $arg_list[2];
            if ($get_vars["drugsource_id"]) {
                $sql = "select source_id, source_name ".
                       "from m_lib_drug_source where source_id = '".$get_vars["drugsource_id"]."'";
                if ($result = mysql_query($sql)) {
                    if (mysql_num_rows($result)) {
                        $drugsource = mysql_fetch_array($result);
                    }
                }
            }
        }
        print "<table width='400'>";
        print "<form action = '".$_SERVER["SELF"]."?page=LIBRARIES&menu_id=$menu_id' name='form_drugsource' method='post'>";
        print "<tr valign='top'><td>";
        print "<span class='library'>".FTITLE_DRUGSOURCE_FORM."</span><br><br>";
        print "</td></tr>";
        print "<tr valign='top'><td>";
        print "<span class='boxtitle'>".LBL_DRUGSOURCE_ID."</span><br> ";
        if ($drugsource["source_id"]) {
            $disable = "disabled";
            print "<input type='hidden' name='source_id' value='".$drugsource["source_id"]."'>";
        } else {
            $disable = "";
        }
        print "<input type='text' class='textbox' size='5' $disable maxlength='5' name='source_id' value='".($drugsource["source_id"]?$drugsource["source_id"]:$post_vars["source_id"])."' style='border: 1px solid #000000'><br>";
        print "</td></tr>";
        print "<tr valign='top'><td>";
        print "<span class='boxtitle'>".LBL_DRUGSOURCE_NAME."</span><br> ";
        print "<input type='text' class='textbox' size='25' maxlength='50' name='source_name' value='".($drugsource["source_name"]?$drugsource["source_name"]:$post_vars["source_name"])."' style='border: 1px solid #000000'><br>";
        print "</td></tr>";
        print "<tr><td><br>";
        if ($get_vars["drugsource_id"]) {
            print "<input type='hidden' name='source_id' value='".$get_vars["drugsource_id"]."'>";
            if ($_SESSION["priv_update"]) {
                print "<input type='submit' value = 'Update Source' class='textbox' name='submitsource' style='border: 1px solid #000000'> ";
            }
            if ($_SESSION["priv_delete"]) {
                print "<input type='submit' value = 'Delete Source' class='textbox' name='submitsource' style='border: 1px solid #000000'> ";
            }
        } else {
            if ($_SESSION["priv_add"]) {
                print "<input type='submit' value = 'Add Source' class='textbox' name='submitsource' style='border: 1px solid #000000'> ";
            }
        }
        print "</td></tr>";
        print "</form>";
        print "</table><br>";
    }

    function _drugs() {
    //
    // main method for drugs
    // calls form_drug, process_drug, display_drug
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
        if ($exitinfo = $this->missing_dependencies('drug')) {
            return print($exitinfo);
        }

        if ($post_vars["submitdrug"]) {
            $this->process_drug($menu_id, $post_vars, $get_vars);
        }
        $this->form_drug($menu_id, $post_vars, $get_vars);
        $this->display_drug($menu_id, $post_vars, $get_vars);
    }

    function display_drug() {
        if (func_num_args()) {
            $arg_list = func_get_args();
            $menu_id = $arg_list[0];
            $post_vars = $arg_list[1];
            $get_vars = $arg_list[2];
            $validuser = $arg_list[3];
            $isadmin = $arg_list[4];
        }
        print "<table width='550' cellspacing='0' cellpadding='2'>";
        print "<tr valign='top'><td colspan='3'>";
        print "<span class='library'>".FTITLE_DRUG_LIST."</span><br>";
        print "</td></tr>";
        print "<tr valign='top' bgcolor='#CCCCCC'><td><b>ID</b></td>".
              "<td><b>".THEAD_NAME."</b></td>".
              "<td><b>".THEAD_PREP."</b></td>".
              "<td><b>".THEAD_FORM."</b></td>".
              "<td><b>".THEAD_SOURCE."</b></td>".
              "<td><b>".THEAD_MAN."</b></td>".
              "</tr>";
        $sql = "select drug_id, drug_name, drug_cat, drug_preparation, drug_formulation, ".
               "manufacturer_id, drug_source, admin_desc ".
               "from m_lib_drugs order by drug_cat, drug_name";
        if ($result = mysql_query($sql)) {
            if (mysql_num_rows($result)) {
                while (list($id, $name, $cat, $prep, $form, $man, $src) = mysql_fetch_array($result)) {
                    if ($prev_cat<>$cat) {
                        print "<tr valign='top' bgcolor='#FFCC00'><td colspan='6'><b>".strtoupper(drug::get_category_name($cat))."</b></td></tr>";
                    }
                    print "<tr valign='top' bgcolor='white'>";
                    print "<td>$id</td><td><a href='".$_SERVER["SELF"]."?page=LIBRARIES&menu_id=$menu_id&drug_id=$id'>$name</a></td>";
                    print "<td>".$prep."</td>";
                    print "<td>".drug::get_formulation_name($form)."</td>";
                    print "<td>".$src."</td>";
                    print "<td>".$man."</td>";
                    print "</tr>";
                    $prev_cat = $cat;
                }
            } else {
                print "<tr><td colspan='6'><font color='red'>No drugs in database.</font></td></tr>";
            }
        }
        print "</table><br>";
    }

    function process_drug() {
        if (func_num_args()>0) {
            $arg_list = func_get_args();
            $menu_id = $arg_list[0];
            $post_vars = $arg_list[1];
            $get_vars = $arg_list[2];
            $validuser = $arg_list[3];
            $isadmin = $arg_list[4];
            //print_r($arg_list);
        }
        if ($post_vars["submitdrug"]) {
            if ($post_vars["drugcat"] && $post_vars["drugprep"] && $post_vars["drugform"] && $post_vars["drugman"] && $post_vars["drug_name"]) {
                switch($post_vars["submitdrug"]) {
                case "Add Drug":
                    print $sql = "insert into m_lib_drugs (drug_cat, drug_name, drug_preparation, drug_formulation, manufacturer_id, drug_source, admin_desc) ".
                           "values ('".$post_vars["drugcat"]."', ".
                           "'".ucwords($post_vars["drug_name"])."', ".
                           "'".$post_vars["drugprep"]."', ".
                           "'".$post_vars["drugform"]."', ".
                           "'".$post_vars["drugman"]."', ".
                           "'".$post_vars["drugsource"]."', ".
                           "'".ucfirst($post_vars["admin_desc"])."')";
                    if ($result = mysql_query($sql)) {
                        header("location: ".$_SERVER["PHP_SELF"]."?page=".$get_vars["page"]."&menu_id=".$get_vars["menu_id"]);
                    }
                    break;
                case "Update Drug":
                    $sql = "update m_lib_drugs set ".
                           "drug_name = '".ucwords($post_vars["drug_name"])."', ".
                           "drug_cat = '".$post_vars["drugcat"]."', ".
                           "drug_formulation = '".$post_vars["drugform"]."', ".
                           "manufacturer_id = '".$post_vars["drugman"]."', ".
                           "drug_source = '".$post_vars["drugsource"]."', ".
                           "admin_desc = '".ucfirst($post_vars["admin_desc"])."' ".
                           "where drug_id = '".$post_vars["drug_id"]."'";
                    if ($result = mysql_query($sql)) {
                        header("location: ".$_SERVER["PHP_SELF"]."?page=".$get_vars["page"]."&menu_id=".$get_vars["menu_id"]);
                    }
                    break;
                case "Delete Drug":
                    if (module::confirm_delete($menu_id, $post_vars, $get_vars)) {
                        $sql = "delete from m_lib_drugs where drug_id = '".$post_vars["drug_id"]."'";
                        if ($result = mysql_query($sql)) {
                            header("location: ".$_SERVER["PHP_SELF"]."?page=".$get_vars["page"]."&menu_id=".$get_vars["menu_id"]);
                        }
                    } else {
                        if ($post_vars["confirm_delete"]=="No") {
                            header("location: ".$_SERVER["PHP_SELF"]."?page=".$get_vars["page"]."&menu_id=".$get_vars["menu_id"]);
                        }
                    }
                    break;
                }
            } else {
                print "<font color='red'>Please complete entries.</font><br>";
            }
        }
    }

    function form_drug() {
        if (func_num_args()) {
            $arg_list = func_get_args();
            $menu_id = $arg_list[0];
            $post_vars = $arg_list[1];
            $get_vars = $arg_list[2];
            if ($get_vars["drug_id"]) {
                $sql = "select drug_id, drug_name, drug_cat, drug_preparation, drug_formulation, manufacturer_id, drug_source, admin_desc ".
                       "from m_lib_drugs where drug_id = '".$get_vars["drug_id"]."'";
                if ($result = mysql_query($sql)) {
                    if (mysql_num_rows($result)) {
                        $drug = mysql_fetch_array($result);
                    }
                }
            }
        }
        print "<table width='400'>";
        print "<form action = '".$_SERVER["SELF"]."?page=LIBRARIES&menu_id=$menu_id' name='form_drug' method='post'>";
        print "<tr valign='top'><td>";
        print "<span class='library'>".FTITLE_DRUG_FORM."</span><br><br>";
        print "</td></tr>";
        print "<tr valign='top'><td>";
        print "<span class='boxtitle'>".LBL_DRUG_NAME."</span><br> ";
        print "<input type='text' class='textbox' size='25' maxlength='50' name='drug_name' value='".($drug["drug_name"]?$drug["drug_name"]:$post_vars["drug_name"])."' style='border: 1px solid #000000'><br>";
        print "</td></tr>";
        print "<tr valign='top'><td>";
        print "<span class='boxtitle'>".LBL_DRUG_CATEGORY."</span><br> ";
        print drug::show_drugcat($drug["drug_cat"]);
        print "</td></tr>";
        print "<tr valign='top'><td>";
        print "<span class='boxtitle'>".LBL_DRUG_PREPARATION."</span><br> ";
        print drug::show_drugprep($drug["drug_preparation"]);
        print "</td></tr>";
        print "<tr valign='top'><td>";
        print "<span class='boxtitle'>".LBL_DRUG_FORMULATION."</span><br> ";
        print drug::show_drugform($drug["drug_formulation"]);
        print "</td></tr>";
        print "<tr valign='top'><td>";
        print "<span class='boxtitle'>".LBL_DRUG_MANUFACTURER."</span><br> ";
        print drug::show_drugmanufacturer($drug["manufacturer_id"]);
        print "</td></tr>";
        print "<tr valign='top'><td>";
        print "<span class='boxtitle'>".LBL_DRUG_SOURCE."</span><br> ";
        print drug::show_drugsource($drug["drug_source"]);
        print "</td></tr>";
        print "<tr valign='top'><td>";
        print "<span class='boxtitle'>".LBL_ADMIN_DESC."</span><br> ";
        print "<textarea class='textbox' rows='5' cols='40' name='admin_desc' style='border: 1px solid #000000'>".($drug["admin_desc"]?$drug["admin_desc"]:$post_vars["admin_desc"])."</textarea><br>";
        print "</td></tr>";
        print "<tr><td><br>";
        if ($get_vars["drug_id"]) {
            print "<input type='hidden' name='drug_id' value='".$get_vars["drug_id"]."'>";
            if ($_SESSION["priv_update"]) {
                print "<input type='submit' value = 'Update Drug' class='textbox' name='submitdrug' style='border: 1px solid #000000'> ";
            }
            if ($_SESSION["priv_delete"]) {
                print "<input type='submit' value = 'Delete Drug' class='textbox' name='submitdrug' style='border: 1px solid #000000'> ";
            }
        } else {
            if ($_SESSION["priv_add"]) {
                print "<input type='submit' value = 'Add Drug' class='textbox' name='submitdrug' style='border: 1px solid #000000'> ";
            }
        }
        print "</td></tr>";
        print "</form>";
        print "</table><br>";
    }


// end of class
}
?>
