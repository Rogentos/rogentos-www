<?php


if(isset($_POST['parsePOSTfile']))
{
    require_once('../protected/fw/GENERAL/config.local.php');

    require fw_incPath.'GENERAL/classLoader.inc';
    spl_autoload_register(array(ClassLoader::getInstance(), 'loadClass'));

    require_once(fw_incPath.$_POST['parsePOSTfile']);
   /* echo fw_incPath.$_POST['parsePOSTfile'];*/
}

