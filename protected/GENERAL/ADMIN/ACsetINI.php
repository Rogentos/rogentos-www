<?php

class ACsetINI extends ADMIN_vars
{
/*

    public function DB_connect()    {

        $this->DB = DB::getInstance();
    }*/

    public function RESET_select_all($type='')  {


            /*<select id="combobox">
            		<option value="">Select one...</option>
            		<option value="ActionScript">ActionScript</option>
             </select>
            */

              if($type=='but') $type='cat';

              if($type=='cat' || $type=='pag') { $types = array($type);       $reset = true;}
              elseif($type=='')                { $types = array('pag','cat'); $reset = true; }
              else {$reset = false;}

            #______________________________________________________________________________________________
         //   if($reset) {


                   foreach($types AS $type)
                   {
                       $display=($type=='cat' ? "style='display: none;' " : '');
                       $qRES = $this->DB->query("SELECT id,name_ro from ELEMENTS where type='$type' ORDER BY name_ro ASC ");



    $str="
                    <select id='combobox_{$type}'   name='select_all_{$type}' $display >
                        <option value=''> Alege $type existente</option>

    ";
                       while($row = $qRES->fetch_assoc())
                       {
                           $id      = $row['id'];
                           $name_ro = $row['name_ro'];
                          #________________________________
    $str.="              <option value='$id'>$name_ro</option>
    ";
                       }
    $str.="       </select>
    ";

                        file_put_contents('./RES/SELECT_all_'.$type.'.html',$str);
                   }


        }
    public function tree_fromDB($ch,$p_id='')   {

        foreach($ch AS $id_ch)
        {
            $this->TMPtree[$id_ch] = new item();

            $q = "SELECT name_ro,name_en,type, new, description from ITEMS where id='$id_ch' ;";
            $q_arr = $this->DB->query($q)->fetch_assoc();


            $this->TMPtree[$id_ch]->name    = $q_arr['name_en'];
            $this->TMPtree[$id_ch]->desc    = $q_arr['description'];

            $this->TMPtree[$id_ch]->name_ro = $q_arr['name_ro'];
            $this->TMPtree[$id_ch]->name_en = $q_arr['name_en'];

            $this->TMPtree[$id_ch]->type    = $q_arr['type'];
            $this->TMPtree[$id_ch]->new     = $q_arr['new'];
            $this->TMPtree[$id_ch]->id      = $id_ch;
            $this->TMPtree[$id_ch]->p_id    = $p_id;

            $this->TMPtree[$id_ch]->nameF   = str_replace(' ','_',$this->TMPtree[$id_ch]->name_en) ;



            $q = " SELECT Pid,Cid,poz FROM TREE where Pid='$id_ch' ORDER BY poz ASC ;";
            $q_res = $this->DB->query($q);

            while($ch_arr = $q_res->fetch_assoc() )
                $this->TMPtree[$id_ch]->children[ $ch_arr['poz'] ] = $ch_arr['Cid'];


            if($q_res->num_rows)
                $this->tree_fromDB($this->TMPtree[$id_ch]->children,$id_ch);

        }

    }
    public function SET_REStree($idT)     {

        $this->tree_fromDB(array($idT));

        $tree_SER = serialize($this->TMPtree);
        file_put_contents(publicPath.'GENERAL/RES_TREE/tree'.$idT.'.txt',$tree_SER);


        return $this->TMPtree;

    }
    public function SET_tree()                  {


        if($this->idT)
        {
            if(!isset($_SESSION['tree'.$this->idT]) || !file_exists(publicPath.'GENERAL/RES_TREE/tree'.$this->idT.'.txt') )
            {
               $this->tree = $this->SET_REStree($this->idT); unset($this->TMPtree);
                $_SESSION['tree'.$this->idT] = true;
            }

            else
                   $this->tree = unserialize(file_get_contents(publicPath.'GENERAL/RES_TREE/tree'.$this->idT.'.txt'));



            return true;

        }
        else {  return false;}

    }


    public function SET_OBJ_mod($mod_name,$type_MOD)    {

        # set REQUIERD objects   $OB_name = Cmod_name or $OB_name= ACmod_name (admin, if it has one);


        $OB_name ='AC'.$mod_name;

        if(isset($this->admin_MOD[$mod_name]) && file_exists(incPath.$type_MOD."/{$mod_name}/ADMIN/".$OB_name.'.php') && !is_object($this->$mod_name))
           $this->$mod_name = new $OB_name($this);
        else
            parent::SET_OBJ_mod($mod_name,$type_MOD);
    }
    public function SET_INC_jsCss($mod_name,$type_MOD, $ADMINstr='')  {

       if(isset($this->admin_MOD[$mod_name]))  parent::SET_INC_jsCss($mod_name,$type_MOD,'/ADMIN');
                                               parent::SET_INC_jsCss($mod_name,$type_MOD);


    }




    public function CONTROL_setINI() {

        $this->mergeArray();
        parent::CONTROL_setINI();
        $this->display = '';

        # HTML_BUT_GEN_edit; -> din toolbar; @toDo

        #________________________________________________________________________________________________

      /*  if(!file_exists('./RES/SELECT_all_cat.html')) $this->RESET_select_all();*/
      /*  $this->SET_HTML_topbar();*/

    }
    /*______________________________________________________________________________________________________________  */
    function __construct($DB)                      {

       $this->admin = true;
       $this->DB = new mysqli(dbHost,dbUser,dbPass,dbName);

       $this->CONTROL_setINI();


    }
}
