<?
// PHP module: process_module.php
// Author: Herman Tolentino MD
// Version 0.1
//
// this file handles module activation
// after loading
//
$sql = "select module_name from modules order by module_name";
if ($result = mysql_query($sql)) {
    if (mysql_num_rows($result)) {
        while (list($module_name) = mysql_fetch_array($result)) {
            if (file_exists("../modules/".$module_name."/class.".$module_name.".php")) {
                include "../modules/".$module_name."/class.".$module_name.".php";
                $$module_name = new $module_name;
                // 
                if (!$module->activated("$module_name") && $_GET["initmod"]==1) {
                    $$module_name->init_sql();
                    $$module_name->init_menu();
                    $$module_name->init_deps();
                    $$module_name->init_lang();
                    $$module_name->init_help();
                }
            }
        }
    }
}
?>