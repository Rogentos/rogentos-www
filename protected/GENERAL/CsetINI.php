<?php


class CsetINI extends  vars
{



    public function SET_type()          {


           if($_REQUEST['type'])$this->type = $_REQUEST['type'];

       }
    public function SET_idTC()          {


        if(isset($_GET['idT']))
        {
               $this->idT =   $_GET['idT'];
               $this->idC = ( $_GET['idC'] ?  $_GET['idC'] : $this->idT );


               return true;
        }
        elseif($this->idC) return true;
        else {return false; echo 'Nu am reusit sa iau treeul';}
    }
    public function SET_tree()          {

       $this->tree = unserialize(file_get_contents('./GENERAL/RES_TREE/tree'.$this->idT.'.txt'));

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

        $this->desc      = &$this->tree[$this->idC]->desc;
        $this->type      = &$this->tree[$this->idC]->type;
        $this->children  = &$this->tree[$this->idC]->children;
        $this->new       = &$this->tree[$this->idC]->new;
        $this->id        = &$this->tree[$this->idC]->id;
        $this->p_id      = &$this->tree[$this->idC]->p_id;

         if(    in_array($this->type,$this->models )) $this->type_MOD = 'MODELS';
         elseif(in_array($this->type,$this->modules)) $this->type_MOD = 'MODULES';

    }

    public function ctrlDISPLAY($object_name)         {

        if(is_object($this->$object_name) && method_exists($this->$object_name,"DISPLAY"))
            return $this->$object_name->DISPLAY();


    }

    /**
     *
     * SET:  $this->mod_name;
     *
     * USE: GENERAL: $this->mod_name->display();
     *      CURRENT: $this->{$this->type}->display();
     */
    public function SET_OBJ_mod($mod_name,$type_MOD)    {

        # set REQUIERD objects   $OB_name = Cmod_name or $OB_name= CAmod_name (admin, if it has one);


        $OB_name = 'C'.$mod_name;

        if(file_exists(incPath.$type_MOD."/$mod_name/".$OB_name.'.php'))
             $this->$mod_name = new $OB_name($this);

        elseif( file_exists(publicPath.'MODELS/'.$mod_name.'/RES/TMPL_'.$mod_name.'.html') )
            $this->$mod_name = new Cmodel($mod_name,$this);


    }
    /**
     *
     * @param $mod_name
     * @param $type_MOD    = moDEL/ module
     *
     * cauta in directoarul aferent mod_name  css, js si adauga tagurile html in INC_js/ INC_css
     */
    public function SET_INC_jsCss($mod_name,$type_MOD,$ADMINstr='')     {

          $PARTIAL_PATH         =  publicPath.$type_MOD.'/'.$mod_name.$ADMINstr;
          $PARTIAL_SRC_PATH     =  publicURL.$type_MOD.'/'.$mod_name.$ADMINstr;


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


    public function SET_current()        {
        if(!is_object($this->type)) {
           $this->SET_INC_jsCss( $this->type,$this->type_MOD);
           $this->SET_OBJ_mod($this->type,$this->type_MOD);
        }

       }
    public function SET_default()        {

        foreach($this->mods AS $type_MOD)
            foreach($this->{'default_'.$type_MOD} AS $mod_name)
            {
                $this->SET_OBJ_mod($mod_name,$type_MOD);
                $this->SET_INC_jsCss( $mod_name,$type_MOD);
            }
    }




    public function SET_HTML_headerIMG()           {

        $this->HTML_headerIMG = file_get_contents(publicPath.'/GENERAL/RES/headerIMG.html');
    }
    #______________________________________________________________________________________________________________

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

        if($this->type)  $this->SET_current();



        //$this->SET_HTML_headerIMG();
      }
    #______________________________________________________________________________________________________________

    /**
        *
           *  __contruct()
           *
           *      -se conecteaza la DB
           *      -apeleaza CONTROL_setINI
           */function __construct()              {

    // Uncomment these two lines when server comes back from the dead :-)
       $this->DB = new mysqli(dbHost,dbUser,dbPass,dbName);
       echo  $this->DB->error;

       $this->CONTROL_setINI();


    }
}
