<?php
/**
 * Author: Paul Cioanca
 * Author URI: cioan.ca
 * 2012
 */

include "../connect.php";
$result = mysql_query("SELECT * FROM pages") or die (mysql_error());
echo '<h2>Pages</h2>
<a href="index.php?mod=AddPage">Add page</a>
<ul>';
while($list = mysql_fetch_array($result, MYSQL_ASSOC)){
   echo '<li>
        '.ucfirst($list["Name"]).' - <a href="?mod='.$list["ID"].'">Edit</a> | <a href="delete.php?p='.$list["ID"].'">Delete</a>
        </li>';
}
echo '</ul>';
?>