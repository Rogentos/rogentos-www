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

    public function ADDbuttons($buttonSTR)
    {
        array_push($this->buttons,$buttonSTR);
    }

    function DISPLAY()
    {
        //_____________________________________[Setting buttons]__________________
        $disp = "<div id='admin_TOOLbar'>";
            foreach($this->buttons as $button)
                $disp .= "<span>{$button}</span>";
        $disp .="</div>";
        //________________________________________________________________________



        $disp .="<div id='admin_POPUP'>
                    <div id='CLOSE_admin_POPUP'>
                        <form action='' method='post'>
                                <input type='submit' name='close_adminPOPUP' value='close' class='Tbar_but' />
                        </form>
                        <input type='button' value='x' onclick=\"CLOSE_admin_POPUP()\" class='Tbar_but' />
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




       /* $this->dispPATH = publicPath.'PLUGINS/TOOLbar/RES/TOOLbar.html';
        if(!file_exists($this->dispPATH)) $this->getDISPLAY();*/
    }
}