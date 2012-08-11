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
    var  $desc;             #  descrierea din ITEMS, pentru generat tagul <meta> (SEO stuff)
                            #                                         -> js/ csss

    var  $new;              # OPT:  'new '
    var  $disp_cont=1;
}
class vars extends item
{

    #_[DEFAULTS]______________________________________________________________________________________________

    /**
     * the types to work which can be MODELS OR MODULES.
     * - generaly the modules are used by the models;
     * - every type must have a protected & public part to it
     *
     * MODELS & MODULES
     *
     * PROTECTED part - cls. REQ - C[$mod_name].php
     *                - cls. OPT - AC[$mod_name].php               --> used for CMS ADMIN
     *
     * PUBLIC part    - MODELS  - OPT  -  js/anyName.js
     *                                 -  css/anyName.css
     *
     *                - MODULES - required  -  js/anyName.js
     *                                      -  css/anyName.css
     *__________________________________________________________________________________________________________________
     *
     *  $models = mod. that will be used;
     *  $modules
     *__________________________________________________________________________________________________________________
     *
     *   $default_MODULES    - the models & modules that should be integrated at any refresh of the site;
     *   $default_MODELS
     *__________________________________________________________________________________________________________________
     *   $admin_MOD  - array('mod_name'=>true, ... );         -- if a module has a class for ADMIN should be declared here;
     *   $theme_MOD  - array('mod_name'=>'theme_[name]',...); -- if a module or model has other themes than the default ones;
     *
     */

    var  $mods    = array('MODULES','MODELS');
    var  $models  = array('single','webchat','contact');
    var  $modules = array('Mail','MENUhorizontal');

    var  $default_MODULES = array('MENUhorizontal');
    var  $default_MODELS  = array('single');

    var $menus = array();


    var  $theme_MOD       = array();


    #_______________________________________________________________________________________________

    var  $id =1;                            # curent id   (item id)
    var  $idT=1;                            # id primar (primul nivel al tree-ului,  parent_id (p_id) = 0 ) ;
    var  $idC=1;                            # id curent

    var  $type='single';                     # type mod. aferent itemului cu idC;

    var  $type_MOD = 'MODELS';              # module || models
    var  $tree=array();                     # array( idC=>item OBJECT );

    #_______________________________________________________________________________________________

    var  $INC_css;                          # string de taguri css / js    - automat create de FMW;
    var  $INC_js;
    #______________________________________________________________________________________________
    var  $admin;                            #  true | false    - determinat in LOG.php
    var  $DB;                               #  mysqli object


    var  $lang='en';                        # curent language
    var  $lang2 ='ro';                      # alternate language
    var  $langs = array('ro','en');         # NOT IMPLEMENTED

    var  $display = '';                     # DEPRECATED '-edit', '_editADD'
    var  $HTML_headerIMG='';                # CONST content


}