<?php
class ACpage extends Cpage
{
    function setINI()
    {
        if($_POST['save_FULLpage'])
        {echo $_POST['page_en']."<br/>"; unset($_POST);}
    }
}