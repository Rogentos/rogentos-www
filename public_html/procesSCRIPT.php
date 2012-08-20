<?php


if(isset($_POST['parsePOSTfile']))
{
    require_once('../protected/GENERAL/config.php');

    require incPath.'GENERAL/classLoader.inc';
    spl_autoload_register(array(ClassLoader::getInstance(), 'loadClass'));

    require_once(incPath.$_POST['parsePOSTfile']);
   /* echo incPath.$_POST['parsePOSTfile'];*/
}

