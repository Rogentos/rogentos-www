<?php
/**
 * Author: Paul Cioanca
 * Author URI: cioan.ca
 * 2012
 */

$result = mysql_query("SELECT * FROM users");
echo '<h2>Users</h2>
<a href="index.php?umod=AddPage">Add user</a>
<ul>';
while($list = mysql_fetch_array($result)){
    echo '<li>
        '.$list["username"].' - <a href="?umod='.$list["ID"].'">Edit pass</a> | <a href="udelete.php?p='.$list["ID"].'">Delete</a>
        </li>';
}
echo '</ul>';

?>