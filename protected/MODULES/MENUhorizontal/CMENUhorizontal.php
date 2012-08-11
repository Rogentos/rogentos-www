<?php
class CMENUhorizontal
{
    var $LG;
    var $DB;
    public function SET_menu() {

        $res = $this->DB->query(" SELECT Cid,name_ro,name_en from view_TREE where Pid='0' ORDER BY poz ASC");

        if($res->num_rows)
        {
            $LG = $this->LG;
            #_______________________________________________________________________________
            $menu = "<ul class='MENUhorizontal' id='menu_{$LG}'> \n";

            while($row  = $res->fetch_assoc())
            {
                $name = $row['name_'.$LG];
                $id   = $row['Cid'];
                //$href = str_replace(' ','-',strtolower($name));
                //$href = "?idT=$id&amp;idC=$id";
                $url = ($name == 'Home' ? '' : strtolower(str_replace(' ','-',$name)));
                $href = "/$url";
               #___________________________________________________
                $menu .="<li>  <a href='$href' id='$id'> $name </a> </li> \n";
            }

            $menu .= "</ul> \n";

            #________________________________________________________________________________
            $path  = publicPath."MODULES/MENUhorizontal/RES/{$LG}/".'MENUhorizontal'.'.html';
                   file_put_contents($path,$menu);

            return $menu;
        }
    }
    public function DISPLAY()
    {
        $PATH = publicPath.'MODULES/MENUhorizontal/RES/'.$this->LG.'/MENUhorizontal.html';
        if(file_exists($PATH)) return file_get_contents($PATH);
        else return $this->SET_menu();
    }

    public function __construct($C)
    {
        $this->LG = &$C->lang;
        $this->DB = &$C->DB;
    }

}