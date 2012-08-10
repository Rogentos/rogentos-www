<?php
/**
 * Author: Paul Cioanca
 * Author URI: cioan.ca
 * 2012
 */

include "../connect.php";

function createMenu() {
    $query = 'SELECT * FROM pages ORDER BY menuOrder';
    $limit = true;
    $result = mysql_query($query) or die ("Menu query failed: ".mysql_error());
    while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
        echo '<dd>
                <a href="?mod='.$line["ID"].'">&nbsp;&nbsp;- '.ucfirst($line["Name"]).'</a>
           </dd>';
    }
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
        return $this->Text;
    }
    function getTitle() {
        return  $this->Name;
    }
}
if(isset($_GET['mod']))
    $post = new postText($_GET['mod']);
?>