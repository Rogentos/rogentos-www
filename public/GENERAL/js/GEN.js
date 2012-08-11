
/*_____________________[SETING CURRENT BUTTONs]________________________________________*/


$(document).ready(function(){


   current_idT = $('input[name=current_idT]').val();
   current_idC = $('input[name=current_idC]').val();
   $('ul.MENUhorizontal>li a#'+current_idT).addClass('current');
   $('div#children_display > ul > li > a#'+current_idC).addClass('current');


});

/*_____________________________________________________________________________________*/

