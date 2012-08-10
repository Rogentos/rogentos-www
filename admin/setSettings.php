<?php
/**
 * Author: Paul Cioanca
 * Author URI: cioan.ca
 * 2012
 */
include "../connect.php";
if(isset($_POST["webname"])){
    $webname = mysql_real_escape_string($_POST["webname"]);
    $description = mysql_real_escape_string($_POST["description"]);
    $headerimg = mysql_real_escape_string($_POST["headerimg"]);
    $footer = $_POST["footer"];
    mysql_query("UPDATE `settings` SET ovalue='$webname' WHERE `option`='sitename'") or die(mysql_error());
    mysql_query("UPDATE `settings` SET ovalue='$description' WHERE `option`='description'") or die(mysql_error());
    mysql_query("UPDATE `settings` SET ovalue='$headerimg' WHERE `option`='headerimg'") or die(mysql_error());
    mysql_query("UPDATE `settings` SET ovalue='$footer' WHERE `option`='footer'") or die(mysql_error());
    header("Location: ../admin?page=ok");
}
