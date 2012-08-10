<?php
/**
 * Author: Paul Cioanca
 * Author URI: cioan.ca
 * 2012
 */

include "connect.php";

/**
 * creates menu with entries from DB
 */
function createMenu() {
    $query = 'SELECT * FROM pages ORDER BY menuOrder';
    $limit = true;
    $result = mysql_query($query) or die ("Menu query failed: ".mysql_error());
    echo '<div id="menu"> <ul id="menu">';
    while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
        if ( (!isset($_GET["page"])||($_GET["page"]===$line["ID"]) )&& $limit) {
            echo '<li class="active">';
            $limit = false;
        }
        else echo '<li>';
        echo '<a href="?page='.$line["ID"].'">'.$line["Name"].'</a>
           </li>';
    }
    echo '</ul></div>';
}

class siteSettings {
    private $sitename;
    private $description;
    private $footer;
    private $headerimg;
    function __construct() {
        $query = 'SELECT * FROM settings';
        $result = mysql_query($query);
        while ($line = mysql_fetch_array($result, MYSQL_ASSOC))
            $this->$line['option'] = $line['ovalue'];
    }
    function getName() {
        return $this->sitename;
    }
    function getDescription() {
        return $this->description;
    }
    function getFooter() {
        return $this->footer;
    }
    function getHeaderImg() {
        return $this->headerimg;
    }
}
$siteSetting = new siteSettings();

/**
 * class to record post data from DB
 */
class postText {
    private $Name;
    private $Text;
    function __construct($url=false) {
        $query = 'SELECT * FROM pages';
        if ($url) $query .=" WHERE ('".mysql_real_escape_string($url)."'=ID)";
        $query .=" ORDER BY menuOrder LIMIT 1";
        $result = mysql_query($query) or die ("Page text query failed: ".mysql_error());
        $result = mysql_fetch_array($result, MYSQL_ASSOC);
        if (!empty($result["Text"]) ){
            $this->Text = $result["Text"];
            $this->Name = ucfirst($result["Name"]);
        }
        else {
            $this->Text = "<center><h1>Page not found</h1></center>";
            $this->Name = "Page not found";
        }
    }
    function Display() {
        echo $this->Text;
    }
    function getTitle() {
        return  $this->Name;
    }
}
$post = isset($_GET['page'])?new postText($_GET['page']):new postText();
?>