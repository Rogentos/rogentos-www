<?php
/**
 * Author: Paul Cioanca
 * Author URI: cioan.ca
 * 2012
 */
    session_start();
    include '../connect.php';
    if(!isset($_GET['logout'])){
        $password = md5( mysql_real_escape_string($_POST['password']));
        $username =  mysql_real_escape_string($_POST['username']);
        $result = mysql_query("SELECT * FROM `users` where `username`='$username' AND `password`='$password'");
        if(mysql_num_rows($result)===1){
           $_SESSION['isLogged'] = True;
           header('Location: index.php');
           exit();
        } else
           header('Location: index.php?v=1');
    }
    else {
        session_start();
        $_SESSION['isLogged'] = False;
        header( 'Location: ../index.php' ) ;
    }
?>