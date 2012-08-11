<?php
class CLANG {
      var $C;               //main object
      var $lang;
      var $lang2;
      var $tree;
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
          $pageContent = '';
          if($this->C->admin)
          {
              $pageContent = "<a href='index.php?logOUT=1' id='logOUT'>Log OUT</a>";
          }

          $path = publicPath.'MODULES/LANG/RES/lang.html';
          if(file_exists($path))
               $pageContent .= file_get_contents($path);
          else $pageContent .= 'Nu exista continut la pagina <b>'.$path.'</b>';

          #_________________________________________________________________

          return  $pageContent;
      }

      function __construct($C){

          $this->C = &$C;
          $this->tree = &$C->tree;
          $this->lang = &$C->lang;
          $this->lang2 = &$C->lang2;

          $this->SET_lang();
      }

}