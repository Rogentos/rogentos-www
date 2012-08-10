<?php
/**
 * Author: Paul Cioanca
 * Author URI: cioan.ca
 * 2012
 */
session_start();
include 'functions.php';

if( isset($_SESSION['isLogged']) && $_SESSION['isLogged'] == True ){
include 'header.php';

echo '<div id="content">';
        if(isset($_GET['page']))
            switch($_GET['page']){
                case 'settings': include 'settings.php'; break;
                case 'users': include 'users.php'; break;
                case 'ok': echo '<h2>Operation accomplished</h2>'; break;
            }
        else if(isset($_GET['mod']))
                include "edit.php";
            else if(isset($_GET['umod']))
                include "uedit.php";
                  else include 'pages.php';
      echo '</div>
     </body></html>';
}
else { echo '<title>'.$siteSetting->getName().' - Login</title>';
       if(isset($_GET['v'])) echo '<center>Wrong username or password, try again.</center><br />';
       echo '
       <center><form action="login.php" method="post">
       Username: <input type="text" name="username" /><br />
       Password: <input type="password" name="password" /><br />
       <input type="submit" value="Log in " /></form></center>';
    }
?>