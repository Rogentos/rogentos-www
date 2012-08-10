<?php
/**
 * Author: Paul Cioanca
 * Author URI: cioan.ca
 * 2012
 */
include "../connect.php";
if(isset($_POST["postName"])){
    $postName = mysql_real_escape_string($_POST["postName"]);
    $postText = $_POST["postText"];
    if(isset($_POST['edit'])){
        $id = $_POST['edit'];
        mysql_query("UPDATE `pages` SET `Name`='$postName', `Text`='$postText' WHERE `ID`='$id'") or die(mysql_error());
    }
    else mysql_query("INSERT INTO `pages` (`Name`, `menuOrder`, `Text`) VALUES ('$postName', '10', '$postText')") or die(mysql_error());
    header("Location: ../admin?page=ok");
}
