<?php
class CCHILDREN_display{
    var $C;

    function DISPLAY(){

        $p_id = $this->C->p_id;

        $children   = $this->C->tree[$p_id]->children;
        $idT        = $this->C->idT;

        if($children)
        {
            $HTML_string = "
            <div id='children_display'>
                <ul>";
                foreach($children AS $id_ch)
                {
                    $name = $this->C->tree[$id_ch]->name;

                    //$HTML_string .="<li><a id='$id_ch' href='".fw_pubURL."index.php?idT=$idT&idC=$id_ch'>$name</a></li>";
                    $search=array(' ',',');
                    $replace=array('_','');
                    $title = str_replace($search,$replace,$name);
                    $HTML_string .="<li><a id='$id_ch' href='".$idT."-".$id_ch."-".$title."'>$name</a></li>";
                }

             $HTML_string .= "
                </ul>
             </div>
    ";

            return $HTML_string;
        }
        else return 'No children to display for '.$idT;
    }

    function __construct($C)
    {
        $this->C = &$C;

    }

}
