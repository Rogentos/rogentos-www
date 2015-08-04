<?php
class CLANG {
      var $C;               //main object
      var $lang;
      var $lang2;
      var $tree;
      var $baseURI;
      function RESET_TREElang(){
          if($this->lang!='en')
                foreach($this->tree AS $id_ch=>$ch_element) $this->tree[$id_ch]->name = $ch_element->{'name_'.$this->lang};

      }

      function SET_lang(){




          if(isset($_SESSION['lang'])){
              $this->lang = $_SESSION['lang'];
              if($this->lang == 'ro') $this->lang2 = 'en';
                               else   $this->lang2 = 'ro';

          }
          if(isset($_GET['lang']))
              if($_GET['lang']!=$this->lang)
              {

                  $this->lang =  $_SESSION['lang'] = $_GET['lang'];
                  if($this->lang == 'ro') $this->lang2 = 'en';
                  else $this->lang2 = 'ro';
              }

          $this->RESET_TREElang();


      }

      function DISPLAY(){

        /*  $path = publicPath.'PLUGINS/LANG/RES/lang.php';
          if(file_exists($path))
               $pageContent .= file_get_contents($path);
          else $pageContent .= 'Nu exista continut la pagina <b>'.$path.'</b>';*/

          #_________________________________________________________________
          $baseURI = $_SERVER['REQUEST_URI'];
          //$this->baseURI = str_replace(array("&lang=ro","?lang=ro","&lang=en" ,"?lang=en" ),array('','','',''),$baseURI);

          //$href_ro = ($_SESSION['lang'] == 'ro' ? '' : $this->baseURI."&lang=ro");
          //$href_en = ($_SESSION['lang'] == 'en' ? '' : $this->baseURI."&lang=en");


          //$href_ro = str_replace('index.php&lang','index.php?lang', $href_ro);
          //$href_en = str_replace('index.php&lang','index.php?lang', $href_en);



          $href_en = $href_ro = '';
          if($baseURI == '/')        { $href_ro = "/ro/"; $href_en = "/en/";}
          elseif($this->lang =='ro') $href_en = str_replace("/ro/",'/en/',$baseURI);
          elseif($this->lang =='en') $href_ro = str_replace("/en/",'/ro/',$baseURI);

          return  " <a href='{$href_en}'  >En</a> | <a href='{$href_ro}'  >Ro</a>";
      }

      function __construct($C){

          $this->C = &$C;
          $this->tree = &$C->tree;
          $this->lang = &$C->lang;
          $this->lang2 = &$C->lang2;

          $this->SET_lang();
      }

}