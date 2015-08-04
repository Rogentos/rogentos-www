var LG = 'ro';
var procesSCRIPT_file  = 'procesSCRIPT.php';                   // intermediaza requesturile scripurilor .js
/*var parsePOSTfile2     = 'MODELS/products/ADMIN/PROMO.php';    // scriptul dorit pt $.post()*/

/**
 *  UTILIZARE:
   $.post(procesSCRIPT_file,  { parsePOSTfile : parsePOSTfile ,$_POST_array  } ) */


//====================================== [EXTRA OPTIONS] ===============================================================

function getHTMLtag(id)      {
    switch(this.INPTtype)
    {
        case 'button' : tag = "<span>" +
                                    "<input type='button' name='EXTRA' value='"+this.value+"' onclick=\"javascript:"+this.MODname+".EXTRAS_display('"+id+"');\"  style='width:"+this.width+"px;'>" +
                                    "<i>extra</i>" +
                             "</span>";
                        break;
        case 'submit' : tag = "<span>" +
                                    "<input type='submit' name='"+this.value+"_"+this.MODname+"' value='"+this.value+"'  style='width:"+this.width+"px;'>" +
                                    "<i>extra</i>" +
                             "</span>";
                        break;
    }

    return tag;
}

function alterCSS_EDITform() {
    width = this.width + 10;
    TOOLSem_width = width+parseInt($('#EDITform > .TOOLSem').css('width'));
    TOOLSem_marginLeft = (-1)*TOOLSem_width;
    $('#EDITform > .TOOLSem').css('width',TOOLSem_width)
                             .css('margin-left',TOOLSem_marginLeft);
}
function closeEXTRAS()       {

    $('#EXTRAS_display').remove();
}
function EXTRAS_display(id)  {
    $('body').append
    (
        "<div id='EXTRAS_display' >" +
            "<p><input type='button' name='closeEXTRAS' value='x'  onclick='javascript:"+this.MODname+".closeEXTRAS();'/></p>" +
        "</div>"
    );
    extraSTR='';
    for(var key in this.extras)
    {
        extraNAME =this.extras[key];

        $('#EXTRAS_display').append("<div class='"+extraNAME+"'></div>");
        eval(extraNAME+'('+id+')');
    }
    //extraSTR +=this.extras[key];
   // alert(extraSTR);
}
/**
 * MODname = apelantul(SINGname-ul)
 * extras  = numele functiei de extra
 * width   = width - butonul de extra
 * value   = denumirea butonului de extra
 * INPTtype   = input type button / submit
 *
 */

function EXTRAS(MODname,extras,width,value,INPTtype){

    this.MODname = MODname;
    this.extras = extras;
    this.width = width;
    this.value = value;
    this.INPTtype = INPTtype;
    this.getHTMLtag = getHTMLtag;
    this.alterCSS_EDITform = alterCSS_EDITform;
    this.EXTRAS_display = EXTRAS_display;
    this.closeEXTRAS = closeEXTRAS;

}




//======================================================================================================================

$(document).ready(function()      {


    /**
     * -- SETTINGS--
     *
     *  EDsel => EDname = new SELoptions(Array_ro,Array_en);
     *  extras => EDname_extra = functionName(id);
     */

    LG = $("input[name=lang]").val();  //Need to get the current LG;
   EditMODE();
});


function ExitEditMODE()           {

    $('input[name=editMODE]').show();
    $('input[name=exitEditMODE]').hide();
    $('#status_editMODE').val('false');

    $('form[id^=new_]').remove();
    $('.TOOLSem').remove();
    ExitEditContent('ENT');
    ExitEditContent('SING');

}
function EditMODE()               {

    $("div[class^=ENT], div[class^=SING]").wrapInner("<div class='content' />");          // pentru a putea recupera continutul

    setTOOLS();                                                                          // BTT de edit - EditContent(id,Name,TYPE)
    setENTadd();                                                                         // BTT de add - addENT(nameENT)
    $('input[name=editMODE]').hide();
    $('input[name=exitEditMODE]').show();


    $("div[class^=ENT] , div[class^=SING]").bind({
        mouseover   : function() { $(this).find('.TOOLSem').show();},
        mouseout    : function() { $(this).find('.TOOLSem').hide(); }
    });

}


function setTOOLS()               {

    $("div[class^=SING], div[class^=ENT]").map(function()
    {

        desc    = $(this).attr('id').split('_');
        TYPEarr = $(this).attr('class').split(' ');

        TYPE = TYPEarr[0];     //ENT || SING
        id   = desc[1];
        Name = desc[0];        //ENTname || SINGname
      //================================================================================================================
        $(this).prepend
        (
            "<div class='TOOLSem' style='display: none;'>" +
                "<span><input type='button' name='EDIT' value='e' onclick=\"EditContent('"+id+"','"+Name+"','"+TYPE+"')\"><i>Edit Content</i></span>" +
            "</div>"
        );
    });
}
function setENTadd()              {


    $('div[class^=allENTS]').map(function()
    {
            allENTS   = $(this);
            firstENT  = $(this).find('div[class^=ENT]:first');

            desc    = firstENT.attr('id').split('_');
            nameENT = desc[0];

        //________________________________________________________________________________________
        allENTS.prepend
        (
                  "<div class='TOOLSem'>" +
                      "<span><input type='button' name='addNewENT' value='+' onclick=\"addENT('"+nameENT+"')\"><i>Add new</i></span>" +
                  "</div>"
        );


        //________________________________________________________________________________________
                 content = firstENT.find('.content').html();
                 FORM_id    = "new_"+nameENT+'_'+LG;
                 FORM_class = nameENT+" addForm";
        //________________________________________________________________________________________
        firstENT.before
        (

                "<form action='' method='post' class='"+FORM_class+"'   id='"+FORM_id+"' style='display: none;'>" +
                    "<div class='TOOLSem'>                                                                        " +
                    "     <span><input type='submit' name='save_add"+nameENT+"' value='s' /><i>save</i></span>                         " +
                    "     <span><input type='button' name='EXIT' value='x' onclick=\"removeAddNew()\"><i>Exit</i></span>                 " +
                    "</div>                                                                                     " +
                    content +
                "</form>"

        );

        /* _____________________________________________________________________________________*/
        $("#"+FORM_id).find('div[class^=ED]').empty();
        TRANSFORM($("#"+FORM_id),'.addForm');

    });

}

function addENT(nameENT)          {
    addFORM_id    = "new_"+nameENT+'_'+LG;

    removeAddNew();
    $('.TOOLSem > input[name=addNewENT]').parent().hide();
    $("#"+addFORM_id).show();

    $("#"+addFORM_id).find('.PRDpic > img').replaceWith("<img src='./MODELS/products/RES/small_img/site_produs_slice_pisici.jpg' alt='placeholder_img'>");


}
function removeAddNew()           {
     addFORM_id    = "new_"+nameENT+'_'+LG;

    $('.TOOLSem > input[name=addNewENT]').parent().show();
    $("#"+addFORM_id).hide();

}

function ExitEditContent(TYPE)    {

  /* LG='ro'*/;
    //pt mai multe editoare
    $('textarea[id^=editor]').map(function(){

        id = $(this).attr('id');
         if (CKEDITOR.instances[id]) CKEDITOR.instances[id].destroy(true);
    });

   $('#EDITform').remove();
   $('.'+TYPE).not('div[id*=_new_]').show();

}
function EditContent(id,Name,TYPE){


     ExitEditContent(TYPE);
     DELETE_tag='';
     EXTRAS_TAG='';
   //___________________________________________________________________________________________________________________


    if(TYPE == 'ENT')
        DELETE_tag =  "<span><input type='submit' name='delete_"+Name+"' value='d' /><i>Delete</i></span>" ;

    if(eval('typeof '+Name+'_extra != "undefined" '))
        EXTRAS_TAG = eval(Name+'_extra.getHTMLtag("'+id+'")'); //  daca este definit un Obiect de extra


    BLOCK   = $('div[id='+Name+'_'+id+'_'+LG+']');
    content = BLOCK.find('.content').html();

  //====================================================================================================================

   BLOCK.after
   (
        "<form action='' method='post' class='"+Name+"' id='EDITform' >" +
            "<input type='hidden' name='BLOCK_id' value='"+id+"' />" +
            "<div class='TOOLSem'>" +

                EXTRAS_TAG+
                "<span><input type='submit' name='save_"+Name+"' value='s' /><i>Save</i></span>" +

                 DELETE_tag+
                "<span><input type='button' name='EXIT' value='x' onclick=\"ExitEditContent('"+TYPE+"')\"><i>Exit</i></span>" +


            "</div>" +
            content+
        "</form>"
   );
 //=====================================================================================================================
    // daca este definit un Obiect de extra
    if( eval('typeof '+Name+'_extra != "undefined" '))  eval(Name+'_extra.alterCSS_EDITform()');


//======================================================================================================================
   TRANSFORM(BLOCK,'#EDITform');
   BLOCK.hide();
}



function TRANSFORM(BLOCK,formName){


    BLOCK.find('*[class^=ED]').map(function(){
       // selELEM =  $(this).attr('class')+' ';

        desc = ($(this).attr('class')+' ').split(' ');

        EDtype  = desc[0];   last= desc.length-2; //  (-2)  1- este ca sa imi ajunga la 0 si inca 1 pentru ca pune un elem in plus , nu stiu de ce
        EDname  = desc[last];


        if(EDtype=='EDeditor' || EDtype=='EDpic') EDvalue = $.trim($(this).html());
        else  EDvalue = $.trim($(this).text());



      //  alert('EDname '+EDtype+'  EDname '+EDname+' value '+EDvalue);
        REPLACE(EDtype, EDname, EDvalue,formName);
    });


}
//_______________________________________[ EDsel ] _____________________________________________________________________
function getHTMLoptions(selected)                  {
    i = 0; HTMLopt='';
    while(this.options[i])
    {
        if(selected == this.options[i])  HTMLopt +="<option selected>"+this.options[i]+"</option>\n";
        else HTMLopt +="<option>"+this.options[i]+"</option>\n";
        i++;
    }
    /*alert(HTMLopt);*/
    return HTMLopt;
}
function SELoptions(optionsRO,optionsEN)           {

    switch(LG)
    {
        case 'ro': this.options = optionsRO; break;
        case 'en': this.options = optionsEN; break;
    }
    this.getHTMLoptions = getHTMLoptions;


}  //USE: EDname = new SELoptions(Array_ro,Array_en);

function REPLACE(EDtype, EDname, EDvalue,formName) {
    //alert(EDtype+' '+EDname+" "+EDvalue+" "+formName);

    /*LG='ro';*/
    EDtag        = formName + ' *[class^='+EDtype+'][class$='+EDname+']';
    INPUTname    = EDname+"_"+LG;
    INPUTclass   = 'EDITOR '+EDname;
    EDtag_height = $(EDtag).height()+'px';
    EDtag_width = $(EDtag).width();


    //____________________________________________________________________________________________________________________________________

    switch(EDtype)
    {
        case 'EDtxt'   : EDtag_replacement = "<input type='text' name='"+INPUTname+"'  class='"+INPUTclass+"' value='"+EDvalue+"' />"; break;
        case 'EDtxa'   : EDtag_replacement ="<textarea   name='"+INPUTname+"'  class='"+INPUTclass+"' >"+EDvalue+"</textarea>";       break;
        case 'EDeditor': EDtag_replacement ="<textarea   name='"+INPUTname+"'  class='"+INPUTclass+"'  id='editor_"+EDname+'_'+LG+"' >"+EDvalue+"</textarea>";break;
        case 'EDpic'   : IDpr = $('input[name=IDpr]').val();
                       // if(typeof IDpr!='undefined') INPUTname='';
                         //(form,url_action,id_element,html_show_loading,html_error_http)
                        EDtag_replacement ="<div class='"+INPUTclass+"' id='frontpic'>" +
                                                 EDvalue+
                                                "<div  id='formUPL' >"+
                                                     "<input type='file' id='fileUPL' name='filename_"+INPUTname+"' class='fileinput'  />" +
                                                     "<input type='hidden' name='id' value='"+IDpr+"'>" +
                                                    /* "<input type='submit' name='UPLDimg' value='UP'>"+*/
                                                 "</div>" +
                                             "</div>"
                                             ;
                        $('#EDITform').attr('enctype','multipart/form-data');
                        $('#EDITform').attr('encoding','multipart/form-data');
                        break;

        case 'EDsel'   :if(eval('typeof '+EDname+'!= "undefined" ')) options = eval(EDname+'.getHTMLoptions("'+EDvalue+'")');
                        else alert('nu l-a recunoscut ca obiect');
                        EDtag_replacement ="<select name='"+INPUTname+"' class='"+INPUTclass+"'>"+options+"</select>";
                        break;


    }


    //____________________________________________________________________________________________________________________________________
    $(EDtag).replaceWith(EDtag_replacement);
    //____________________________________________________________________________________________________________________________________
    if(EDtype == 'EDeditor')
    {
        toolbar_conf = 'smallTOOL';
        toolbar_conf = (EDtag_width < 500 ? 'EXTRAsmallTOOL' : 'smallTOOL' );

        CKEDITOR.replace( 'editor_'+EDname+'_'+LG,
                              {
                                  toolbar : toolbar_conf,
                                  height : EDtag_height
                                //,width : EDtag_width
                              });
                      //$("textarea[id=editor_"+EDname+'_'+LG+"]").ckeditor();

    }

}



