<?
/**
 * contains the mysqldb class
 *
 * @package game
 */

/**
 * MYSQLDB Class
 *
 * GAME Project 2004<br/>
 * Generic Architecture for Modular Enterprise
 * 
 * <b>Version History</b><br/>
 * 0.3 modified system table creation process<br/>
 * 0.4 added mysql_version()<br/>
 * 0.5 added table creation information<br/>
 * 0.6 Added by Aditya Naik<br/>
 *     - Changed the connectdb function to also check if the tables exists. if not then create the tables also.
 *     - Added Documentation  
 * 
 * @package game
 * @author Herman Tolentino,MD <herman.tolentino@gmail.com>
 * @version 0.6
 * @copyright Copyright 2006, Herman Tolentino,MD
 */
class MySQLDB {

    /**
     * Connection ID
     * @var int
     */
    var $conn = 0;

    /**
     * Constructor
     */
    function mysqldb () {
        $this->version = "0.6";
        $this->author = "Herman Tolentino MD";
        if (!file_exists(GAME_DIR."modules/_dbselect.php")) {
            $this->setup(GAME_DIR."config/db.xml");
        }
    }

    /**
     * Setup
     * 
     * writes down _dbselect.php in the modules directory
     * 
     * @param string $filename
     */
    function setup() {
        if (func_num_args()>0) {
            $arg_list = func_get_args();
            $filename = $arg_list[0];
        }
        if (file_exists($filename)) {
            $db = $this->readconfig($filename);
            foreach ($db as $key=>$dbname) {
                foreach($dbname as $key=>$value) {
                    //print $value;
                    $_SESSION[$key] = $value;
                }
            }
            $dbfile = "";
            if ($fp = @fopen(GAME_DIR."modules/_dbselect.php", "w+")) {
                $dbfile .= "<?php\n";
                $dbfile .= "\$_SESSION[\"dbname\"] = \"".$_SESSION["dbname"]."\";\n";
                $dbfile .= "\$_SESSION[\"dbuser\"] = \"".$_SESSION["dbuser"]."\";\n";
                $dbfile .= "\$_SESSION[\"dbpass\"] = \"".$_SESSION["dbpass"]."\";\n";
                $dbfile .= "\$conn = mysql_connect(\"".$_SESSION["dbhost"]."\", \"".$_SESSION["dbuser"]."\", \"".$_SESSION["dbpass"]."\");\n";
                $dbfile .= "\$db->connectdb(\"".$_SESSION["dbname"]."\");\n";
                $dbfile .= "?>";
                if (fwrite($fp, $dbfile)) {
                    fclose($fp);
                }
            }
        }
    }

    /**
     * Connect DB
     * 
     * Connect to the database. If they do not exist create database and system tables
     * 
     * @param string $dbname 
     */
    function connectdb() {
        if (func_num_args()>0) {
            $arg_list = func_get_args();
            $dbname = $arg_list[0];
        }
        //$self->conn = mysql_connect($_SESSION["dbhost"], $_SESSION["dbuser"], $_SESSION["dbpass"]) or die(mysql_errno().": ".mysql_error());
        if (!mysql_select_db($dbname)) {
        	$this->create_system_db($dbname);
        }  else {
        	$sql = "show tables like 'game_user';";
			if ($result = mysql_query($sql)) {
				if (!mysql_num_rows($result)) {
					$this->create_system_tables($dbname);
				}
			}
        
		}
    }

    /**
     * Select DB
     * 
     * @param string $db
     */
    function selectdb ($db) {
        mysql_select_db("$db");
    }

    /**
     * Connection ID
     * 
     * @return int $conn
     *  
     */
    function connid () {
        return $this->conn;
    }

    /**
     * Mysql Version 
     * 
     * Check MySQL version. due to password field change, longer hash in 4.0+ versions
     * 
     * @return string $mysql_server_version
     */
    function mysql_version() {
        list($mysql_server_version, $x) = explode("-",mysql_get_server_info());
        return $mysql_server_version;
    }
    
    /**
     * Create System Database
     * 
     * @param string $dbname
     */
    function create_system_db() {
		 if (func_num_args()>0) {
            $arg_list = func_get_args();
            $dbname = $arg_list[0];
        }
        
        mysql_query("CREATE DATABASE `$dbname`;") or die(mysql_errno().": ".mysql_error());
        
		$this->create_system_tables($dbname);           	
    }
    

    /**
     * Create System Tables
     * 
     * @param string $dbname
     */
    function create_system_tables() {
        if (func_num_args()>0) {
            $arg_list = func_get_args();
            $dbname = $arg_list[0];
        }

        mysql_select_db($dbname);

        //module::load_sql("setup.sql");
        //
        // set up system tables
        //
        if (module::execsql("set foreign_key_checks=0;")) {
            print "<font color='BLUE'>FOREIGN KEY CHECKS DISABLED...</font><br>";
        }

        // table: content
        // this table manages content module layout in content section
        //    of enterprise application; this means you can set up any
        //    content management module (news, quotes, articles, etc.)
        if (module::execsql("CREATE TABLE content (".
            "content_id int(11) NOT NULL auto_increment,".
            "content_module varchar(25) NOT NULL default '',".
            "content_column int(11) NOT NULL default '0',".
            "content_active char(1) NOT NULL default '',".
            "content_display int(11) NOT NULL default '10',".
            "content_level int(11) NOT NULL default '0',".
            "PRIMARY KEY  (content_id),".
            "KEY key_module (content_module),".
            "CONSTRAINT `content_ibfk_1` FOREIGN KEY (`content_module`) REFERENCES `modules` (`module_id`) ON DELETE CASCADE".
            ") TYPE=InnoDB;")) {
            print "<font color='BLUE'>CONTENT table created...</font><br>";
        }
        // content content
        module::execsql("INSERT INTO content VALUES (1,'news',1,'Y',10,1);");

        // error codes
        if (module::execsql("CREATE TABLE errorcodes (".
            "error_id char(3) NOT NULL default '',".
            "error_name varchar(100) NOT NULL default '',".
            "PRIMARY KEY  (error_id)".
            ") TYPE=MyISAM;")) {
            print "<font color='BLUE'>ERRORCODES table created...</font><br>";
        }
        // error codes content
        module::execsql("INSERT INTO errorcodes VALUES ('001','Invalid account.');");
        module::execsql("INSERT INTO errorcodes VALUES ('002','Please complete entries');");

        // table: game_user
        // This table contains system user information.
        // A user is anyone who should have access to the system application
        // through a username and password. This is linked to the role table so administrator
        // can specify more fine-grained permissions for read, update and delete,
        // and to the module menu and global permissions for menu-level permissions. A
        // module can be created for more fine-grained access at the module level.
        if (module::execsql("CREATE TABLE game_user (".
            "user_id float NOT NULL auto_increment,".
            "user_lastname varchar(100) NOT NULL default '',".
            "user_firstname varchar(100) NOT NULL default '',".
            "user_middle varchar(100) NOT NULL default '',".
            "user_dob date NOT NULL default '0000-00-00',".
            "user_gender char(1) NOT NULL default '',".
            "user_role varchar(5) NOT NULL default '',".
            "user_admin char(1) NOT NULL default '',".
            "user_login varchar(10) NOT NULL default '',".
            "user_password varchar(32) NOT NULL default '',".
            "user_lang varchar(10) NOT NULL default 'english',".
            "user_email varchar(100) default '',".
            "user_cellular varchar(100) NOT NULL default '',".
            "user_pin varchar(4) NOT NULL default '',".
            "user_active char(1) NOT NULL default '',".
            "PRIMARY KEY  (user_id)".
            ") TYPE=InnoDB;")) {
            print "<font color='BLUE'>GAME_USER table created...</font><br>";
        }

        // game user content
        module::execsql("INSERT INTO game_user VALUES (1,'User','Admin','','0000-00-00','','','Y','admin','43e9a4ab75570f5b','english','','','','Y');");

        // table: location
        // This table interacts with permission system to specify module access
        // per given location. A location entity is typical of health care enterprise
        // systems.
        if (module::execsql("CREATE TABLE location (".
            "location_id varchar(10) NOT NULL default '',".
            "location_name varchar(50) NOT NULL default '',".
            "PRIMARY KEY  (location_id)".
            ") TYPE=InnoDB;")) {
            print "<font color='BLUE'>LOCATION table created...</font><br>";
        }

        // location content
        module::execsql("INSERT INTO location VALUES ('ADM','Admissions');");
        module::execsql("INSERT INTO location VALUES ('CONS','Consultations');");
        module::execsql("INSERT INTO location VALUES ('LAB','Laboratory');");
        module::execsql("INSERT INTO location VALUES ('TX','Treatment');");

        // table: module_dependencies
        // This table takes care of tracking module dependencies as
        // the central table. Dependencies are specified at the module
        // level through module::set_dep().
        if (module::execsql("CREATE TABLE module_dependencies (".
            "module_id varchar(25) NOT NULL default '',".
            "req_module varchar(25) NOT NULL default '',".
            "PRIMARY KEY  (module_id,req_module),".
            "CONSTRAINT `foreign` FOREIGN KEY (`module_id`) REFERENCES `modules` (`module_id`) ON DELETE CASCADE ON UPDATE CASCADE".
            ") TYPE=InnoDB;")) {
            print "<font color='BLUE'>MODULE_DEPENDENCIES table created...</font><br>";
        }

        // table: module_menu
        // This table stores menu information for each module. Modules
        // specify their own menus.
        if (module::execsql("CREATE TABLE module_menu (".
            "menu_id int(11) NOT NULL auto_increment,".
            "module_id varchar(25) NOT NULL default '0',".
            "menu_cat varchar(10) NOT NULL default '',".
            "menu_title varchar(20) NOT NULL default '',".
            "menu_rank int(11) NOT NULL default '0',".
            "menu_visible char(1) NOT NULL default 'Y',".
            "menu_action varchar(100) NOT NULL default '',".
            "PRIMARY KEY  (menu_id,module_id),".
            "UNIQUE KEY ukey_modulemenu (module_id,menu_action),".
            "KEY key_module (module_id),".
            "CONSTRAINT `module_menu_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `modules` (`module_id`) ON DELETE CASCADE".
            ") TYPE=InnoDB;")) {
            print "<font color='BLUE'>MODULE_MENU table created...</font><br>";
        }

        // table: module_menu_location
        // This table is a bridge entity between menu and location
        if (module::execsql("CREATE TABLE module_menu_location (".
            "location_id varchar(10) NOT NULL default '',".
            "module_id varchar(25) NOT NULL default '',".
            "menu_id int(11) NOT NULL default '0',".
            "PRIMARY KEY  (location_id,menu_id,module_id),".
            "KEY key_menu (menu_id),".
            "KEY key_module (module_id),".
            "KEY key_location (location_id),".
            "CONSTRAINT `module_menu_location_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `modules` (`module_id`) ON DELETE CASCADE,".
            "CONSTRAINT `module_menu_location_ibfk_2` FOREIGN KEY (`location_id`) REFERENCES `location` (`location_id`) ON DELETE CASCADE,".
            "CONSTRAINT `module_menu_location_ibfk_3` FOREIGN KEY (`menu_id`) REFERENCES `module_menu` (`menu_id`) ON DELETE CASCADE".
            ") TYPE=InnoDB;")) {
            print "<font color='BLUE'>MODULE_MENU_LOCATION table created...</font><br>";
        }

        // table: module_menu_permissions
        // This table is a bridge entity and stores information about
        // what menus are available for each game user.
        if (module::execsql("CREATE TABLE module_menu_permissions (".
            "module_id varchar(25) NOT NULL default '',".
            "menu_id float NOT NULL default '0',".
            "user_id float NOT NULL default '0',".
            "PRIMARY KEY  (module_id,menu_id,user_id),".
            "KEY key_module (module_id),".
            "KEY key_menu (menu_id),".
            "KEY key_user (user_id),".
            "CONSTRAINT `module_menu_permissions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `game_user` (`user_id`) ON DELETE CASCADE".
            ") TYPE=InnoDB;")) {
            print "<font color='BLUE'>MODULE_MENU_PERMISSIONS table created...</font><br>";
        }

        // table: module_permissions
        // This table is a bridge entity and stores module level permissions per user.
        if (module::execsql("CREATE TABLE module_permissions (".
            "module_id varchar(25) NOT NULL default '0',".
            "user_id float NOT NULL default '0',".
            "PRIMARY KEY  (module_id,user_id),".
            "KEY key_module (module_id),".
            "KEY key_user (user_id),".
            "CONSTRAINT `module_permissions_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `modules` (`module_id`) ON DELETE CASCADE".
            ") TYPE=InnoDB;")) {
            print "<font color='BLUE'>MODULE_PERMISSIONS table created...</font><br>";
        }

        // table: module_user_location
        // This table is a bridge entity and tracks which users are at what location
        if (module::execsql("CREATE TABLE module_user_location (".
            "location_id varchar(10) NOT NULL default '',".
            "user_id float NOT NULL default '0',".
            "PRIMARY KEY  (location_id,user_id),".
            "KEY key_user (user_id),".
            "KEY key_location (location_id),".
            "CONSTRAINT `module_user_location_ibfk_1` FOREIGN KEY (`location_id`) REFERENCES `location` (`location_id`) ON DELETE CASCADE,".
            "CONSTRAINT `module_user_location_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `game_user` (`user_id`) ON DELETE CASCADE".
            ") TYPE=InnoDB;")) {
            print "<font color='BLUE'>MODULE_USER_LOCATION table created...</font><br>";
        }

        // table: modules
        // This table stores module definitions
        if (module::execsql("CREATE TABLE modules (".
            "module_id varchar(25) NOT NULL default '',".
            "module_init char(1) NOT NULL default 'N',".
            "module_version varchar(25) default '',".
            "module_desc text NOT NULL,".
            "module_author varchar(50) NOT NULL default '',".
            "module_name varchar(100) NOT NULL default '',".
            "PRIMARY KEY  (module_id),".
            "UNIQUE KEY ukey_modules (module_name)".
            ") TYPE=InnoDB;")) {
            print "<font color='BLUE'>MODULES table created...</font><br>";
        }

        // table: role
        // This table stores role definitions
        if (module::execsql("CREATE TABLE role (".
            "role_id varchar(10) NOT NULL default '',".
            "role_dataaccess char(3) NOT NULL default '',".
            "role_name varchar(100) NOT NULL default '',".
            "PRIMARY KEY  (role_id)".
            ") TYPE=InnoDB;")) {
            print "<font color='BLUE'>ROLE table created...</font><br>";
        }

        // role content
        // NOTE: you change this to be more specific to your setting
        //
        module::execsql("INSERT INTO role VALUES ('BHW','110','Barangay Health Worker');");
        module::execsql("INSERT INTO role VALUES ('MD','111','Physician');");
        module::execsql("INSERT INTO role VALUES ('MWIFE','110','Midwife');");
        module::execsql("INSERT INTO role VALUES ('RN','110','Nurse');");
        module::execsql("INSERT INTO role VALUES ('LABAIDE','110','Lab Aide');");

        // table: terms
        // this is the multilingualization table
        if (module::execsql("CREATE TABLE terms (".
            "termid varchar(50) NOT NULL default '',".
            "languageid varchar(10) NOT NULL default '',".
            "langtext text,".
            "remarks text,".
            "translationof varchar(50) default NULL,".
            "module_id varchar(25) NOT NULL default '',".
            "isenglish char(1) NOT NULL default 'Y',".
            "PRIMARY KEY  (termid,languageid)".
            ") TYPE=MyISAM;")) {
            print "<font color='BLUE'>TERMS table created...</font><br>";
        }

        if (module::execsql("set foreign_key_checks=1;")) {
            print "<font color='BLUE'>FOREIGN KEY CHECKS ENABLED...</font><br>";
        }
    }

    /**
     * Parse XML
     * 
     * @todo explain the function
     */
    function parseXML($mvalues) {

        for ($i=0; $i<count($mvalues); $i++) {
            if (isset($mvalues[$i]["value"])) {
                $node[$mvalues[$i]["tag"]] = $mvalues[$i]["value"];
            }
        }
        if (isset($node)) {
            return ($node);
        }
    }

    /**
     * Read Configuration
     * 
     * read the xml database
     * @param string $filename
     * @return array $tdb values from the configuartion file 
     */
    function readconfig($filename) {
        $data = implode("",file($filename));
        $parser = xml_parser_create();
        xml_parser_set_option($parser,XML_OPTION_CASE_FOLDING,0);
        xml_parser_set_option($parser,XML_OPTION_SKIP_WHITE,1);
        xml_parse_into_struct($parser,$data,$values,$tags);
        xml_parser_free($parser);

        // loop through the structures
        foreach ($tags as $key=>$val) {
            if ($key == "db") {
                $noderanges = $val;
                // each contiguous pair of array entries are the
                // lower and upper range for each node definition
                for ($i=0; $i < count($noderanges); $i+=2) {
                    $offset = $noderanges[$i] + 1;
                    $len = $noderanges[$i + 1] - $offset;
                    $tdb[] = $this->parseXML(array_slice($values, $offset, $len));
                }
            } else {
                continue;
            }
        }
        return $tdb;
    }

    /** 
     * Backup Database
     * 
     * intentionally empty function
     * @todo create the function
     */
    function backup_database() {
    }

// end of class
}

?>
