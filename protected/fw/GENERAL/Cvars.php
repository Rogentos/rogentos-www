<?php
class item
{
    var  $id;              # id curent
    var  $p_id;            # id parinte;
    var  $children;        # array( poz=>id_child )


    var  $name_ro;          # corespondent din BD (titlu[LG])
    var  $name_en;
    var  $name;             # name of the current language    RULE:  name    = name[LG]
    var  $nameF;            # numele fisierului din RES ;     RULE:  nameF  = str_replace(' ', '_' , name)

    var  $type;             #  tipul modelului / modulului  determina ->   mod.-ul  instantiat
                            #                                         -> js/ csss

    var  $new;              # OPT:  'new '
    var  $disp_cont=1;
}
class vars extends item
{

    #_[DEFAULTS]______________________________________________________________________________________________

    /**
     * the types to work with can be MODELS OR PLUGINS.
     * - generaly the plugins are used by the models;
     * - every type must have a protected & public part to it
     *
     * MODELS & PLUGINS
     *
     * PROTECTED part - cls. REQ - C[$mod_name].php
     *                - cls. OPT - AC[$mod_name].php               --> used for CMS ADMIN
     *
     * PUBLIC part    - MODELS  - OPT  -  js/anyName.js
     *                                 -  css/anyName.css
     *
     *                - PLUGINS - required  -  js/anyName.js
     *                                      -  css/anyName.css
     *__________________________________________________________________________________________________________________
     *
     *  $models = mod. that will be used;
     *  $plugins
     *__________________________________________________________________________________________________________________
     *
     *   $default_PLUGINS    - the models & plugins that should be integrated at any refresh of the site;
     *   $default_MODELS
     *__________________________________________________________________________________________________________________
     *   $admin_models  - array('mod_name'=>true, ... );         -- if a module has a class for ADMIN should be declared here;
     *   $theme_MOD  - array('mod_name'=>'theme_[name]',...); -- if a module or model has other themes than the default ones;
     *
     */

    var  $mods            = array('PLUGINS','MODELS');
    var  $models          = array('siteMap','contact','products','single','basket','mainPOPup');
    var  $plugins         = array('formake','toolbar','MENUhorizontal','MENU_h_multiLevel','TOOLbar','GEN_edit','EDITmode');

/*    var  $default_PLUGINS = array('LANG','MENUhorizontal','menuPROD','SEO');
    var  $default_MODELS  = array('basket','mainPOPup');

    var  $menus = array(1=>'MENUhorizontal',2=>'MENUhorizontal',3=>'menuPROD'); */

    var  $default_PLUGINS = array();
    var  $default_MODELS  = array();
    var  $menus = array();


#=======================================================================================================================

    var  $id =1;                            # curent id   (item id)
    var  $idT=1;                            # id primar (primul nivel al tree-ului,  parent_id (p_id) = 0 ) ;
    var  $idC=1;                            # id curent

/*    var  $type='products';                  # type mod. aferent itemului cu idC;
    var  $type_MOD = 'MODELS';              # module || models*/

    var  $type;                  # type mod. aferent itemului cu idC;
    var  $type_MOD;              # plugin || models


    var  $tree=array();                     # array( idC=>item OBJECT );

#========================================== [ HISTORY ] ================================================================
    var  $history = array();                # id-uri
    var  $history_HREF='';                  # lista de linkuri
    var  $history_TITLE='';                 # aferent tagului <title>
    var  $history_TITLE_keywords='';

#========================================== [ SEO ] ====================================================================


#=======================================================================================================================

    var  $INC_css;                          # string de taguri css / js    - automat create de FMW;
    var  $INC_js;
#_______________________________________________________________________________________________________________________
    var  $admin;                            #  true | false    - determinat in LOG.php
    var  $DB;                               #  mysqli object


    var  $lang='ro';                        # curent language
    var  $lang2;                            # alternate language
    var  $langs = array('ro');             # NOT IMPLEMENTED
/*
    var  $lang='ro';                        # curent language
    var  $lang2 ='en';                      # alternate language
    var  $langs = array('ro','en');         # NOT IMPLEMENTED*/

    var  $display = '';                     # DEPRECATED '-edit', '_editADD'
    var  $HTML_headerIMG='';                # CONST content




}

class ADMIN_vars extends CsetINI
{

    var $TMPtree=array();
    var $user;                   #NOT IMPLEMENTED obj de tip Perms;
    var $HTML_GEN_edit = '';     #????

    var $admin_models          = array();
    var $ADMIN_default_PLUGINS = array();
/*  var $admin_models     = array('products'=>true, 'page'=>true,'portof'=>true,'news'=>true,'TOOLbar'=>true,'GEN_edit'=>true,'EDITmode'=>true);
    var $ADMIN_default_PLUGINS = array('TOOLbar','GEN_edit','EDITmode');*/



    public function mergeArray(){

        $this->default_PLUGINS = array_merge($this->default_PLUGINS,$this->ADMIN_default_PLUGINS);


    }
}