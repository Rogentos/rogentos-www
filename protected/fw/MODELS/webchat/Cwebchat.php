<?php
class Cwebchat{

    var $C;               //main object
    var $nameF;
    var $LG;
    function DISPLAY(){

        $LG = $this->LG;
//        $path = publicPath."MODELS/webchat/RES/{$LG}/".$this->nameF.'.html';
        $path = $this->C->GET_resPath();
        if(file_exists($path))
             $pageContent = file_get_contents($path);
        else $pageContent = 'Nu exista continut la pagina <b>'.$path.'</b>';

        #_________________________________________________________________

        $display ="
                    <div class='SING webchat' id='webchat_$LG'>
                        <div class='EDeditor webchat'>
                            $pageContent

                        </div>
                    </div>
                    <iframe src='http://webchat.freenode.net/?channels=rogentos-dezvoltare' width='935' height='600'></iframe>
                   ";

        return  $display;
    }

    function  setINI() {}
    function __construct($C){

        $this->C = &$C;
        $this->LG = &$C->lang;
        $this->nameF = $this->C->nameF;

        $this->setINI();
    }
}
