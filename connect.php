<?php
/**
 * Auto-generated file that contains instructions for connecting to the database
 * TODO: Auto-generate
 */
$con = mysql_connect("localhost","koltzu_rogentos","rgntspass");
if (!$con)
    die('Could not connect: ' . mysql_error());
mysql_select_db('koltzu_rogentos') or die("Could not select DB");
mysql_query("SET NAMES utf8");
?>