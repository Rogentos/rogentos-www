<?php
/*
spl_autoload_register(
    function($className) {
        require($className.'.php');
    }
);
*/

require incPath.'GENERAL/classLoader.inc';
require_once(incPath.'GENERAL/vars.php');
spl_autoload_register(array(ClassLoader::getInstance(), 'loadClass'));

/*if($_POST['log_out']){
    unset($_SESSION['user']);
    session_destroy();
    unset($_POST);
}*/

$log = new logmein(dbHost,dbName,dbUser,dbPass);
$log->encrypt = true; //set encryption

if(strlen($_POST['password']) > 0){
    if($log->login("logon", $_POST['username'], $_POST['password']) == true)
    {
        $_SESSION['admin']=1;
        //echo '<p style="color:darkgreen; text-align:center; width:100%;">Logged in: '.$_SESSION['username'].'</p>';
    }
    else
    {
        unset($_SESSION['admin']);
        echo '<p style="color:red; text-align:center; width:100%;">Login failed! What have you done?!</p>';
    }
}



if(isset($_GET['logOUT']))
{
    unset($_SESSION);
    session_destroy();
}



if($_SESSION['admin'])
{
    /*$CAD = new CAsetINI($user);*/
    $CAD = new ACsetINI();
}
else {
    $CAD = new CsetINI();
}