jQuery(function($) {

	"use strict";
// reset field rating
jQuery('.themepacific_wpreview_clear_rating').click(function() {
	jQuery(this).parent().children('.themepacific_wpreview_rate_text').val('');
	jQuery(this).parent().children('.tpcrn_rating_val').val('');
	crnwpreviewTotal();
	return false;
});

 

$( "#crn_rate_style" ).change(function() {
	jQuery('input.tpcrn_rating_val').each(function() {
		var $ratiStyle = $( "#crn_rate_style" ).val();
		if($ratiStyle == 'star'){
			$(this).attr('max','5');
 		}else{
			$(this).attr('max','10');
 		}
 
 	});
});

jQuery("#crn_rating-repeatable li").hover(
	function(){jQuery(this).children('.themepacific_wpreview_clear_rating').fadeIn('slow');},
	function(){jQuery(this).children('.themepacific_wpreview_clear_rating').fadeOut('10');}
	);

jQuery(".tpcrn_rating_val").on("change",function(){
	crnwpreviewTotal();
});
function crnwpreviewTotal(){
		var total = 0;
	jQuery('input.tpcrn_rating_val').each(function() {

		if(jQuery(this).val() != '')
			total += parseFloat(jQuery(this).val())|| 0;	
	});
	jQuery('#tpcrn_rating_tot').val(total);	
}


 
});
