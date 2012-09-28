<?php
class ACwebchat extends Cwebchat
{


    function setINI(){

        if(isset($_POST['save_webchat']))
        {

            $LG = $this->C->lang;
            $file = publicPath.'MODELS/webchat/RES/'.$LG.'/'.$this->C->tree[$this->C->idC]->nameF.'.html';

            file_put_contents($file,$_POST['webchat_en']);

            #____________________________________________________________________
             unset($_POST);
           //  header("Location: ".$_SERVER['REQUEST_URI']);
            // exit;


        }
    }


}