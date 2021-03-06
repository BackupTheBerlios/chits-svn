<?


/**
 * Patient Module
 * 
 * @package module 
 */

/**
 * Patient Class
 *
 * <b>VERSION HISTORY</b><br/>
 * 0.4 installed foreign key constraints<br/>
 * 0.41 fixed patient update bug with gender<br/>
 * 0.42 included uniquid for cross-healthcenter migration<br/>
 * 0.43 bug fixes
 * 0.44 Added Documentation
 *  
 * @package module
 * @author Herman Tolentino,MD <herman.tolentino@gmail.com>
 * @version 0.44
 * @copyright Copyright 2006, Herman Tolentino,MD
 */
class patient extends module{

	/**
	 * Patient Class Constructor
	 *
	 * Creates the patient class and sets the author name and version
	 *
	 * @return module instance of module class
	 */
	function patient() {
		$this->author = 'Herman Tolentino MD';
		$this->version = "0.44-".date("Y-m-d");
		$this->module = "patient";
		$this->description = "CHITS Module - Patient";
	}

	// --------------- STANDARD MODULE FUNCTIONS ------------------

	/**
	 * Initilize Dependencies
	 * 
	 * Insert dependencies in module_dependencies
	 */
	function init_deps() {
        module::set_dep($this->module, "module");
	}

	/**
	 * Initilize Language
	 * 
	 * insert necessary language directives
	 */
	function init_lang() {
        module::set_lang("THEAD_NAME", "english", "NAME", "Y");
        module::set_lang("THEAD_DESCRIPTION", "english", "DESCRIPTION", "Y");
        module::set_lang("FTITLE_PATIENTS", "english", "PATIENTS", "Y");
        module::set_lang("FTITLE_OLD_PATIENT", "english", "OLD PATIENT", "Y");
        module::set_lang("FTITLE_NEW_PATIENT", "english", "NEW PATIENT", "Y");
        module::set_lang("LBL_FIRST_NAME", "english", "FIRST NAME", "Y");
        module::set_lang("LBL_LAST_NAME", "english", "LAST NAME", "Y");
        module::set_lang("LBL_PATIENT_DOB", "english", "DATE OF BIRTH", "Y");
        module::set_lang("LBL_PATIENT_ID", "english", "PATIENT ID", "Y");
        module::set_lang("LBL_FAMILY_NUMBER", "english", "FAMILY NUMBER", "Y");
        module::set_lang("LBL_BARANGAY", "english", "LBL_BARANGAY", "Y");
        module::set_lang("LBL_MIDDLE_NAME", "english", "MIDDLE NAME", "Y");
        module::set_lang("LBL_PATIENT_AGE", "english", "PATIENT AGE", "Y");
        module::set_lang("LBL_GENDER", "english", "GENDER", "Y");
        module::set_lang("LBL_PATIENT_GROUPING", "english", "PATIENT GROUPING", "Y");
        module::set_lang("FTITLE_REGISTERED_TODAY", "english", "REGISTERED TODAY", "Y");
        module::set_lang("FTITLE_LOADED_PATIENT_MODULES", "english", "LOADED PATIENT MODULES", "Y");
        module::set_lang("FTITLE_EDIT_PATIENT", "english", "EDIT PATIENT", "Y");
        module::set_lang("FTITLE_SEARCH_RESULTS", "english", "SEARCH RESULTS", "Y");
        module::set_lang("LBL_REGISTERED_BY", "english", "REGISTERED BY", "Y");
        module::set_lang("LBL_MOTHERS_NAME", "english", "MOTHER\'S MAIDEN NAME", "Y");
        module::set_lang("INSTR_LOAD_PATIENT_RECORD", "english", "LOAD PATIENT RECORD", "Y");
        module::set_lang("INSTR_CLICK_PATIENT_NAME_TO_EDIT", "english", "CLICK ON PATIENT NAME TO EDIT DATA", "Y");
        module::set_lang("ERR_NO_MODULES_LOADED", "english", "No modules loaded.", "Y");
	}

	/**
	 * Initialize Help
	 */
	function init_help() {
	}

	/**
	 * Initilize Menu
	 * 
	 * Sets Menu Entried and detail
	 */
	function init_menu() {
        if (func_num_args()>0) {
            $arg_list = func_get_args();
        }

        // menu entries
        module::set_menu($this->module, "Records", "PATIENTS", "_patient");

        // this menu action is for attaching modules to patients in realtime
        module::set_menu($this->module, "Modules", "PATIENTS", "_patient_modules");

        // put in more details
        module::set_detail($this->description, $this->version, $this->author, $this->module);

	}

	/**
	 * Initilize SQL
	 */
	function init_sql() {
        if (func_num_args()>0) {
			$arg_list = func_get_args();
		}

		// this is not auto_increment
        module::execsql("CREATE TABLE `m_patient` (".
            "`patient_id` float NOT NULL auto_increment,".
            "`healthcenter_id` int(11) NOT NULL default '0',".
            "`user_id` float NOT NULL default '1',".
            "`patient_lastname` varchar(50) NOT NULL default '',".
            "`patient_firstname` varchar(50) NOT NULL default '',".
            "`patient_middle` varchar(50) NOT NULL default '',".
            "`patient_dob` date default '0000-00-00',".
            "`patient_mother` varchar(50) default '',".
            "`registration_date` datetime NOT NULL default '0000-00-00 00:00:00',".
            "`patient_gender` char(1) NOT NULL default '',".
            "PRIMARY KEY  (`patient_id`),".
            "UNIQUE KEY `key_patient_healthcenter` (`patient_id`,`healthcenter_id`),".
            "KEY `key_dob` (`patient_dob`),".
            "KEY `key_userid` (`user_id`),".
            "KEY `key_gender` (`patient_gender`),".
            "KEY `key_name` (`patient_lastname`,`patient_firstname`,`patient_middle`)".
            ") TYPE=InnoDB;");

        // version 0.42
        module::execsql("alter table `m_patient` add column `uniquid` varchar(120) not null;");

        module::execsql("CREATE TABLE `m_patient_modules` (".
               "`module_id` varchar(25) NOT NULL default '',".
               "PRIMARY KEY  (`module_id`), ".
               "CONSTRAINT `fkey_m_patient_modules_module` FOREIGN KEY (`module_id`) REFERENCES `modules` (`module_id`) ON DELETE CASCADE".
               ") TYPE=InnoDB;");
	}

	/**
	 * Drop Tables
	 */
	function drop_tables() {

        module::execsql("SET foreign_key_checks=0;");
        module::execsql("DROP TABLE `m_patient`;");
        module::execsql("DROP TABLE `m_patient_modules`;");
        module::execsql("SET foreign_key_checks=1;");
	}

	// --------------- CUSTOM MODULE FUNCTIONS ------------------

	/**
	 * Menu Modules
	 * 
	 * @param string $menu_id
	 * @param array $past_vars
	 * @param array $get_vars
	 * @param boolean $validuser
	 * @param booleam $isadmin
	 * @todo Explain what this function does
	 */
	function menu_modules() {
        if (func_num_args()) {
            $arg_list = func_get_args();
            $menu_id = $arg_list[0];
            $post_vars = $arg_list[1];
            $get_vars = $arg_list[2];
            $validuser = $arg_list[3];
            $isadmin = $arg_list[4];
            //print_r($arg_list);
        }
        // show patient-associated modules
        $sql = "select m.module_id, m.module_name from modules m, m_patient_modules p ".
               "where m.module_id = p.module_id ";
        if ($result = mysql_query($sql)) {
            if (mysql_num_rows($result)) {
                print "<table cellpadding='0' cellspacing='1' bgcolor='#9999FF' style='border: 1px solid black'><tr valign='top'><td>";
                print "<span class='groupmenu'><font color='#666699'><b>PROFILE</b></font></span> ";
                while (list($module, $name) = mysql_fetch_array($result)) {
                    print "<a href='".$_SERVER["PHP_SELF"]."?page=".$get_vars["page"]."&menu_id=".$get_vars["menu_id"]."&consult_id=".$get_vars["consult_id"]."&ptmenu=".$get_vars["ptmenu"]."&module=$module' class='groupmenu'>".strtoupper(($get_vars["group"]==$gid?"<b>$name</b>":$name))."</a>";
                }
                print "</td></tr></table>";
            }
        }
	}

	/**
	 * Form for Select Module
	 * 
	 * Creates form for Select module function
	 * @param string $menu_id
	 * @param array $post_vars
	 * @param array $get_vars 
	 */
	function form_selectmodule() {
        if (func_num_args()>0) {
            $arg_list = func_get_args();
            $menu_id = $arg_list[0];
            $post_vars = $arg_list[1];
            $get_vars = $arg_list[2];
            //print_r($arg_list);
        }
        print "<table width='300'>";
        print "<form action = '".$_SERVER["SELF"]."?page=".$get_vars["page"]."&menu_id=$menu_id' name='form_module' method='post'>";
        print "<tr valign='top'><td>";
        print "<span class='module'>".FTITLE_CONSULT_MODULE."</span><br/><br/>";
        print "</td></tr>";
        print "<tr valign='top'><td>";
        print "<b>NOTE: You are adding a sub-module to the patient module. Please read instructions for module integration.</b><br/><br/>";
        print "</td></tr>";
        print "<tr valign='top'><td>";
        print "<span class='boxtitle'>".LBL_CONSULT_MODULE."</span><br> ";
        print module::show_modules($module["module_id"]?$module["module_id"]:$post_vars["module"]);
        print "<br/><br/></td></tr>";
        print "<tr><td>";
        print "<br><input type='submit' value = 'Add Module' class='textbox' name='submitmodule' style='border: 1px solid #000000'><br> ";
        print "</td></tr>";
        print "</form>";
        print "</table><br>";
	}

	/**
	 * Process Module
	 * 
	 * Process the module action for the patient submodules
	 * 
	 * @param string $menu_id
	 * @param array $past_vars
	 * @param array $get_vars
	 * @param boolean $validuser
	 * @param booleam $isadmin
	 */
	function process_module() {
        if (func_num_args()>0) {
            $arg_list = func_get_args();
            $menu_id = $arg_list[0];
            $post_vars = $arg_list[1];
            $get_vars = $arg_list[2];
            $validuser = $arg_list[3];
            $isadmin = $arg_list[4];
            //print_r($arg_list);
        }
        if ($get_vars["delete_id"]) {
            $sql = "delete from m_patient_modules where module_id = '".$post_vars["module_id"]."'";
            $result = mysql_query($sql);
        }
        switch ($post_vars["submitmodule"]) {
        case "Add Module":
            if ($post_vars["module"]) {
                $sql = "insert into m_patient_modules (module_id) ".
                       "values ('".$post_vars["module"]."')";
                $result = mysql_query($sql);
            }
            break;
        }
	}

	/**
	 * Display Modules
	 * 
	 * Display the submodules loaded for patient
	 * @param string $menu_id
	 * @param array $past_vars
	 * @param array $get_vars
	 * @param boolean $validuser
	 * @param booleam $isadmin
	 */
	function display_modules() {
		if (func_num_args()) {
			$arg_list = func_get_args();
			$menu_id = $arg_list[0];
			$post_vars = $arg_list[1];
			$get_vars = $arg_list[2];
			$validuser = $arg_list[3];
			$isadmin = $arg_list[4];
		}
		print "<table width='620'>";
		print "<tr valign='top'><td colspan='3'>";
		print "<span class='module'>".FTITLE_LOADED_PATIENT_MODULES."</span><br><br>";
		print "</td></tr>";
		print "<tr valign='top'><td colspan='4'>";
		print "<b>Click on module name to see details (and source code).</b><br><br>";
		print "</td></tr>";
		print "<tr valign='top'><td><b>ID</b></td><td><b>NAME</b></td><td><b>INIT STATUS</b></td><td><b>VERSION</b></td><td><b>DESCRIPTION</b></td></tr>";
        $sql = "select p.module_id, m.module_name, m.module_init, m.module_version, m.module_desc ".
               "from modules m, m_patient_modules p ".
               "where m.module_id = p.module_id order by m.module_name";
        if ($result = mysql_query($sql)) {
            if (mysql_num_rows($result)) {
                while (list($id, $name, $init, $version, $desc) = mysql_fetch_array($result)) {
                    print "<tr class='tinylight' valign='top'><td>$id</td><td><a href='".$_SERVER["SELF"]."?page=MODULES&module_id=$id'>$name</a></td><td>".($init=="N"?"No <a href='".$_SERVER["PHP_SELF"]."?page=MODULES&method=INIT'>[<b>activate</b>]</a>":"Yes")."</td><td>$version</td><td>".($desc?"$desc":"<font color='red'>empty</font>")."</td></tr>";
				}
			} else {
				print "<tr valign='top'><td colspan='4'>";
				print "<font color='red'>".ERR_NO_MODULES_LOADED."</font><br>";
				print "</td></tr>";
			}
		}
		print "</table><br>";
	}

	/**
	 * Main Patient Module
	 * 
	 * Module is called when clicked on Records for Patients
	 * @param string $menu_id
	 * @param array $past_vars
	 * @param array $get_vars
	 * @param boolean $validuser
	 * @param booleam $isadmin
	 */
	 function _patient() {
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
        if ($exitinfo = $this->missing_dependencies('patient')) {
            return print($exitinfo);
        }
        print "<span class='patient'>".FTITLE_PATIENTS."</span><br/><br/>";
        if ($post_vars["submitsearch"]) {
            if ($errorinfo = $this->process_search($menu_id, $post_vars, $get_vars)) {
                print module::error_message($errorinfo);
            }
        }
        if ($post_vars["submitpatient"]) {
            $this->process_patient($menu_id, $post_vars, $get_vars);
        }
        print "<table><tr valign='top'><td colspan='2'>";
        patient::patient_info($menu_id, $post_vars, $get_vars);
        print "</td></tr>";
        print "<tr valign='top'><td>";
        patient::newsearch($menu_id, $post_vars, $get_vars);
        print "</td><td>";
        patient::form_patient($menu_id, $post_vars, $get_vars);
        print "</td></tr></table>";
	}

	/**
	 * Show Patient Info
	 * 
	 * Show information about the patients registered today
	 * @param string $menu_id
	 * @param array $past_vars
	 * @param array $get_vars
	 * @param boolean $validuser
	 * @param booleam $isadmin
	 */
	function patient_info() {
		//
		// patients registered today
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
        $sql = "select patient_id, patient_lastname, patient_firstname, patient_dob, patient_gender, round((to_days(now())-to_days(patient_dob))/365 , 1) computed_age ".
               "from m_patient where to_days(registration_date) = to_days(now()) order by patient_lastname, patient_firstname";
        if ($result = mysql_query($sql)) {
            print "<table width=600 bgcolor='#FFFFFF' cellpadding='3' cellspacing='0' style='border: 2px solid black'>";
            print "<tr><td>";
            print "<font color='red'><b>".FTITLE_REGISTERED_TODAY."</b></font><br>";
            if (mysql_num_rows($result)) {
                print "<span class='tinylight'>".INSTR_CLICK_PATIENT_NAME_TO_EDIT."</span><br/>";
                $i=0;
                while (list($pid, $plast, $pfirst, $pdob, $pgender, $p_age) = mysql_fetch_array($result)) {
                    $patient_array[$i] .= "<a href='".$_SERVER["PHP_SELF"]."?page=PATIENTS&menu_id=$menu_id&patient_id=$pid#ptform'><b>$plast, $pfirst</b></a> [$p_age/$pgender] $pdob";
                    if (class_exists("family")) {
                        // show family icon if patient has a family
                        $family_id = family::get_family_id($pid);
                        if ($family_id<>0) {
                            $family_menu_id = module::get_menu_id("_family");
                            $patient_array[$i] .= " <a href='".$_SERVER["PHP_SELF"]."?page=PATIENTS&menu_id=$family_menu_id&family_id=$family_id' title='GO TO FAMILY'><img src='../images/family.gif' border='0'/></a>";
                        }
                    }
                    if (class_exists("healthcenter")) {
                        $consult_menu_id = module::get_menu_id("_consult");
                        $patient_array[$i] .= " <a href='".$_SERVER["PHP_SELF"]."?page=".$get_vars["page"]."&menu_id=$consult_menu_id&enter_consult=$pid' title='".INSTR_LOAD_PATIENT_RECORD."'><img src='../images/records.gif' border='0'/></a>";
                    }
                    $i++;
                }
                print $this->columnize_list($patient_array);
            } else {
                print "No patients registered today.";
            }
            print "</td></tr>";
			print "</table>";
		}
	}

	/**
	 * Process Search
	 * 
	 * process the search paramaters and show the found patients
	 * @param string $menu_id
	 * @param array $past_vars
	 * @param array $get_vars
	 * @param boolean $validuser
	 * @param booleam $isadmin
	 */
	function process_search() {
        if (func_num_args()>0) {
            $arg_list = func_get_args();
            $menu_id = $arg_list[0];
            $post_vars = $arg_list[1];
            $get_vars = $arg_list[2];
        }
        // cascade through selection
        if ($post_vars["last"]) {
            $index .= "patient_lastname like '%".$post_vars["last"]."%'";
        }
        // check with ternary operator and isset whether $index has been initialized
        if ($post_vars["first"]) {
            $index .= (isset($index)?" AND ":" ") ." patient_firstname like '%".$post_vars["first"]."%' ";
        }
        // query the database and append $index to WHERE
        if (isset($index)) {
            $sql = "SELECT patient_id, patient_firstname,patient_lastname, patient_gender, patient_dob FROM m_patient WHERE $index ";
            if ($result=mysql_query($sql)) {
                print "<span class='module'>".FTITLE_SEARCH_RESULTS."</span><br><br>";
                if ($rows = mysql_num_rows($result)) {
                    print "<b>Found <font color='red'>$rows</font> record".($rows>1?"s":"").". Please select patient to load...</b><br><br>";
                    print "<table bgcolor='#FFFF99' width='300' cellpadding='3' cellspacing='0' style='border: 2px solid black'>";
                    print "<form method='post' action='".$_SERVER["PHP_SELF"]."?page=".$get_vars["page"]."&menu_id=$menu_id'>";
                    while(list($id,$first,$last,$gender, $dob)=mysql_fetch_array($result)) {
                        print "<tr><td>";
                        print "<input type='radio' name='consult_id' value='$id'> ";
                        print "$id <a href='".$_SERVER["PHP_SELF"]."?page=".$get_vars["page"]."&menu_id=$menu_id&patient_id=$id'>$first $last ($gender) $dob</a>";
                        print "</td></tr>" ;
                    }
                    print "<tr><td>";
                    print "<input type='submit' name='submitconsult' value='Select Patient' class='textbox' style='background-color: #FFCC33'><br>";
                    print "</td></tr>";
                    print "</form>";
                    print "</table><br/>";
                } else {
                    print "<b><font color='red'>NO RECORDS FOUND.</font></b><br><br>";
                }
            }
		}
	}

	/**
	 * Process Patient
	 * 
	 * Process the operation being performed on the patient information
	 * @param string $menu_id
	 * @param array $past_vars
	 * @param array $get_vars
	 * @param boolean $validuser
	 * @param booleam $isadmin
	 */
	function process_patient() {
        if (func_num_args()>0) {
            $arg_list = func_get_args();
            $menu_id = $arg_list[0];
            $post_vars = $arg_list[1];
            $get_vars = $arg_list[2];
            //print_r($post_vars);
        }
        list($month,$day,$year) = explode("/", $post_vars["patient_dob"]);
        $dob = $year."-".str_pad($month, 2, "0", STR_PAD_LEFT)."-".str_pad($day, 2, "0", STR_PAD_LEFT);
        $post_vars["conv_dob"] = $dob;
        switch ($post_vars["submitpatient"]) {
        case "Add Patient":
            if ($post_vars["patient_lastname"] && $post_vars["patient_firstname"] && $post_vars["patient_gender"] && $post_vars["patient_dob"] && $post_vars["patient_mother"]) {
                // check for duplicates
                $threshold = 93;
                $sim_index = $this->get_duplicates($post_vars, $threshold);
                if ($sim_index<$threshold) {
                    $sql = "insert into m_patient (patient_lastname, patient_firstname, patient_middle, patient_dob, patient_gender, registration_date, user_id, healthcenter_id, patient_mother) ".
                           "values ('".ucwords($post_vars["patient_lastname"])."', '".ucwords($post_vars["patient_firstname"])."', '".ucwords($post_vars["patient_middle"])."', ".
                           "'$dob', '".$post_vars["patient_gender"]."', sysdate(), '".$_SESSION["userid"]."', '".$_SESSION["datanode"]["code"]."', '".ucwords($post_vars["patient_mother"])."')";
                    if ($result = mysql_query($sql)) {
                        header("location: ".$_SERVER["PHP_SELF"]."?page=".$get_vars["page"]."&menu_id=".$get_vars["menu_id"]);
                    }
                } else {
                    print "<font size='5' color='red'><b>Duplicate detected ".round($sim_index,2)."%.</b></font><br/>";
                }
            } else {
                return;
            }
            break;
        case "Update Patient":
            if ($post_vars["patient_lastname"] && $post_vars["patient_firstname"] && $post_vars["patient_gender"]) {
                $sql = "update m_patient set ".
                       "patient_firstname = '".ucwords($post_vars["patient_firstname"])."', ".
                       "patient_middle = '".ucwords($post_vars["patient_middle"])."', ".
                       "patient_lastname = '".ucwords($post_vars["patient_lastname"])."', ".
                       "user_id = '".$_SESSION["userid"]."', ".
                       "patient_dob = '$dob' ".
                       "where patient_id = '".$post_vars["patient_id"]."'";
                if ($result = mysql_query($sql)) {
                    header("location: ".$_SERVER["PHP_SELF"]."?page=".$get_vars["page"]."&menu_id=".$get_vars["menu_id"]);
                }
            }
            break;
        case "Delete Patient":
            if (module::confirm_delete($menu_id,$post_vars,$get_vars)) {
                $sql = "delete from m_patient where patient_id = '".$post_vars["patient_id"]."'";
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

	/**
	 * Show Search form for Patient
	 * 
	 * @param string $menu_id
	 * @param array $past_vars
	 * @param array $get_vars
	 * @todo rename the function correctly according to naming conventions
	 */
    function newsearch () {
        if (func_num_args()>0) {
            $arg_list = func_get_args();
            $menu_id = $arg_list[0];
			$post_vars = $arg_list[1];
			$get_vars = $arg_list[2];
		}
		print "<table width='300'>";
		print "<form action = '".$_SERVER["PHP_SELF"]."?page=".$get_vars["page"]."&menu_id=$menu_id' name='form_search' method='post'>";
		print "<tr valign='top'><td>";
		print "<font color='#666699' size='5'><b>".FTITLE_OLD_PATIENT."</b></font><br>";
		print "</td></tr>";
		print "<tr valign='top'><td>";
		print "<b>Note: Use this form for patients who have visited the center already. <br><br>";
		print "</td></tr>";
		print "<tr valign='top'><td>";
		print "<span class='boxtitle'>".LBL_FIRST_NAME."</span><br> ";
		print "<input type='text' class='textbox' name='first' style='border: 1px solid #000000'><br>";
		print "</td></tr>";
		print "<tr valign='top'><td>";
		print "<span class='boxtitle'>".LBL_LAST_NAME."</span><br> ";
		print "<input type='text' class='textbox' name='last' style='border: 1px solid #000000'><br>";
		print "</td></tr>";
		print "<tr><td>";
		print "<br><input type='submit' value = 'Search' class='textbox' name='submitsearch' style='border: 1px solid #000000'><br>";
		print "</td></tr>";
		print "</form>";
		print "</table><br>";
	}

	/**
	 * Show Patient Form 
	 * 
	 * Show form for adding or updating patient
	 * @param string $menu_id
	 * @param array $past_vars
	 * @param array $get_vars
	 */
    function form_patient () {
        if (func_num_args()>0) {
            $arg_list = func_get_args();
            $menu_id = $arg_list[0];
            $post_vars = $arg_list[1];
            $get_vars = $arg_list[2];
            //print_r($arg_list);
            if ($get_vars["patient_id"]) {
                $sql = "select patient_id, healthcenter_id, registration_date, patient_lastname, ".
                       "patient_firstname, patient_middle, patient_dob, patient_gender, user_id, patient_mother ".
                       "from m_patient where patient_id = '".$get_vars["patient_id"]."'";
                if ($result = mysql_query($sql)) {
                    if (mysql_num_rows($result)) {
                        $patient = mysql_fetch_array($result);
                    }
                }
            }
        }
        print "<a name='ptform'>";
		print "<table width='300'>";
		print "<form action = '".$_SERVER["SELF"]."?page=".$get_vars["page"]."&menu_id=$menu_id' name='form_patient' method='post'>";
		if ($get_vars["patient_id"]) {
			print "<tr valign='top'><td>";
			print "<font color='#99CC00' size='5'><b>".FTITLE_EDIT_PATIENT."</b></font>";
			print "</td></tr>";
		} else {
			print "<tr valign='top'><td>";
			print "<font color='#99CC00' size='5'><b>".FTITLE_NEW_PATIENT."</b></font>";
			print "</td></tr>";
			print "<tr valign='top'><td>";
			print "<b>NOTE: This form is for new patients.</b><br><br>";
			print "</td></tr>";
		}
		if ($get_vars["patient_id"]) {
			print "<tr valign='top'><td>";
			print "<span class='boxtitle'>".LBL_REGISTRATION_DATE."</span><br> ";
			print $patient["registration_date"]."<br/>";
			print "</td></tr>";
			print "<tr valign='top'><td>";
			print "<span class='boxtitle'>".LBL_REGISTERED_BY."</span><br> ";
            print user::get_username($patient["user_id"])."<br/>";
            print "</td></tr>";
        }
        print "<tr valign='top'><td>";
        print "<span class='boxtitle'>".LBL_FIRST_NAME."</span><br> ";
        print "<input type='text' class='textbox' name='patient_firstname' value='".($patient["patient_firstname"]?$patient["patient_firstname"]:$post_vars["patient_firstname"])."' style='border: 1px solid #000000'><br>";
        print "</td></tr>";
        print "<tr valign='top'><td>";
        print "<span class='boxtitle'>".LBL_MIDDLE_NAME."</span><br> ";
        print "<input type='text' class='textbox' name='patient_middle' value='".($patient["patient_middle"]?$patient["patient_middle"]:$post_vars["patient_middle"])."' style='border: 1px solid #000000'><br>";
        print "</td></tr>";
        print "<tr valign='top'><td>";
        print "<span class='boxtitle'>".LBL_LAST_NAME."</span><br> ";
        print "<input type='text' class='textbox' name='patient_lastname' value='".($patient["patient_lastname"]?$patient["patient_lastname"]:$post_vars["patient_lastname"])."' style='border: 1px solid #000000'><br>";
        print "</td></tr>";
        print "<tr valign='top'><td>";
        print "<span class='boxtitle'>".LBL_MOTHERS_NAME."</span><br> ";
        print "<input type='text' size='30' class='textbox' ".($_SESSION["isadmin"]||!$get_vars["patient_id"]?"":"disabled")." name='patient_mother' value='".($patient["patient_mother"]?$patient["patient_mother"]:$post_vars["patient_mother"])."' style='border: 1px solid #000000'><br>";
        print "</td></tr>";
        print "<tr valign='top'><td>";
        print "<span class='boxtitle'>".LBL_PATIENT_DOB."</span><br> ";
        if ($patient["patient_dob"]) {
            // convert to external format
            list($year, $month, $day) = explode("-", $patient["patient_dob"]);
            $dob = "$month/$day/$year";
        }
        print "<input type='text' size='10' maxlength='10' class='textbox' name='patient_dob' value='".($dob?$dob:$post_vars["patient_dob"])."' style='border: 1px solid #000000'><br>";
        print "<small>Use format MM/DD/YYYY.</small>";
        print "</td></tr>";
        print "<tr valign='top'><td>";
        print "<span class='boxtitle'>".LBL_GENDER."</span><br> ";
        print "<select name='patient_gender' ".($get_vars["patient_id"]?'disabled':'')." class='textbox'>";
        print "<option ".($patient["patient_gender"]=='M'?'selected':'')." value='M'>Male</option>";
        print "<option ".($patient["patient_gender"]=='F'?'selected':'')." value='F'>Female</option>";
        print "<option ".($patient["patient_gender"]=='I'?'selected':'')." value='I'>Indeterminate</option>";
        print "</select>";
        if ($patient["patient_gender"]) {
            print "<input type='hidden' name='patient_gender' value='".$patient["patient_gender"]."' />";
        }
        print "</td></tr>";
        print "<tr><td>";
        if ($get_vars["patient_id"]) {
            print "<input type='hidden' name='patient_id' value='".$get_vars["patient_id"]."'>";
            if ($_SESSION["priv_update"]) {
                print "<input type='submit' value = 'Update Patient' class='textbox' name='submitpatient' style='border: 1px solid #000000'> ";
            }
            if ($_SESSION["priv_delete"]) {
                print "<input type='submit' value = 'Delete Patient' class='textbox' name='submitpatient' style='border: 1px solid #000000'> ";
            }
        } else {
            if ($_SESSION["priv_add"]) {
                print "<br><input type='submit' value = 'Add Patient' class='textbox' name='submitpatient' style='border: 1px solid #000000'><br> ";
            }
        }
        print "</td></tr>";
        print "</form>";
        print "</table><br>";
	}

	/**
	 * Process the submodules
	 * 
	 * @param string $menu_id
	 * @param array $past_vars
	 * @param array $get_vars
	 * @param boolean $validuser
	 * @param booleam $isadmin
	 */
	function _patient_modules() {
        if (func_num_args()>0) {
			$arg_list = func_get_args();
			$menu_id = $arg_list[0];
			$post_vars = $arg_list[1];
			$get_vars = $arg_list[2];
			$validuser = $arg_list[3];
			$isadmin = $arg_list[4];
			//print_r($arg_list);
		}
		if ($post_vars["submitmodule"]) {
			$this->process_module($menu_id, $post_vars, $get_vars);
		}
		$this->display_modules($menu_id, $post_vars, $get_vars);
		$this->form_selectmodule($menu_id, $post_vars, $get_vars);
	}

	/**
	 * Is Patient Adolescent
	 * @param int $age
	 * @return boolean true if the patient is adolescent
	 * @static
	 */
	function is_adolescent() {
        if (func_num_args()>0) {
            $arg_list = func_get_args();
            $age = $arg_list[0];
        }
        if ($age>=12 and $age<=19) {
            return true;
        } else {
            return false;
        }
	}

	/**
	 * Is reproductive age
	 * @todo finish the function
	 */
	function is_reproductive_age() {
	}

	/**
	 * Get Gender of a patient
	 * 
	 * @static
	 * @param string $patient_id
	 * @return string Gender of the patient
	 * @todo fix to return in case patient is not found
	 */
	function get_gender() {
        if (func_num_args()>0) {
            $arg_list = func_get_args();
            $patient_id = $arg_list[0];
        }
        $sql = "select patient_gender from m_patient where patient_id = '$patient_id'";
        if ($result = mysql_query($sql)) {
            if (mysql_num_rows($result)) {
                list($gender) = mysql_fetch_array($result);
				return $gender;
			}
		}
	}

	/**
	 * Get Age
	 * @static 
	 * @param string $patient_id
	 * @return int age of the patient
	 * @todo fix return if patient is not found
	 */
	function get_age() {
        if (func_num_args()>0) {
            $arg_list = func_get_args();
            $patient_id = $arg_list[0];
        }
        $sql = "select round((to_days(sysdate())-to_days(patient_dob))/365,1) age from m_patient where patient_id = '$patient_id'";
        if ($result = mysql_query($sql)) {
            if (mysql_num_rows($result)) {
                list($age) = mysql_fetch_array($result);
				return $age;
			}
		}
	}

	/**
	 * Get Name
	 * 
	 * @static
	 * @param string $patient_id
	 * @return string $name
	 * @todo fix return if patient is not found
	 */
	function get_name() {
        if (func_num_args()>0) {
            $arg_list = func_get_args();
            $patient_id = $arg_list[0];
        }
        $sql = "select concat(patient_lastname, ', ', patient_firstname, ' ', patient_middle) from m_patient where patient_id = '$patient_id'";
        if ($result = mysql_query($sql)) {
            if (mysql_num_rows($result)) {
                list($name) = mysql_fetch_array($result);
				return $name;
			}
		}
	}

	/**
	 * Get Date of Birth
	 * @param string $patient_id
	 * @return string $dob
	 * @static
	 * @todo fix return if patient is not found
	 */
	function get_dob() {
        if (func_num_args()>0) {
            $arg_list = func_get_args();
            $patient_id = $arg_list[0];
        }
        $sql = "select patient_dob from m_patient where patient_id = '$patient_id'";
        if ($result = mysql_query($sql)) {
            if (mysql_num_rows($result)) {
                list($dob) = mysql_fetch_array($result);
				return $dob;
			}
		}
	}

	// SIMILARITIES AND DUPLICATES

	/**
	 * Get Duplicates
	 * 
	 * @static
	 * @param array $post_vars
	 * @param int $threshold 
	 * @return int
	 * @todo since compute similarity in module will always return zero this function will always return zero
	 */
	function get_duplicates() {
        if (func_num_args()>0) {
			$arg_list = func_get_args();
			$post_vars = $arg_list[0];
			$threshold = $arg_list[1]; // percent
			//print_r($post_vars);
		}
		//
		// uses compute_similarity (string1, string2, threshold_percent)
		//
		if ($post_vars["patient_firstname"]) {
			$fields .= "lower(patient_firstname),";
			$test_string .= strtolower($post_vars["patient_firstname"]);
		}
		if ($post_vars["patient_middle"]) {
			$fields .= "lower(patient_middle),";
			$test_string .= strtolower($post_vars["patient_middle"]);
		}
		if ($post_vars["patient_lastname"]) {
			$fields .= "lower(patient_lastname),";
			$test_string .= strtolower($post_vars["patient_lastname"]);
		}
		// this is different because date representations
		// are different for form and database
		if ($post_vars["conv_dob"]) {
			$fields .= "patient_dob,";
			$test_string .= $post_vars["conv_dob"];
		}
		if ($post_vars["patient_gender"]) {
			$fields .= "patient_gender,";
			$test_string .= $post_vars["patient_gender"];
		}
		if ($post_vars["patient_mother"]) {
			$fields .= "lower(patient_mother),";
			$test_string .= strtolower($post_vars["patient_mother"]);
		}
        $fields = "concat(".substr($fields,0,strlen($fields)-1).") ";
        $sql_index = "select patient_id, $fields ".
                     "from m_patient order by registration_date desc";
        if ($result_index = mysql_query($sql_index)) {
            if (mysql_num_rows($result_index)) {
                while (list($index_id, $index_string) = mysql_fetch_array($result_index)) {
                    $sim = module::compute_similarity($test_string, $index_string, $threshold);
                    if ($sim>$threshold) {
                        return $sim;
                    }
                }

			}
		}
	}
}

/**
 * Patient Object Class
 * 
 * this is the patient object and a replica of the database of the patient
 * @author Aditya Naik <aditya@adityanaik.com>
 * @version 0.1
 */
class patient_object {
	/**
	 * Patient ID
	 * @var float
	 */
	var $patient_id;
	/**
	 * HealthCenter ID
	 * @var integer
	 */
	var $healthcenter_id;
	/**
	 * User ID
	 * @var float
	 */
	var $user_id;
	/**
	 * Last Name
	 * @var string
	 */
	var $patient_lastname;
	/**
	 * First Name
	 * @var string
	 */
	var $patient_firstname;
	/**
	 * Middle Name
	 * @var string
	 */
	var $patient_middle;
	/**
	 * Date of Birth
	 * @var date
	 */
	var $patient_dob;
	/**
	 * Patient's Mother name
	 * @var string
	 */
	var $patient_mother;
	/**
	 * Registration Date
	 * @var datetime
	 */
	var $registration_date;
	/**
	 * Gender
	 * @var char M: Male, F: Female
	 */
	var $patient_gender;
	
	function patient(){
	}
	
	function getDOB(){
	}
	
}
?>