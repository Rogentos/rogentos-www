<?php
class Cmodel
{
    var $page;
    var $mod_name;
    var $lang = 'ro';
    var $C;
    var $LG;

    function __construct($type,$C)  {
        $this->C  = &$C;
        $this->LG = &$C->lang;
        $this->mod_name = $type;


        if($this->C->nameF) $this->page =$this->C->nameF;                          // the page name is taken from tree
        else $this->page = isset($_GET['page']) ? $_GET['page'] : $this->mod_name; // the page name is taken static from $_GET['page'];

    }
     function  __get($name) {

         $LG = $this->LG;

         $name =( $name=='content') ? $LG.'/' : $LG.'/'.$name.'/';
         $path = publicPath.'MODELS/'.$this->mod_name.'/RES/'.$name;
         #________________________________________________________________________



         if(is_dir($path) && file_exists($path.$this->page.'.html'))
              return file_get_contents($path.$this->page.'.html');
         else return 'no_content';
     }

    function get_module($module) { return $this->C->{$module}->DISPLAY();}


    function DISPLAY() {

        $path = publicPath.'MODELS/'.$this->mod_name.'/RES/TMPL_'.$this->mod_name.'.html';
        if(file_exists($path))
        {
            $content = file_get_contents($path);
            eval("\$content = \"$content\";");
            return $content;
        }
        else return 'Nu exista obiect sau template pt acest model';

    }
}

/*
 * class textEv {


     var $var1 = ' <b>ceva</b> ';
     var $var2 = ' <b>ALTceva</b> ';
     function  __get($name) {
         if($this->$name)
             return '<b>'.$this->name.'</b>';
         else return '<b>'.$name.'</b>';
     }
     function __construct() {

          $text= 'Afisez $this->var1  si inca  $this->var2 si $this->var3';
         eval("\$text = \"$text\";");
         echo $text. "\n";

     }
 }

 $ob = new textEv();*/