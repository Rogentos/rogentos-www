<?php
class ADMIN_vars extends CsetINI
{

    var $TMPtree=array();
    var $user;                   #NOT IMPLEMENTED obj de tip Perms;
    var $HTML_GEN_edit = '';     #????

    var $admin_MOD     = array('single'=>true,'TOOLbar'=>true,'GEN_edit'=>true,'EDITmode'=>true,'moderation'=>true,'EDITmode'=>true);

    var $ADMIN_default_MODELS = array('EDITmode');
    var $ADMIN_default_MODULES = array('TOOLbar','GEN_edit','EDITmode');

    public function mergeArray(){

        $this->default_MODULES = array_merge($this->default_MODULES,$this->ADMIN_default_MODULES);
        $this->default_MODELS = array_merge($this->default_MODELS,$this->ADMIN_default_MODELS);


    }
}