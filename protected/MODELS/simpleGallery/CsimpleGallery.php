<?php
class CsimpleGallery{

    var $C;               //main object
    var $nameF;
    var $LG;

    var $imgDir = 'RES/';
    var $picsOnPage = 12;
    var $extensions = 'png|jpg|jpeg';
    var $thumbSizeX = 200;
    var $thumbSizeY = 200;

    var $sessionStorage = TRUE;



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

    function imgFilter($filename) {
        if(preg_match('/\.('.$this->extensions.')$/i',$filename) == 1)
            return $filename;
        else
            return FALSE;
    }

    function readImages() {
        $filelist = scandir($this->imgDir);
        array_filter($filelist,array($this, 'imgFilter'));
    }

    function  setINI() {}
    function __construct($C){

        $this->C = &$C;
        $this->LG = &$C->lang;
        $this->nameF = $this->C->nameF;

        $this->setINI();

        $this->imgDir = publicPath.'MODELS/simpleGallery/'.$this->imgDir;

    }
}
