<?php

class CManage extends vars {


    public function SET_HISTORY($id,$concat='')    {
        if(isset($this->tree[$id]->p_id))$trueLEVEL = $this->SET_HISTORY($this->tree[$id]->p_id,"<span class='small9'>&gt;&gt;</span>");
        if($id)
        {

            array_push($this->history,$id);
            $backName  = $this->tree[$id]->name;
            $backNameF = str_replace(' ','_',$backName);

            $this->history_TITLE_keywords .= $backName.' ';
            $this->history_TITLE .= $backNameF.'/';

            #old href:    index.php?idC={$idT}&idT={$idT}&level=nr
            #newFormat:   idT-idC-L{level} / backName;

            $href = ($trueLEVEL==2 || $this->idT==1  ? '': "href='".$this->idT."-{$id}-L{$trueLEVEL}/$this->history_TITLE'");
            $this->history_HREF .="<a {$href}> $backName $concat </a>";

            return $trueLEVEL+1;
        }
        else return 1;


    }  /**
         * daca level=3 => 4-level = 1;
         *      level=2 => 4-2 = 2;
         *      level=1 => 4-1 = 3
         *
         * if(!p_id) =>level=1;
         * if(!$id) = > am ajuns la sfarsit
         */
    public function SET_HTML_headerIMG()           {

        $this->HTML_headerIMG = file_get_contents(fw_pubPath.'/GENERAL/RES/headerIMG.html');
    }
    public function GET_idT_from_idC($Cid)         {

            $res = $this->DB->query("SELECT Pid from TREE  where Cid='{$Cid}'");
            if($res->num_rows > 0)
            {
                $row=$res->fetch_assoc();

                if($row['Pid'] > 0)  { /* echo $row['Pid']; */  $this->GET_idT_from_idC($row['Pid']);}
                else $this->idT =  $Cid;
            }


        }
    public function ctrlDISPLAY($object_name)      {

           if(is_object($this->$object_name) && method_exists($this->$object_name,"DISPLAY"))
               return $this->$object_name->DISPLAY();


       }

    #===================================================================================================================
    public function GET_resPath($type_MOD='',$resName='', $mod_name='' ,$nameF='', $lang = '')  {

        # RULE: - 1 - numele fisierelor res :  RES / type_MOD / [mod_name]_nameF.html
        #       - 2 - daca nameF == mod_name   => numele fisierului res : [mod_name].html

        if(!$type_MOD)  $type_MOD  = 'MODELS';
        if(!$lang)     $lang      = $this->lang;

        if(!$resName)  # daca nu ii se da numele resursei va incerca sa o deduca din mod_name si nameF
        {
            if(!$mod_name) $mod_name  =  $this->type;
            if(!$nameF)    $nameF     =  (strtolower($this->nameF) == strtolower($mod_name) ? '' : $this->nameF);  # -2 -
            $resName   =  ($nameF ? $mod_name.'_'.$nameF   :  $mod_name);
        }
        $resName .='.html';


        return resPath.
                  $type_MOD.'/'.
                      $lang.'/'.
                        $resName;


    }

    public function GET_resContent($resPath)            {
         if(file_exists($resPath))
                 $pageContent = file_get_contents($resPath);
         else
         {
                $pageContent = 'Nu exista continut la pagina <b>'.$resPath.'</b>';
                file_put_contents($resPath,$pageContent);
         }
        return  $pageContent;
    }

    public function SET_resContent($resPath, $content)  {
        #nu stiu sigur daca avem nevoie
    }

    public function GET_objCONF($obj,$type_MOD, $mod_name,$admin='') {

        $file_ini = incPath.'etc/'.$type_MOD.'/'.$admin.$mod_name.'.ini';
        if(file_exists($file_ini))
        {
            $ini_array = parse_ini_file($file_ini);
            foreach($ini_array AS $var_name => $var_value)
                $obj->$var_name = $var_value;
        }

    }

    public function GET_objREQ($obj,$res=false,$conf=false)          {

        $obj->C = &$this;
        $obj->idC = &$this->idC;
        $obj->idT = &$this->idT;
        $obj->LG = &$this->lang;
        $obj->nameF = &$this->nameF;

        # i dont know if this is really necessary
        /*if($res) $obj->RESpath = $this->GET_resPath($this->type_MOD,
                                                    '',
                                                    $this->type,
                                                    $this->nameF,
                                                    $this->lang);

        if($conf) $this->GET_objCONF($obj,$this->type_MOD, $this->type);

        #TODO: atentie la admin!!!  */

    }






}
class CsetINI extends  CManage
{

#=============================================[ ESETIALS ]==============================================================

    public function SET_type()          {


           if($_REQUEST['type'])$this->type = $_REQUEST['type'];

       }
    public function SET_idTC()          {


        if(isset($_GET['idT']))
        {
               $this->idT =   $_GET['idT'];
               $this->idC = ( $_GET['idC'] ?  $_GET['idC'] : $this->idT );

                #======== ATENTIE !!! - EXCEPTIE  ================================================
                    if($this->idT == 1 && $this->idC!=1) $this->GET_idT_from_idC($this->idC);
                #======== ATENTIE !!! - EXCEPTIE  ================================================
               return true;
        }

        elseif($this->idC)  return true;

        else {return false; echo 'Nu am reusit sa iau treeul';}
    }
    public function SET_tree()          {

       $this->tree = unserialize(file_get_contents('./fw/GENERAL/RES_TREE/tree'.$this->idT.'.txt'));

       return ( $this->tree ?   true :  false );
    }
    public function SET_ID_item()       {

        /**
         * seteaza itemul curent
         */

        $this->name_ro   = &$this->tree[$this->idC]->name_ro;
        $this->name_en   = &$this->tree[$this->idC]->name_en;

        $this->nameF     = &$this->tree[$this->idC]->nameF;
        $this->name      = &$this->tree[$this->idC]->name;

        $this->type      = &$this->tree[$this->idC]->type;
        $this->children  = &$this->tree[$this->idC]->children;
       /* $this->new       = &$this->tree[$this->idC]->new;*/
        $this->id        = &$this->tree[$this->idC]->id;
        $this->p_id      = &$this->tree[$this->idC]->p_id;

         if(    in_array($this->type,$this->models )) $this->type_MOD = 'MODELS';
         elseif(in_array($this->type,$this->plugins)) $this->type_MOD = 'PLUGINS';

    }
#=======================================================================================================================

    /**
     * SET:  $this->mod_name;
     *
     * USE: GENERAL: $this->mod_name->display();
     *      CURRENT: $this->{$this->type}->display();
     */
    public function SET_OBJ_mod($mod_name,$type_MOD,$ADMINpre='C',$ADMINstr='')       {

        # set REQUIERD objects   $OB_name = Cmod_name or $OB_name= CAmod_name (admin, if it has one);


        $OB_name = $ADMINpre.$mod_name;

        if(file_exists(fw_incPath.$type_MOD."/$mod_name".$ADMINstr."/".$OB_name.'.php'))
             $this->$mod_name = new $OB_name($this);

        elseif( file_exists(fw_pubPath.'MODELS/'.$mod_name.'/RES/TMPL_'.$mod_name.'.html') )
            $this->$mod_name = new Cmodel($mod_name,$this);


    }
    public function SET_INC_jsCss($mod_name,$type_MOD,$ADMINstr='')                   {

          $PARTIAL_PATH         =  fw_pubPath.$type_MOD.'/'.$mod_name.$ADMINstr;
          $PARTIAL_SRC_PATH     =  fw_pubURL.$type_MOD.'/'.$mod_name.$ADMINstr;


        #_________________________________________[  JS]______________________________________________________
        #*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-

          $js_PATH      = $PARTIAL_PATH.'/js/';
          $js_SRC_PATH  = $PARTIAL_SRC_PATH.'/js/';
        #_______________________________________________

            if(  is_dir($js_PATH) )
            {$dir = dir($js_PATH);

                while(false!== ($file=$dir->read()) )
                {
                    $arr_file = explode('.',$file);
                    if( end($arr_file) =='js'  )
                           $this->INC_js .= "<script type='text/javascript'  src='".$js_SRC_PATH.$file."'></script>"."\n";
                }
            }


        #_________________________________________[  CSS ]________________________________________________________
        #*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-

           $css_PATH      = $PARTIAL_PATH.'/css/';
           $css_SRC_PATH  = $PARTIAL_SRC_PATH.'/css/';
        #_______________________________________________

            if(   is_dir($css_PATH) )
            { $dir = dir($css_PATH);

                while(false!== ($file=$dir->read()) )
                {
                    $extensionEXP = explode('.',$file);
                    $extension = end($extensionEXP);
                    if( $extension =='css'  )
                       $this->INC_css .="<link rel='stylesheet' href= '".$css_SRC_PATH.$file."'  />"."\n";
                }
            }

        //TODO: retinut file_get_cont(file.css) si pus <link rel='stylesheet' href= 'acel content ' />

    }

    public function SET_general_mod($mod_name,$type_MOD,$ADMINstr='',$ADMINpre='C')   {

        $this->SET_INC_jsCss($mod_name,$type_MOD,$ADMINstr);
        $this->SET_OBJ_mod($mod_name,$type_MOD,$ADMINpre,$ADMINstr);

       /* var_dump($mod_name);*/
}

    public function SET_current()        {
        if(!is_object($this->type))
            $this->SET_general_mod($this->type,$this->type_MOD) ;

       }
    public function SET_default()        {

        foreach($this->mods AS $type_MOD)
            foreach($this->{'default_'.$type_MOD} AS $mod_name)
                $this->SET_general_mod($mod_name,$type_MOD);
    }

#=======================================================================================================================

    /**
     *
     *CONTROL_setINI
       *
       *  - try to set the type property
       *  - if idT & idC exists => a tree[idT].txt should exist in /public/GENERAL/RES_TREE
       *  - from that tree we should be albe to determine the current item with all of its properties
       *
       *  - if a type is set => $mod_name = type  =>  js / css                        --> SET_INC_current();
       *                                          =>  $mod_name = new C$mod_name;     --> SET_OBJ_mod_current();
       *
       *  - sets the default mod.'s     => le instantiaza obiectele si seteaza tagurile  js/css aferente ;
      */  public function CONTROL_setINI()    {


        if(isset($_REQUEST['type'])) $this->SET_type();
        elseif( $this->SET_idTC())   if( $this->SET_tree())  $this->SET_ID_item();




        $this->SET_default();
        $this->SET_HISTORY($this->idC);                #pus aici pentru ca intai trebuie initializata limba
        if($this->type)  $this->SET_current();




      }
    /**
        *
           *  __contruct()
           *
           *      -se conecteaza la DB
           *      -apeleaza CONTROL_setINI
           */function __construct()              {

       $this->DB = new mysqli(dbHost,dbUser,dbPass,dbName);
       echo  $this->DB->error;

       $this->GET_objCONF($this,'GENERAL','setINI');          #seteaza variabilele personalizate

       $this->CONTROL_setINI();


    }
}
