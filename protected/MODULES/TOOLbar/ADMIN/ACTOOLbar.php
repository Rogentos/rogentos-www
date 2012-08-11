<?php
class ACTOOLbar
{
    var $C;               //main object
    var $lang;
    var $lang2;
    var $dispPATH ='';

    var $buttons = array(
        "<a href='index.php?logOUT=1' id='logOUT'>Log OUT</a>"
    );

    var $info = array();

    public function ADDbuttons($buttonSTR)
    {
        array_push($this->buttons,$buttonSTR);
    }

    public function ADDinfo($STR)
    {
        array_push($this->info,$STR);
    }

    function DISPLAY()
    {
        //_____________________________________[Setting buttons]__________________
        $disp = "<div id='admin_TOOLbar'>";
        $disp .= "<table><tr><td>";
            foreach($this->info as $info)
                $disp .= "<span class='info'>{$info}</span>";
        $disp .= "</td><td>";
            foreach(array_reverse($this->buttons) as $button)
                $disp .= "<span class='button'>{$button}</span>";
        $disp .= "</td></tr></table>";
        $disp .="</div>";
        //________________________________________________________________________



        $disp .="<div id='admin_POPUP'>
                    <div id='CLOSE_admin_POPUP'>
                        <form action='' method='post'>
                                <input type='submit' name='close_adminPOPUP' value='close' />
                        </form>
                        <input type='button' value='x' onclick=\"CLOSE_admin_POPUP()\" />
                    </div>
                    {$this->statusPOPUP}
                    <div id='admin_POPUP_content'>
                    </div>
                 </div>";

        return $disp;
       // file_put_contents($this->dispPATH,$disp);
    }
    function __construct($C)
    {
        $this->C = &$C;

        $this->lang = &$C->lang;
        $this->lang2 = &$C->lang2;

        $currentPOPUP = (isset($_POST['currentPOPUP']) ? $_POST['currentPOPUP'] : '');
        $this->statusPOPUP = "<input type='hidden' name='statusPOPUP' value='".$currentPOPUP."' />" ;

        $this->ADDinfo("<span class='info'>Logged in: ".$_SESSION['username']."</span>");


       /* $this->dispPATH = publicPath.'MODULES/TOOLbar/RES/TOOLbar.html';
        if(!file_exists($this->dispPATH)) $this->getDISPLAY();*/
    }
}