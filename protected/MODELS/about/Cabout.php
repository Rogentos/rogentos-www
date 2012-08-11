<?php
class Cabout{

    var $C;               //main object
    var $LG;
    var $nameF;
    var $portofTREE;

    function GET_portofTREE()
    {
        $idT         = 6;
        $pathTREE    = publicPath.'GENERAL/RES_TREE/tree'.$idT.'.txt';
        if(file_exists($pathTREE))  {$this->portofTREE=  unserialize(file_get_contents($pathTREE ));  return true;}
        else return false;

    }
    function DISPLAY_portofChildren()
    {
        $see = array('ro'=>'VEZI PORTOFOLIU','en'=>'SEE PORTOFOLIO');

        $LG = $this->LG;
        $seeLG = $see[$LG];
        if($this->GET_portofTREE())
        {

            $idT         = 6;
            $children    = $this->portofTREE[6]->children;  $HTML_string ='';
           #_________________________________________________________________________________________
           if($children)
           {
               $HTML_string .= "<ul type='disc'>";
               foreach($children AS $id_ch)
               {
                   $name = $this->portofTREE[$id_ch]->{'name_'.$LG};
                   $HTML_string .="<li><a id='$id_ch' href='".publicURL."index.php?idT=$idT&idC=$id_ch'>$name</a></li>";
               }
                $HTML_string .= " </ul> ";


               #_______________________________________________________________________________________
               $portofChildren="
                        <div id='portof_children'>
                            <b>$seeLG</b>
                              $HTML_string
                       </div>
               ";

               return  $portofChildren;
           }

            else return '';
        }

    }

    function DISPLAY(){
            $LG = $this->LG;
            $path = publicPath."MODELS/about/RES/{$LG}/".$this->nameF.'.html';
            if(file_exists($path))
                 $pageContent = file_get_contents($path);
            else $pageContent = 'Nu exista continut la pagina <b>'.$path.'</b>';

            $portofChildren = $this->DISPLAY_portofChildren();


            #_________________________________________________________________
            $display = $this->C->CHILDREN_display->DISPLAY();
            $display .="<div id='page_content'>
                            $pageContent
                            $portofChildren
                        </div>
";

            return  $display;
    }

    function __construct($C){

        $this->C  = &$C;
        $this->LG = &$C->lang;
        $this->nameF = $this->C->nameF;
    }
}

