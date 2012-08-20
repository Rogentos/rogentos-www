<?php


class CTRL_CHANGES
{
    var $actions = array( 'updateITEM', 'seoITEM','addNewITEM', 'deleteITEM', 'updateTREE');


    var $pathChanges;
    var $lastCHANGES = array();
    var $serializedCHANGES;
    var $testCHANGES;
    var $action ;


    function updateTREE($ol,&$mes='',&$tree='', $Pid=-1, $t='') {

        //___________________________________________________________________________________
        $mes .= "\n ";
        foreach($ol AS $poz=>$id_ch)
        {
            $id =  $id_ch['id'];


            if($Pid == -1)
            {

                $mes .="\n ".'Meniul '.$id.' ';
                $tree[$id] = array();
                if($id_ch['children'])$this->updateTREE($id_ch['children'],$mes,$tree[$id], 0,'');

            }
            else
            {
                 $mes .= "\n ".$t;
                 $mes .='id-ul = '.$id.' ';
                 $mes .=' si Pid-ul = '.$Pid.' ';
                 $mes .=' si cu poz = '.$poz;

                 $tree[$id]['pid'] = $Pid;
                 $tree[$id]['poz'] = $poz;


                 if(isset($id_ch['children'])) $this->updateTREE($id_ch['children'],$mes,$tree, $id, $t."\t");
            }

        }

        if($Pid==-1)
        {
            $mes .="\n \n".'Si acum vectorul';
            foreach($tree as $menuName=>$menu)
            {
                $mes .= "\n \n".'Meniul '.$menuName;
                foreach($menu as $id=>$item)
                    $mes .="\n ".'id-ul = '.$id.' is Pid = '.$item['pid'].' cu poz='.$item['poz'];

            }


           //_____________________________________________________________________________________

            return $tree;

           /* file_put_contents('TESTtree.txt','Am primit un POST'."\n\n".$mes);
            file_put_contents('TREE.txt',serialize($tree));*/
        }

    }

    function updateITEM($updated,&$mes)     {

        $id   = $_POST['id'];
        $val  = $_POST['val'];
        $type = $_POST['type'];

        $updated[$id]['val']  = $val;
        $updated[$id]['type'] = $type;

     #_______________________________________________[ TEST mes]________________________________________________________
        $mes = "Au fost updatate \n";
        foreach($updated as $id => $detail)
           $mes .='id = '.$id.' val='.$detail['val'].' type='.$detail['type']."\n";
    #___________________________________________________________________________________________________________________


        return $updated;

/*        $serUpdated = serialize($updated);
        file_put_contents('updated.txt',$serUpdated);
        file_put_contents('TESTupdated.txt',$mes);*/
    }
    function seoITEM($seo,&$mes)            {

        $id   = $_POST['id'];


        $seo[$id]['title_tag']        = $_POST['title_tag'];
        $seo[$id]['title_meta']       = $_POST['title_meta'];
        $seo[$id]['description_meta'] = $_POST['description_meta'];
        $seo[$id]['keywords_meta']    = $_POST['keywords_meta'];



     #_______________________________________________[ TEST mes]________________________________________________________
        $mes = "Au fost updatate \n";
        foreach($seo as $id => $det)
           $mes .= "\n id = ".$id.
                   "\n title_tag       = ".$det['title_tag'].
                   "\n title_meta      = ".$det['title_meta'].
                   "\n description_meta= ".$det['description_meta'].
                   "\n keywords_meta   = ".$det['keywords_meta'].
                  "\n";
    #___________________________________________________________________________________________________________________


        return $seo;
    }
    function addNewITEM($added,&$mes)       {

        $id = $_POST['id'];
        $val = $_POST['val'];
        $type = $_POST['type'];

        $added[$id]['val'] = $val;
        $added[$id]['type'] = $type;


        //_____________________________________________________________________________________
        $mes = "Au fost adaugate \n ";
        foreach($added as $id => $detail)
           $mes .='id = '.$id.' val='.$detail['val'].' type='.$detail['type']."\n";


        //_____________________________________________________________________________________

        return $added;

      /*  file_put_contents('TESTadded.txt',$mes);
        $serAdded = serialize($added);
        file_put_contents('added.txt',$serAdded);*/
    }
    function deleteITEM($deleted, &$mes)    {
        $id = $_POST['id'];


        $deleted[$id] = true;

        //_____________________________________________________________________________________
        $mes = "Au fost deletate \n ";
        foreach($deleted as $id => $detail)
           $mes .='id = '.$id."\n";


        //_____________________________________________________________________________________

        return $deleted;
    }

#_______________________________________________________________________________________________________________________
#***********************************************************************************************************************






    function actionPATH()      {
        return $this->pathChanges.$this->action.'.txt';
    }    #publicPath.'MODULES/GEN_edit/RES/changes/[change_name].txt'
    function TESTactionPATH()  {
        return  $this->pathChanges.'TEST'.$this->action.'.txt';
    }    #publicPath.'MODULES/GEN_edit/RES/changes/TEST[change_name].txt'

    function parseCHANGE()     {

        $TESTmes =''; $lastCHANGES =array();
     #__________________________________________________________________________________________________________________
        $this->action = $_POST['action'];

        if(isset($_POST['but_ol'])) $lastCHANGES = $_POST['but_ol'];                   #daca schimbarea este defapt updateTREE =>$_POST['but_ol'];
        else
            if(file_exists( $this->actionPATH() ))
             $lastCHANGES  = unserialize(file_get_contents( $this->actionPATH() ));    #daca exista deja schimbari le preiau

    #===================================================================================================================

        $changes = $this->{$this->action}($lastCHANGES,$TESTmes);                      #procesez schimbarea
    #___________________________________________________________________________________________________________________


        file_put_contents($this->actionPATH(),serialize($changes));                   #serializez si retin toate schimbarile in fisier
        file_put_contents($this->TESTactionPATH(), $TESTmes);


    }
    function deleteCHANGES()   {

        foreach($this->actions AS $action){
            if(file_exists( $this->pathChanges.$action.'.txt')){
                unlink( $this->pathChanges.$action.'.txt');
                unlink( $this->pathChanges.'TEST'.$action.'.txt');
            }

        }



    }

    function __construct()     {
        $this->pathChanges = publicPath.'MODULES/GEN_edit/RES/changes/';

        if(isset($_POST['action']))
            $this->parseCHANGE();    # actiune trimisa de GEN_edit.js - la  schimbarea listei sau a elementelor din ea
        if(isset($_POST['deleteCHANGES'])) $this->deleteCHANGES();  # RESET_changes - prima actiune trmisa de GEN_edit.js  - trmisa la instantierea lui
    }

}


$iniParsePost = new CTRL_CHANGES();









/*
           '0' ...
               'id' => "1"
           '1' ...
               'id' => "2"
               'children' ...
                   '0' ...
                       'id' => "3"
                   '1' ...
                       'id' => "4"
                   '2' ...
                       'id' => "5"
                   '3' ...
                       'id' => "6"
           '2' ...
               'id' => "7"
           '3' ...
               'id' => "8"
           '4' ...
               'id' => "9"
           '5' ...
               'id' => "10"
               'children' ...
                   '0' ...
                       'id' => "11"
                   '1' ...
                       'id' => "12"
                   '2' ...
                       'id' => "13"
                   '3' ...
                       'id' => "14"
           '6' ...
               'id' => "15"
           '7' ...
               'id' => "16"*/