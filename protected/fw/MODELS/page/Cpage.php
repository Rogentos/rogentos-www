<?php
class Cpage{

    var $C;               //main object
    var $nameF;
    var $LG;
    function DISPLAY(){

        $LG = $this->LG;
        $idC = $this->C->idC;

       # $path = publicPath."MODELS/page/RES/{$LG}/".$this->nameF.'.html';
       # C->GET_resPath($type_MOD='',$resName='', $mod_name='' ,$nameF='', $lang = '')
        $path        = $this->C->GET_resPath('','','page',$this->nameF);
        $pageContent = $this->C->GET_resContent($path);


        #_________________________________________________________________
        $display = $this->C->CHILDREN_display->DISPLAY();
        $display .="<div class='pageCont'>
                         <div class='SING FULLpage' id='FULLpage_{$idC}_{$LG}'>
                             <div class='EDeditor page'>   $pageContent </div>
                         </div>
                    </div>";

        return  $display;
    }

    function setINI(){ }
    function __construct($C){

        /*$this->C = &$C;
        $this->LG = &$C->lang;
        $this->nameF = $this->C->nameF;*/

        $C->GET_objREQ($this);
        $this->setINI();

    }
}