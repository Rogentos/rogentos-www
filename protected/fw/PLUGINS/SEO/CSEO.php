<?php
class CSEO {

    var  $meta_DESCRIPTION = '';
    var  $meta_KEYWORDS    = '';
    var  $meta_TITLE       = '';
    var  $tag_TITLE        = '';
    var  $SEO_all          = '';

    var $C;
    var $DB;
    var $idC;
    var $lang;


    function DISPLAY(){

          #pasi pentru aceste meta-uri
          #1.CsetINI va seta bydefault history_TITLE
          #2.Se vor instantia mod-urile default (inclusiv acest SEO)
          #3.La modul curent aceste variabile ale modulului SEO se pot schimba in functie de necesitati

          $LG = $this->C->lang;
          $langs_STR = ($LG == 'ro' ? 'romanian' : 'english');
    #===================================================================================================================


          if($this->tag_TITLE) $this->C->history_TITLE_keywords  =   $this->tag_TITLE ;
          $disp =
           ($this->meta_TITLE ?       "<meta name='title'       content='".$this->meta_TITLE."'> \n"       : '').
           ($this->meta_DESCRIPTION ? "<meta name='description' content='".$this->meta_DESCRIPTION."'> \n" : '').
           ($this->meta_KEYWORDS ?    "<meta name='keywords'    content='".$this->meta_KEYWORDS."'> \n"    : '');


    #===================================== [ pentru taguri generale in plus ] ==========================================
          $extraMetas_path = resPath.'PLUGINS/'.$LG.'/SEO.html';
          if(file_exists($extraMetas_path))
                 $disp .= file_get_contents($extraMetas_path);
          else
              $disp .="
              <meta name='language' content='{$langs_STR}' />       \n
              <meta name='robots'   content='INDEX, FOLLOW' />      \n
              <meta name='author'   content='Serenity Media' />   \n
              <meta name='revisit-after'   content='1 DAYS' />      \n
                                                                                                                        ";

    #===================================================================================================================
        return $disp;
    }
    function setINI()
    {
        $id = $this->idC;
        $LG = $this->lang;


         $query = "SELECT SEO from ITEMS  WHERE id='{$id}' ";
         $SEO_res = $this->DB->query($query)->fetch_assoc();
         $SEO = unserialize($SEO_res['SEO']);

        $this->meta_DESCRIPTION = $SEO[$LG]['description_meta'];
        $this->meta_KEYWORDS    = $SEO[$LG]['keywords_meta'];
        $this->meta_TITLE       = $SEO[$LG]['title_meta'];
        $this->tag_TITLE        = $SEO[$LG]['title_tag'];



    }
    function __construct($C){

        $this->C   = &$C;
        $this->lang = &$C->lang;
        $this->idC = &$C->idC;
        $this->DB  = &$C->DB;
        $this->setINI();
    }

}