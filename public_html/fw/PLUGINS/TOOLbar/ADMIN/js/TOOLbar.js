var LG='en';
var activePOPup = 0;
$(document).ready(function(){

    LG = $('input[name=lang]').val();

    currentPOPUP = $('input[name=statusPOPUP]').val();
    if(currentPOPUP)
    {
        activatePOPUPedit(currentPOPUP);
        $('input[name=statusPOPUP]').val('');
    }


});

function activatePOPUPedit(modName)
{
    if(activePOPup == 0)
    {
         $('#admin_POPUP').show();
         $.get('/RES/PLUGINS/'+LG+'/'+modName+'.html',function(data)
         {
        $('#admin_POPUP > #admin_POPUP_content').append(data);
        ctrl_INIadmin(modName);

        $('#admin_POPUP > #admin_POPUP_content form').append
        (
            "<input type='hidden' name='currentPOPUP' value='"+modName+"' />"
        );
    });
         activePOPup = 1;
    }

}

function CLOSE_admin_POPUP()
{
    $('#admin_POPUP > #admin_POPUP_content').empty();
    $('#admin_POPUP').hide();

}

function ctrl_INIadmin(modName)
{
    if(modName=='GEN_edit')INIadmin_GEN_edit();
}