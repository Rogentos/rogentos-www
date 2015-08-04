<?php
class ACManage extends  ADMIN_vars
{
    function delete_contentRES($dir, $prefix) {
        foreach (glob("$dir/$prefix*.html") as $file) {
            unlink($file);
        }
    }
    function solve_affectedMOD($affectedMOD,$typeMOD='PLUGINS') {

            foreach($affectedMOD AS $modNAME)
            {

                $RESpath = resPath.$typeMOD.'/'.$this->lang.'/';
                $this->delete_contentRES($RESpath,$modNAME);
            }
        }


    function regenerateALLtrees()    {

           $queryRES = $this->DB->query("SELECT Cid AS idT from TREE WHERE Pid='0' ");

           while($row = $queryRES->fetch_assoc())
            { $this->SET_REStree($row['idT']); unset($this->TMPtree);}
       }
    function create_masterTREE()     {

          $RES_TREE = fw_pubPath.'GENERAL/RES_TREE/';

          if(  is_dir($RES_TREE) )
          {
              $dir = dir($RES_TREE);
              $masterTREE = array();

              while(false!== ($file=$dir->read()) )
              {
                  $arr_file = explode('.',$file);
                  if( end($arr_file) =='txt'  )
                  {
                      $file_path = $RES_TREE.$file;
                      $tree = unserialize(file_get_contents($file_path));

                      $masterTREE = $masterTREE + $tree;

                     unlink($file_path);   //stergem toate TREE-urile;
                  }
              }

             /* if($this->masterTREE)
                  foreach($this->masterTREE AS $id=>$item)
                      echo 'id='.$id.' nameF='.$item->nameF.' type='.$item->type."<br/>";*/
              return $masterTREE;
          }

      }
}




class ACsetINI extends ACManage
{
/*

    public function DB_connect()    {

        $this->DB = DB::getInstance();
    }*/


    public function GET_tree_fromDB($ch,$p_id='')   {

        foreach($ch AS $id_ch)
        {
            $this->TMPtree[$id_ch] = new item();

            $q = "SELECT name_ro,name_en,type from ITEMS where id='$id_ch' ;";
            $q_arr = $this->DB->query($q)->fetch_assoc();


            $this->TMPtree[$id_ch]->name    = $q_arr['name_en'];

            $this->TMPtree[$id_ch]->name_ro = $q_arr['name_ro'];
            $this->TMPtree[$id_ch]->name_en = $q_arr['name_en'];

            $this->TMPtree[$id_ch]->type    = $q_arr['type'];
          /*  $this->TMPtree[$id_ch]->new     = $q_arr['new'];*/
            $this->TMPtree[$id_ch]->id      = $id_ch;
            $this->TMPtree[$id_ch]->p_id    = $p_id;

            $this->TMPtree[$id_ch]->nameF   = str_replace(' ','_',$this->TMPtree[$id_ch]->name_en) ;



            $q = " SELECT Pid,Cid,poz FROM TREE where Pid='$id_ch' ORDER BY poz ASC ;";
            $q_res = $this->DB->query($q);

            while($ch_arr = $q_res->fetch_assoc() )
                $this->TMPtree[$id_ch]->children[ $ch_arr['poz'] ] = $ch_arr['Cid'];


            if($q_res->num_rows)
                $this->GET_tree_fromDB($this->TMPtree[$id_ch]->children,$id_ch);

        }

    }
    public function SET_REStree($idT)               {

        $this->GET_tree_fromDB(array($idT));

        $tree_SER = serialize($this->TMPtree);
        file_put_contents(fw_pubPath.'GENERAL/RES_TREE/tree'.$idT.'.txt',$tree_SER);


        return $this->TMPtree;

    }
    public function SET_tree()                      {


        if($this->idT)
        {
            if(!isset($_SESSION['tree'.$this->idT]) || !file_exists(fw_pubPath.'GENERAL/RES_TREE/tree'.$this->idT.'.txt') )
            {
               $this->tree = $this->SET_REStree($this->idT); unset($this->TMPtree);
                $_SESSION['tree'.$this->idT] = true;
            }

            else
                   $this->tree = unserialize(file_get_contents(fw_pubPath.'GENERAL/RES_TREE/tree'.$this->idT.'.txt'));



            return true;

        }
        else {  return false;}

    }



    public function SET_general_mod($mod_name,$type_MOD,$ADMINstr='/ADMIN',$ADMINpre='AC')  {
        if(isset($this->admin_models[$mod_name])  && !is_object($this->$mod_name))
        {
            parent::SET_general_mod($mod_name,$type_MOD,$ADMINstr,$ADMINpre);
            parent::SET_INC_jsCss($mod_name,$type_MOD);                             # trebuie pastrate si css,js de la user default
        }
        else
            parent::SET_general_mod($mod_name,$type_MOD);
    }




    public function CONTROL_setINI() {


        $this->mergeArray();
        parent::CONTROL_setINI();

        $this->display = '';

    }
    /*______________________________________________________________________________________________________________  */
    function __construct()                      {

       $this->admin = true;
       $this->DB = new mysqli(dbHost,dbUser,dbPass,dbName);

       $this->GET_objCONF($this,'GENERAL','setINI');
       $this->GET_objCONF($this,'GENERAL','setINI','A');          #seteaza variabilele personalizate


       $this->CONTROL_setINI();


    }
}
