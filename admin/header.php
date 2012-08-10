<?php
/**
 * Author: Paul Cioanca
 * Author URI: cioan.ca
 * 2012
 */

/**
 * Loads stylesheet and sets title
 */

echo '<html><head>
        <title>'.$siteSetting->getName().' - Administration panel</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="style.css" />
        <script type="text/javascript" src="../ckeditor/ckeditor.js"></script>
        </header>';
echo '<body><div id="menu">
        <a href="../"><img src="../'.$siteSetting->getHeaderImg().'" width="100px"/></a>
        <dl>
			<dt><a href="index.php">Pages</a></dt>';
            createMenu();
echo '<li><a href="?page=settings">Settings</a></li>
      <li><a href="?page=users">Users</a></li>
      <li><a href="login.php?logout=yes">Logout</a></li>
		</dl>
        </div>';
?>