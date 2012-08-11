function tables(i){
    //$('.submission_table').hide();
    $('div[id='+i+'_submission_en]  table').toggle();
    $('div[id='+i+'_submission_en]  div.submission_top').toggleClass('submission_top_selected');
}

function hideTables(id){
    //$('.submission_table').hide();
    $('div[id$=_submission_en]  table').hide();
    $('div[id$=_submission_en]  div.submission_top').removeClass('submission_top_selected');
}

function showTables(i){
    //$('.submission_table').hide();
    $('div[id='+i+'_submission_en]  table').show();
    $('div[id='+i+'_submission_en]  div.submission_top').toggleClass('submission_top_selected');
}

