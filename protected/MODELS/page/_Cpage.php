<?php
class Cpage{

    var $C;               //main object
    var $nameF;
    var $LG;
    function DISPLAY(){

        $LG = $this->LG;
        $path = publicPath."MODELS/page/RES/{$LG}/".$this->nameF.'.html';
        if(file_exists($path))
             $pageContent = file_get_contents($path);
        else $pageContent = 'Nu exista continut la pagina <b>'.$path.'</b>';

        #_________________________________________________________________
        $display = $this->C->CHILDREN_display->DISPLAY();
        $display .="<div id='page_content'>$pageContent</div>";

        return  $display;
    }

    function __construct($C){

        $this->C = &$C;
        $this->LG = &$C->lang;
        $this->nameF = $this->C->nameF;
    }
}