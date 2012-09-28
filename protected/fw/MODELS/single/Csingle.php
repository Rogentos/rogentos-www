<?php
class Csingle{

    var $C;               //main object
    var $nameF;
    var $LG;
    var $RESpath;

    function setDISPLAY() {
        if(isset($_POST['save_single']))
        {
            $content = $_POST['single_'.$this->LG];
            file_put_contents($this->RESpath,$content);
        }
    }
    function DISPLAY(){

        $LG = $this->LG;
        $idC = $this->C->idC;

        if(file_exists($this->RESpath))
             $pageContent = file_get_contents($this->RESpath);
        else
        {
            $pageContent = 'Nu exista continut la pagina <b>'.$this->RESpath.'</b>';
            file_put_contents($this->RESpath,$pageContent);
        }


        #_________________________________________________________________

        $display ="<div class='SING ALLpage' id='single_{$idC}_{$LG}'>
                        <div class='EDeditor single'>
                            $pageContent
                        </div>
                  </div>";

        return  $display;
    }

    function __construct($C){

      /*  $this->C = &$C;
        $this->LG = &$C->lang;
        $this->nameF = $this->C->nameF;
        */
      # $this->RESpath = publicPath."MODELS/single/RES/".$this->LG."/".$this->nameF.'.html';

      $C->GET_objREQ($this);

      $this->RESpath = $this->C->GET_resPath();

       $this->setDISPLAY();
    }
}