var parsePOSTfile2     = 'MODELS/products/ADMIN/PROMO.php';    // scriptul dorit pt $.post()

/**
 * -- SETTINGS--
 *
 *  EDsel => EDname = new SELoptions(Array_ro,Array_en);
 *  extras => EDname_extra = functionName(id);
 */
SGproduct_extra = new EXTRAS('SGproduct_extra',Array('Reduceri'),40,'extra','button');
contPOP_extra   = new EXTRAS('contPOP','',45,'delete','submit');

//_____________________________________ [ custom extras ] ______________________________________________________________
function Reduceri(id)  {
    $('.Reduceri').load( procesSCRIPT_file,
        {parsePOSTfile:parsePOSTfile2, idPR:id, display:'true'},
        function(response, status, xhr) {

            $('input[name=end_promo]').datepicker({ dateFormat: "dd-mm-yy" });
            $('input[name=end_new]').datepicker({ dateFormat: "dd-mm-yy" });
        });

    //return '<b>REturnez reduceri</b><br/>';
}
function savePromo(id) {
    pret_promo = $('input[name=pret_promo]').val();
    end_promo = $('input[name=end_promo]').val();

    NEWstatus = $('input[name=NEWstatus]:radio:checked').val();
    end_new = $('input[name=end_new]').val();


     $.post(procesSCRIPT_file,
     {
        parsePOSTfile :parsePOSTfile2,
        idPR:id,
        saveExtras:'true',
        promo : pret_promo,
        end_promo : end_promo,
        new : NEWstatus,
        end_new : end_new

     });

    alert('S-au modificat urmatoarele : \n pret promo: '+pret_promo+'\n End promo '+end_promo+'\n NEW status '+NEWstatus+'\n End new '+end_new);
    $('#BLANCKform_PROMO').submit();
    //SGproduct_extra.closeEXTRAS();
}