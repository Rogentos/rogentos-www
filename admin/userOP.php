<?php
/**
 * Author: Paul Cioanca
 * Author URI: cioan.ca
 * 2012
 */
include "../connect.php";
if(isset($_POST["password"])){
    $username = mysql_real_escape_string($_POST["username"]);
    $password = md5(mysql_real_escape_string($_POST["password"]));
    if(isset($_POST['edit'])){
        $id = $_POST['edit'];
        mysql_query("UPDATE `users` SET `password`='$password' WHERE `ID`='$id'") or die(mysql_error());
    }
    else mysql_query("INSERT INTO `users` (`username`, `password`) VALUES ('$username', '$password')") or die(mysql_error());
    header("Location: ../admin?page=ok");
}
