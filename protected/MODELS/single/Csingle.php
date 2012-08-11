<?php
class Csingle{

    var $C;               //main object
    var $nameF;
    var $LG;
    function DISPLAY(){

        $LG = $this->LG;
        $path = publicPath."MODELS/single/RES/{$LG}/".$this->nameF.'.html';
        if(file_exists($path))
             $pageContent = file_get_contents($path);
        else $pageContent = 'Nu exista continut la pagina <b>'.$path.'</b>';

        #_________________________________________________________________

        $display ="
                    <div class='SING single' id='single_$LG'>
                        <div class='EDeditor page'>
                            $pageContent

                        </div>
                    </div>
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
