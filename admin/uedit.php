<?php
/**
 * Author: Paul Cioanca
 * Author URI: cioan.ca
 * 2012
 */
if(isset($_GET['umod'])){
    if($_GET['umod']==='AddPage')
        echo '<h2>Add new user</h2>
              <form action="userOP.php" method="post">
                  Username: <input type="text" name="username" /><br />
                  Password: <input type="password" name="password" /><br />
              <input type="submit" value="Submit" />
              </form>';
    else echo '<h2>Edit user password</h2>
              <form action="userOP.php" method="post">
                  New password:  <input type="password" name="password" />
              <input type="submit" value="Submit changes" />
              <input type="hidden" name="edit" value="'.$_GET['umod'].'" />
              </form>';
}
?>