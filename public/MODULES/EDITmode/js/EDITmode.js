var LG = 'en';
function getHTMLoptions(selected){
    i = 0;
    HTMLopt='';
   /* while(this.options[i])
    {
        if(selected == this.options[i])  HTMLopt +="<option value='"+this.options[i]+"' selected>"+this.options[i]+"</option>\n";
        else HTMLopt +="<option>"+this.options[i]+"</option>\n";
        i++;
    }*/

    for(var i in this.options)
        {
            if(selected == this.options[i] || this.options[i].substring(0,15)==selected.substring(0,15) )
            {
                if(this.selWHAT =='id' )    HTMLopt +="<option value='"+i+"' selected>"+i+'. '+this.options[i]+"</option>\n";
                else                        HTMLopt +="<option value='"+this.options[i]+"' selected>"+this.options[i]+"</option>\n";
            }
            else
            {
                if(this.selWHAT =='id' )   HTMLopt +="<option value='"+i+"' >"+i+'. '+this.options[i]+"</option>\n";
                else HTMLopt +="<option>"+this.options[i]+"</option>\n";
            }

        }
    /*alert(HTMLopt);*/
    return HTMLopt;
}
function SELoptions(optionsRO,optionsEN,selWHAT)     {

    switch(LG)
    {
        case 'ro': this.options = optionsRO; break;
        case 'en': this.options = optionsEN; break;
    }
    if(selWHAT== 'id') this.selWHAT = 'id';
    else this.selWHAT = 'content';
    this.getHTMLoptions = getHTMLoptions;
}




$(document).ready(function(){


    LG = $("input[name=lang]").val();


    $("div[class^=SING]").wrapInner("<div class='content' />")
    $("div[class^=ENT]").wrapInner("<div class='content' />")

    //if($('#status_editMODE').val()=='true')

   // edit la mouse over
   EditMODE();

        $("div[class^=ENT] , div[class^=SING]").mouseover(function(){
            $(this).find('.TOOLSem').show();
        });
        $("div[class^=ENT] , div[class^=SING]").mouseout(function(){
             $(this).find('.TOOLSem').hide();
        });





});



function changeLG(lang){
    LG = lang;
    ExitEditENT();

    $("div[class=pageCont]").hide();
    $("div[class=pageCont][id="+LG+"]").show();

}


function EditMODE()
{
    setENTtools();
    setSINGtools();
    /*setENTadd();*/
    $('input[name=editMODE]').hide();
    $('input[name=exitEditMODE]').show();
    $('#status_editMODE').val('true');
}
function ExitEditMODE(){

    $('input[name=editMODE]').show();
    $('input[name=exitEditMODE]').hide();
    $('#status_editMODE').val('false');

    $('form[id^=new_]').remove();
    $('.TOOLSem').remove();
    ExitEditContent('ENT');
    ExitEditContent('SING');

}


function ExitEditContent(TYPE)
{
  /* LG='ro'*/;
    /*id = $('textarea[id^=editor]').attr('id');
    if (CKEDITOR.instances[id]) CKEDITOR.instances[id].destroy(true);*/
    //pt mai multe editoare
    $('textarea[id^=editor]').map(function(){

        id = $(this).attr('id');
        if (CKEDITOR.instances[id]) CKEDITOR.instances[id].destroy(true);
    });

    if(typeof id != 'undefined') hideTables(id);

   $('#EDITform').remove();
   $('.'+TYPE).show();

}



function setENTtools ()
{
    $(" div[class^=ENT]").map(function()
    {
        desc = $(this).attr('id').split('_');
        id      = desc[0];
        ENTname = desc[1];

        $(this).prepend
        (
            "<div class='TOOLSem' style='display: none;'>" +
                "<span><input type='button' name='EDIT' value='e' onclick=\"EditContent('"+id+"','"+ENTname+"','ENT')\"><i>Edit Content</i></span>" +
            "</div>"
        );
    });

}

function setSINGtools ()
{
    $(" div[class^=SING]").map(function()
    {
        desc = $(this).attr('id').split('_');
        SINGname = desc[0];

        $(this).prepend
        (
            "<div class='TOOLSem' style='display: none;'>" +
                "<span><input type='button' name='EDIT' value='e' onclick=\"EditContent('','"+SINGname+"','SING')\"><i>Edit Content</i></span>" +
            "</div>"
        );
    });

}
function EditContent(id,Name,TYPE)
{

    ExitEditContent(TYPE);

    if(id) showTables(id);
    else id = '';

   //________________________________________________________________________________________________________

   DELETE_tag='';uline='';
   if(TYPE == 'ENT') { DELETE_tag =  "<span><input type='submit' name='delete_"+Name+"' value='d' onclick=\"if(confirm('Delete submission: press OK if you really mean it')) return true; else return false;\" /><i>Delete</i></span>" ;
                        uline='_';}

   BLOCK   = $('div[id='+id+uline+Name+'_'+LG+']');
   content = BLOCK.find('.content').html();

  //________________________________________________________________________________________________________

   BLOCK.after
   (
        "<form action='' method='post' class='"+Name+"' id='EDITform' >" +
            "<input type='hidden' name='BLOCK_id' value='"+id+"' />" +
            "<div class='TOOLSem'>" +


                "<span><input type='submit' name='save_"+Name+"' value='s' /><i>Save</i></span>" +

                 DELETE_tag+
                "<span><input type='button' name='EXIT' value='x' onclick=\"ExitEditContent('"+TYPE+"')\"><i>Exit</i></span>" +


            "</div>" +
            content+
        "</form>"
   );
 //________________________________________________________________________________________________________
   TRANSFORM(BLOCK,'#EDITform');
   BLOCK.hide();
}







function setENTadd()
{


    $('div[class^=allENTS]').map(function()
    {
            allENTS = $(this);
            firstENT  = $(this).find('div[class^=ENT]:first');

            desc = firstENT.attr('id').split('_');
            nameENT = desc[1];

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
function addENT(nameENT)
{
    addFORM_id    = "new_"+nameENT+'_'+LG;

    removeAddNew();
    $('.TOOLSem > input[name=addNewENT]').parent().hide();
    $("#"+addFORM_id).show();

    $("#"+addFORM_id).find('.PRDpic > img').replaceWith("<img src='./MODELS/products/RES/small_img/site_produs_slice_pisici.jpg' alt='placeholder_img'>");


}
function removeAddNew()
{
     addFORM_id    = "new_"+nameENT+'_'+LG;

    $('.TOOLSem > input[name=addNewENT]').parent().show();
    $("#"+addFORM_id).hide();

}







function TRANSFORM(BLOCK,formName)
{
    BLOCK.find('div[class^=ED]').map(function(){
       // selELEM =  $(this).attr('class')+' ';

        desc = ($(this).attr('class')+' ').split(' ');

        EDtype  = desc[0]; last= desc.length-2;

        EDname  = desc[last];


        if(EDtype=='EDeditor' || EDtype=='EDpic') EDvalue = $.trim($(this).html());
        else  EDvalue = $.trim($(this).text());


       // alert('EDname '+EDtype+'  EDname '+EDname+' value '+EDvalue);
        REPLACE(EDtype, EDname, EDvalue,formName);
    });



/*    $('#fileUPL').bind('change', function() {

        IDpr = $('input[name=IDpr]').val();
        param2 = "../protected/MODELS/products/ADMIN/upload.php?size=M&filename=filename&p=0&id="+IDpr+" ";
        param3 = "frontpic";
        param4 =" File Uploading Please Wait...<br /><img src=\"./MODELS/products/ADMIN/images/loader_light_blue.gif\" width=\"128\" height=\"15\" border=\"0\" /> ";
        param5 =" <img src=\"./MODELS/products/ADMIN/images/error.gif\" width=\"16\" height=\"16\" border=\"0\" /> Error in Upload, check settings and path info in source code. ";



       // ajaxUpload('formUPL',param2,param3,param4,param5); return false;
        $('#formUPL').submit();

    });*/
}

function REPLACE(EDtype, EDname, EDvalue,formName)
{
    /*LG='ro';*/
    EDtag        = formName + ' div[class^='+EDtype+'][class$='+EDname+']';
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
                         //(form,url_action,id_element,html_show_loading,html_error_http)
                        EDtag_replacement ="<div class='"+INPUTclass+"' id='frontpic'>" +
                                                 EDvalue+
                                                "<div  id='formUPL' >"+
                                                     "<input type='file' id='fileUPL' name='filename' class='fileinput'  />" +
                                                     "<input type='hidden' name='id' value='"+IDpr+"'>" +
                                                     "<input type='submit' name='UPLDimg' value='UP'>"+
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
        //alert('editor');
        toolbar_conf = 'smallTOOL';
        toolbar_conf = (EDtag_width < 400 ? 'EXTRAsmallTOOL' : 'Comoti' );

        CKEDITOR.replace( 'editor_'+EDname+'_'+LG,
                              {
                                  toolbar : toolbar_conf,
                                  height : EDtag_height
                              });
                      //$("textarea[id=editor_"+EDname+'_'+LG+"]").ckeditor();

    }

}



