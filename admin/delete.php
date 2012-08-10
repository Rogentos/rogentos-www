<?php
/**
 * Author: Paul Cioanca
 * Author URI: cioan.ca
 * 2012
 */

include "../connect.php";
if(isset($_GET["p"])){
    $url=mysql_real_escape_string($_GET["p"]);
    mysql_query("DELETE FROM `pages` WHERE `ID`='$url'") or die(mysql_error());
    header("Location: ../admin?page=ok");
}
header("Location: ../admin");