<?php
$_SESSION["dbname"] = "game";
$_SESSION["dbuser"] = "root";
$_SESSION["dbpass"] = "";
$conn = mysql_connect("localhost", "root", "");
$db->connectdb("game");
?>