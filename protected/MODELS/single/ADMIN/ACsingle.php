<?php
class ACsingle extends Csingle
{


    function setINI(){

        if(isset($_POST['save_single']))
        {

            $LG = $this->C->lang;
            $file = publicPath.'MODELS/single/RES/'.$LG.'/'.$this->C->tree[$this->C->idC]->nameF.'.html';

            file_put_contents($file,$_POST['page_en']);

            #____________________________________________________________________
             unset($_POST);
           //  header("Location: ".$_SERVER['REQUEST_URI']);
            // exit;


        }
    }


}