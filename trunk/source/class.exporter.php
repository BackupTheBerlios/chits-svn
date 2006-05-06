<?

/**
 * contains the module class
 *
 * @package module
 */

/**
 * @package module
 * @author Herman Tolentino,MD <herman.tolentino@gmail.com>
 * @author 
 * @version 0.01
 * @copyright Copyright 2006
 **/
class exporter extends module {

	function exporter() {
		$this->author = 'Herman Tolentino MD';
		$this->version = "0.01-".date("Y-m-d");
		$this->module = "exporter";
		$this->description = "CHITS Module - Exporter";
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
        module::set_lang("FTITLE_EXPORT_RECORDS", "english", "EXPORT RECORDS", "Y");
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

        module::set_menu($this->module, "Export Records", "SUPPORT", "_export");
        module::set_detail($this->description, $this->version, $this->author, $this->module);
	}

	/**
	 * Initilize SQL
	 */
	function init_sql() {
        if (func_num_args()>0) {
			$arg_list = func_get_args();
		}
	}

	/**
	 * Drop Tables
	 */
	function drop_tables() {

	}
	
	/**
	 * Main Exporter Function
	 */
	function _export(){
		if ($exitinfo = $this->missing_dependencies('module')) {
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
		print "<span class='library'>" . FTITLE_EXPORT_RECORDS . "</span><br/><br/>";
	}


}

?>