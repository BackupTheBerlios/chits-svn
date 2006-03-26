<?
class spctoolkit extends module {

    // Author: Herman Tolentino MD, Eman Calso
    // CHITS Project 2006
    // for module guidelines see MODULES.TXT
    // This module contains classes for statistical process
    // control.

    function spctoolkit() {
    //
    // constructor
    // do not forget to update version
    //
        $this->author = 'Herman Tolentino MD';
        $this->version = "0.1-".date("Y-m-d");
        $this->module = "spctoolkit";
        $this->description = "CHITS Module - SPC Toolkit";
    }

    // --------------- STANDARD MODULE FUNCTIONS ------------------

    function init_deps() {
    //
    // insert dependencies in module_dependencies
    //
        module::set_dep($this->module, "module");
        module::set_dep($this->module, "patient");
        module::set_dep($this->module, "notes");
    }

    function init_lang() {
    //
    // insert necessary language directives
    // NOTES:
    //

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

    }

    function drop_tables() {
    //
    // called from delete_module()
    //

    }

    // --------------- CUSTOM MODULE FUNCTIONS ------------------

}

class shewhart {
}

class cusum {
}
?>
