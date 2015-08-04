<?php
class CTRL_TMP_CHANGES extends CHANGES
{

    function parseCHANGE()     {

        $this->set_pathsChange($_POST['action']);

        #===================================================================================================================

         $lastCHANGES = (isset($_POST['but_ol']) ?   $_POST['but_ol'] :    $this->ARRchanges  );  #daca schimbarea este defapt updateTREE =>$_POST['but_ol'];
         $changes     = $this->{'TMP_'.$this->change}($lastCHANGES);                                    #procesez schimbarea


        #===================================================================================================================
            file_put_contents($this->changePATH, serialize($changes) );                   #serializez si retin toate schimbarile in fisier
            file_put_contents($this->TESTchangePATH, $this->TMP_testMes);


    }

    function __construct()     {
        $this->set_pathChanges();


        if(isset($_POST['action']))        $this->parseCHANGE();    # actiune trimisa de GEN_edit.js - la  schimbarea listei sau a elementelor din ea
        if(isset($_POST['deleteCHANGES'])) $this->deleteCHANGES();  # RESET_changes - prima actiune trmisa de GEN_edit.js  - trmisa la instantierea lui
    }

}
