<?php
/**
 * Author: Paul Cioanca
 * Author URI: cioan.ca
 * 2012
 */

/**
 * Loads stylesheet and sets title
 */

echo '<html>
    <head><title>'.$siteSetting->getName()." | ".$post->getTitle().'</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="style.css" />
        <link rel="stylesheet" type="text/css" href="normalize.css" />
        </head>';
/**
 * Loads banner and menu
 */
echo '<body><div id="header">
        <div id="logo"><a href="index.php"><img src="'.$siteSetting->getHeaderImg().'" /></a></div>';
        createMenu();
echo '</div>';
?>