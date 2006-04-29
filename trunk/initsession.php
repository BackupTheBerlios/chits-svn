<?
/**
*
*   Initialize session variables here
*   Make sure register_globals is Off in php.ini
*
**/
if (!isset($SESSION["user_lang"])) {
    session_register("myencoding");
    session_register("user_lang");
    $_SESSION["user_lang"] = "english";
    $_SESSION["myencoding"] = "iso-8859-1";
}
if (!isset($_SESSION["mainparam"])) {
    $_SESSION["mainparam"] = "";
}
if (!isset($_SESSION["validuser"])) {
    $_SESSION["validuser"] = 0;
}
if (!isset($_SESSION["db"])) {
    $_SESSION["db"] = "";
}
if (!isset($_SESSION["dbname"])) {
    $_SESSION["dbname"] = "";
}
if (!isset($_SESSION["dbuser"])) {
    $_SESSION["dbuser"] = "";
}
if (!isset($_SESSION["dbpass"])) {
    $_SESSION["dbpass"] = "";
}
if (!isset($_SESSION["userid"])) {
    $_SESSION["userid"] = "";
}
if (!isset($_SESSION["isadmin"])) {
    $_SESSION["isadmin"] = false ;
}
if (!isset($_SESSION["gamedb"])) {
    $_SESSION["gamedb"] = "";
}
if (!isset($_SESSION["datanode"])) {
    $_SESSION["datanode"] = array();
}
if (!isset($_SESSION["chits_debug"])) {
    $_SESSION["chits_debug"] = false;
}
if (!isset($_SESSION["patient_id"])) {
    $_SESSION["patient_id"] = 0;
}
if (!isset($_SESSION["consult_id"])) {
    $_SESSION["consult_id"] = 0;
}
if (!isset($_SESSION["recordlevel"])) {
    $_SESSION["recordlevel"] = "";
}
if (!isset($_SESSION["user_role"])) {
    $_SESSION["user_role"] = "";
}
?>
