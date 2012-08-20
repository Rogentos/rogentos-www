<?php
/**
 * -  Aceasta clasa se ocupa inprincipal cu gestionarea paginilor (categoriilor) si interconectarea lor
 * -  Deasemnea cauta existenta unui obiect 'handle' pentru completarea acestei gestionari
 * -  Poate avea module aditionale pt alte functionalitati POSTparsers
 * - acesti POSTparsers - nu fac altceva decat sa parseze izolat postul si isi vor avea locul in GEN_edit
 * pana la standardizarea lor
 *
 */
class ACGEN_edit
{
    var $C;               //main object
    var $lang;
    var $lang2;
    var $langs;
    var $DB;
    var $dispPATH ='';

    var $POSTparsers = array('ACheaders');                #this are adittions to the general edit functionality
    var $affectedMODULES = array('MENUhorizontal','GEN_edit');
    /**
     *  RULE: all affectedMODULES should have - a RES [lg]
     *                                        - an OBJECT to reconstruct those RES
    */

    var $changes = array( 'addNewITEM', 'updateITEM','seoITEM', 'deleteITEM','updateTREE');
    var $pathChanges;
    var $menus;

    var $masterTREE = array();
    var $TESTdisplay ='';
    var $ENDpoints= array();             //this in Cproducts, here, and  ACproducts_handle_GENedit

    function getList($menuKey='', $Pid='') {

        $LG = $this->lang;

        //_______________________________[free items]_________________________________________
        if($menuKey=='freeITEMS')
        {
            $query = "SELECT ITEMS.id, name_{$LG} AS name, type
                        FROM ITEMS
                       WHERE ITEMS.id NOT IN (SELECT Cid from TREE)
                        ";

            $list = "\n<ol  id='children_new'>";
        }


        //_______________________________[menus items]_________________________________________
        elseif($menuKey)
        {
            $query = "SELECT ITEMS.id,name_{$LG} AS name,type from
                     MENUS join TREE on (MENUS.id = TREE.Cid) join ITEMS on (MENUS.id = ITEMS.id)
                     WHERE idM ='{$menuKey}'
                     ORDER BY poz ASC";

            $list = "\n<ol>";
        }


        //_________________________________[ recursiv ]___________________________________________
        elseif($Pid)
        {
            $query = "SELECT ITEMS.id,name_{$LG} AS name,type from
                       TREE join ITEMS on (TREE.Cid = ITEMS.id)
                       WHERE Pid='{$Pid}'
                       ORDER BY poz ASC";

            $list = "\n<ol>";
        }

        $res = $this->DB->query($query);
      //__________________________________________________________________________________________________________

        if($res)
        {


            while($item = $res->fetch_assoc())
            {
                $id = $item['id'];
                $type = $item['type'];
                $name = $item['name'];

                if(!in_array($type,$this->C->models)) $type='no-edit';

                $list .= "\n<li id='list_{$id}'>
                    <div class='{$type}'>$name</div>";
                $list .=$this->getList('',$id);
                $list .="</li>";
            }
        }
        else
        {
            $list .=  $this->DB->error;
        }


        $list .="</ol>";

        return $list;





    }
    function getMenus()                    {

        $RES = $this->DB->query("SELECT MAX(id) AS max_id  from ITEMS ")->fetch_assoc();
        $last_id = $RES['max_id'] + 1;
        $html ="<div id='indicatiiGE'>
                    <button id='Show_idicatiiGE' class='Tbar_but'>Indicatii</button>
                    <div id='indicatii_GENedit'>
                        <pre style='font-size: 11px; '>
* Edit categorie   - click pe categorie - edit

* Delete categorie - click pe categorie - delete
                   - daca o categorie va fii deletata ,
                     toate subcategoriile si produsele
                     din ea  vor fii deasemenea deletate

* Adauga categorie - scrie numele categoriei
                   - click pe add
                   - trage categoria la locul dorit din lista


* ATENTIE - modificarile nu se vor salva decat dupa
            ce s-a apasat pe save
          - in cazul in care s-a comis vreo gresala se poate iesi
            din General Edit fara ca acea gresala sa fie salvata
                        </pre>
                    </div>
                </div>
                 <div class='block_addNew'>
                            <input type='hidden' name='lastID' value='{$last_id}' />
                            <input type='button' name='addNew' value='add' onclick='addNewITEM()' class='Tbar_but' />
                            <input type='text'   name='itemName'value='' placeholder='item name'>
                            <span  class='types'>
                                 <select name='type' class='Tbar_but'>

                                    <!-- <option class='newsletter'> newsletter</option>-->
                                     <option class='single'> single</option>
                                     <option class='contact'> contact</option>
                                     <option class='webchat'> webchat</option>

                                    <!-- <option class='products'> products</option> -->
                                    <!--<option class='basket'>basket</option>
                                    <option class='siteMap'>siteMap</option>-->
                                    <option class='none'> none</option>

                                 </select>
                            </span>
                            <form action='' method='post'>
                                <input type='submit' name='SaveChanges' value='Save'  class='Tbar_but'/>
                            </form>
                 </div>
                                                                                                          ";
//============================= [ free items ] =============================================================

        $freeITEMS = $this->getList('freeITEMS');
$html .="
        <ol class='sortable'>
                       <li id='list_MenuFREE' >
                           <div>Free Items</div>
                           {$freeITEMS}
                       </li> \n
                                                                                                          ";
//============================= [ menus items ] ============================================================

        foreach($this->menus AS $menuKey => $menuType)
        {
            $list = $this->getList($menuKey);
$html .="
                    \n <li id='list_Menu{$menuKey}'>
                            <div>Meniu_{$menuKey} {$menuType}</div>
                            {$list}
                        </li>
                     \n
";      }
        $html .="</ol>";

   //_____________________________________________________________________________________

        return $html;
    }





    //TODO:    ATENTIE!!!   contact se introduce de 2 ori in baza de date cu aceleasi date

    function updateTREE($tree)         {

        $query = 'DELETE from TREE';    $this->DB->query($query);
        $query2 = 'DELETE from MENUS';  $this->DB->query($query2);

        $mes = "A fost deletatat tot TREEul cu query-ul ".$query.' -- '.$query2."<br />";
        foreach($tree as $menuName=>$menu)
        {
            if($menuName!='MenuFREE')
            {
                $mes .= "<br/>".'Meniul '.$menuName."<br/>";
                $menuID = str_replace('Menu','',$menuName);

                foreach($menu as $id=>$item)
                {
                    $Pid = $item['pid'];
                    $poz = $item['poz'];

                    $res = $this->DB->query("SELECT Cid from TREE where Cid='{$id}' LIMIT 0,1 ");
                    if(!$res->num_rows)
                    {
                         $query = "INSERT into TREE (Pid,Cid,poz) values ('{$Pid}','{$id}','{$poz}')";
                         $this->DB->query($query);
                         $mes .=$query."<br/>";
                    }
                         if($Pid == 0)
                         {
                            $query = "INSERT into MENUS (id,idM) values ('{$id}','{$menuID}')";
                            $this->DB->query($query);
                            $mes .=$query."<br/>";
                         }


                }

            }

        }
        return $mes;

    }

    function htReplace($source, $destination) {
        $htaccess = publicPath.'.htaccess';
        $htcontent = file_get_contents($htaccess);
        $htcontent = str_replace($source, $destination,$htcontent);
        file_put_contents($htaccess,$htcontent);
    }

    function seoITEM($id,$detail)      {

            $SEO_arrSer = serialize($detail);
            #========================================[ UPDATE DB ]==============================================================
             $query = "UPDATE ITEMS set SEO='{$SEO_arrSer}'   WHERE id='{$id}' ";
             $this->DB->query($query);


    #___________________________________________________________________________________________________________________
             return 'SEO pe id = '.$id."<br/>".$query;
    }
    function updateITEM($id, $detail)  {


              $LG = $this->C->lang;

              $name_old = $this->masterTREE[$id]->{'name_'.$LG};
              $type_old = $this->masterTREE[$id]->type;
              $nameF_old = $this->masterTREE[$id]->nameF.'.html';


              $name_new = trim($detail['val']);
              $type_new = $detail['type'];
              $nameF_new = str_replace(' ','_',$name_new).'.html';
        #===============================================================================================================

             if($this->lang != 'en' && $nameF_new!=$nameF_old)  $nameF_new = $nameF_old;

             $partialPATH_new = publicPath.'MODELS/'.$type_new.'/RES/';
             $partialPATH_old = publicPath.'MODELS/'.$type_old.'/RES/';


        //______________________________________________________________________________________________________________
        //__________________________________[ REFACTOR RES ]___________________________________________________________


            foreach($this->langs AS $LGS)
            {
                if(is_dir($partialPATH_old."{$LGS}/") && is_dir($partialPATH_new."{$LGS}/"))
                {
                    $fullPATH_old_LG = $partialPATH_old."{$LGS}/".$nameF_old;
                    $fullPATH_new_LG = $partialPATH_new."{$LGS}/".$nameF_new;

                    if(file_exists($fullPATH_old_LG))
                    {
                         file_put_contents($fullPATH_new_LG, file_get_contents($fullPATH_old_LG));    unlink($fullPATH_old_LG);
                    }
                }

            }

    #========================================[ UPDATE DB ]==============================================================
             $query = "UPDATE ITEMS set name_{$LG}='{$name_new}' , type='{$type_new}'  WHERE id='{$id}' ";
             $this->DB->query($query);


    #========================================[ UPDATE .htaccess ]=======================================================
             $this->htReplace(strtolower($name_old),strtolower($name_new));


    #___________________________________________________________________________________________________________________
             return ' id = '.$id.' --- OLD ----'.$name_old.' ---NEW ---'. $name_new."<br/>".$query;




        //$query = "UPDATE ITEMS set name_[LG]='val' , type='type'  WHERE id='id' ";
        //$mes = "Au fost updatate cu query-ul ".$query."<br />";

    }
    function addNewITEM($id, $detail)  {


               $name_new = trim($detail['val']);
               $type_new = $detail['type'];
               $nameF_new = str_replace(' ','_',$name_new).'.html';

               $partialPATH_new = publicPath.'MODELS/'.$type_new.'/RES/';

        //______________________________________________________________________________________________________________
        //______________________________________[ADD to RES]____________________________________________________________

               foreach($this->langs AS $LGS)
                   if(is_dir($partialPATH_new."{$LGS}/"))
                         file_put_contents($partialPATH_new."{$LGS}/".$nameF_new, 'No contents added yet');


        //______________________________________[ ADD to DB ]_________________________________________________________

               $query ="INSERT into ITEMS (name_ro,name_en,type) values ('{$name_new}','{$name_new}','{$type_new}')";  $this->DB->query($query);


        //_____________________________________________________________________________________________________________
              return 'id = '.$id.' ---NEW---'.$partialPATH_new.'en/'.$nameF_new."<br/>";




          //$query ="INSERT into ITEMS (name_ro,name_en,type) values (name_new,name_new,type)";
          //$mes = "Au fost adaugate cu query-ul ".$query."<br />";


    }

   # NU se poate baga in CsetINI ca generalizare deoarece la acest moment
   # tree-ul aferent nu mai exista
   # desi ar putea exista si dupa aia sa il sterg
    function getENDpoints($id)        {

       #propagation of DELETE in all children
       # toti descendetii id-ului deletat

        $ch = $this->masterTREE[$id]->children;
        if($ch)
            foreach($ch AS $id_ch)
                $this->getENDpoints($id_ch);

        array_push($this->ENDpoints, $id) ;



    }
    function deleteITEM($id,$detail)  {

             $this->getENDpoints($id);$ENDpoints_STR='';

         //_____________________________[DELETE from RES]_______________________________________________________________


            foreach($this->ENDpoints AS $idITEM)
            {
                $ENDpoints_STR .="'{$idITEM}',";

                $type = $this->masterTREE[$idITEM]->type;
                $nameF = $this->masterTREE[$idITEM]->nameF.'.html';
                $partialPATH = publicPath.'MODELS/'.$type.'/RES/';
               #=========================================================
                    foreach($this->langs AS $LGS)
                        if(is_file($partialPATH."{$LGS}/".$nameF))
                                unlink($partialPATH."{$LGS}/".$nameF);

            }

            $ENDpoints_STR = '('.substr($ENDpoints_STR,0,-1).')';      unset($this->ENDpoints);

         //_____________________________[DELETE from DB]________________________________________________________________

              $query1 ="DELETE from ITEMS where id IN {$ENDpoints_STR} ";  $this->DB->query($query1);

         //_____________________________________________________________________________________________________________
              return 'id = '.$id.'--- DELETE --- '.$ENDpoints_STR."<br />";


    }




    function getOBJECT_handle($change_type,$id,$detail)          {

        /**
         * REQ: [type] /ADMIN/ 'AC'.$nameTYPE.'_handle_GENedit.php';   - to handle changes
         */
        #   $changes = array( 'addNewITEM', 'updateITEM', 'deleteITEM','updateTREE',);

        #    OLD_TYPE = $this->masterTREE[$id]->type;  is the old_type  available only for existent ITEMS
        #    NEW_TYPE = (isset(detail['type']) : )   if exists and is diffrent than OLD_TYPE
        #    => both types should be adresed



     #==================================================================================================================
        $types['OLD'] = $OLD_type = (isset($this->masterTREE[$id]->type) ? $this->masterTREE[$id]->type : '');
        $types['NEW'] = $NEW_type = (isset($detail['type']) && $detail['type']!=$OLD_type ? $detail['type'] : '');
        $TESTdisplay='';
    #===================================================================================================================

        foreach($types AS $statusTYPE => $nameTYPE)
            if(isset($nameTYPE))
            {
                $ob_handle_NAME = 'AC'.$nameTYPE.'_handle_GENedit';

                if(file_exists(incPath."MODELS/$nameTYPE/ADMIN/".$ob_handle_NAME.'.php'))
                {
                    $handle = new $ob_handle_NAME($this->DB, $change_type, $id, $detail,$statusTYPE, $this->masterTREE);  unset($handle);

                    $TESTdisplay .="HANDLE $statusTYPE =".$nameTYPE."<br />";
                }
            }

    #===================================================================================================================
        $TESTdisplay = (isset($TESTdisplay) ? $TESTdisplay : 'No handle for '.$OLD_type);
        return "<br/>".$TESTdisplay."<br />";


    }
    function parseCHANGES()          {


         $this->pathChanges = publicPath.'MODULES/GEN_edit/RES/changes/';
        //______________________________________________________________________________________________________________

         foreach($this->changes AS $change)  // =  array( 'addNewITEM', 'updateITEM','seoITEM','deleteITEM', 'updateTREE');
         {
             $actionPATH  = $this->pathChanges.$change.'.txt';
             if(file_exists($actionPATH))                                                           #daca exista un fisier cu schimbari => exista si schimbari
             {
             $CHANGES  = unserialize(file_get_contents($actionPATH));                               #deserializam vectorul cu schimbari;


                       //_______________________________________________________________________________________________
                       if($change!='updateTREE')
                       {
                           foreach($CHANGES as $list_id => $detail)                                 #parscam prin vectorul de schimbari
                            {
                                $idarr = explode('_',$list_id);                                     #extragem id-ul elementului schimbat
                                $id = end($idarr);
                                $type_old = ( isset($this->masterTREE[$id]->type) ?
                                              $this->masterTREE[$id]->type : '');
                               // $type_new = ( isset($detail['type']) ? $detail['type'] : ''  );


                                $this->TESTdisplay .=$this->getOBJECT_handle($change,$id,$detail);  #testez daca exista un obiect
                                                                                                    #care sa se descurce cu aceste schimbari

                                $mes = $this->{$change}($id,$detail);                               #procesez schimbarea

                                $this->TESTdisplay .=$change.' type = '.$type_old."<br/>".$mes."<br/>";

                            }
                       }


                       //_________________________________________________________________________________________________
                         else
                         {
                              $mes = $this->updateTREE($CHANGES);
                              $this->TESTdisplay .=$change.' type = updateTREE'."<br/>".$mes."<br/>";
                         }


              }

         }

        //_____________________________________________________________________________________
        $this->TESTdisplay ="<div>".$this->TESTdisplay."</div>";



    }

    function CTRL_changes()          {

        $this->masterTREE = $this->C->create_masterTREE();
        $this->parseCHANGES();
        $this->C->regenerateALLtrees();
        $this->C->solve_affectedMOD($this->affectedMODULES);

    }

    function POSTparsers_INI()       {

        $basePath = incPath.'MODULES/GEN_edit/ADMIN/';
        foreach($this->POSTparsers AS $parserName)
        {
            if(is_file($basePath.$parserName.'.php')) $this->$parserName = new $parserName();
        }

    }
    function __construct(&$C)
    {
        $this->C = &$C;
        $this->DB = &$C->DB;
        $this->menus = &$C->menus;

        $this->lang  = &$C->lang;
        $this->lang2 = &$C->lang2;
        $this->langs = &$C->langs;

        $this->dispPATH = publicPath.'MODULES/GEN_edit/RES/'.$this->lang.'/GEN_edit.html';

        //______________________________________________________________________________________________________________

            $C->TOOLbar->ADDbuttons("<input type='button'  value='General Edit' onclick=\"activatePOPUPedit('GEN_edit')\">");

            if(isset($_POST['SaveChanges']))$this->CTRL_changes();

             $this->POSTparsers_INI();

        //______________________________________________________________________________________________________________



        if(!file_exists($this->dispPATH))  file_put_contents($this->dispPATH,
                                                             $this->getMenus().$this->TESTdisplay );
    }
}