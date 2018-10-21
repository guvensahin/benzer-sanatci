/**
 * yazar			Güven ŞAHİN <guvensahin@outlook.com>
 * web				http://guvensahin.com
 * son güncelleme	14 Kasım 2011
 */

$(function(){

	// auto complete
	$("#search-input").autocomplete({
		minLength: 1,
		source : 'suggest.php',
		select : function(event, ui){
				 $('#search-input').val(ui.item.label);
				 $('input#mbid').val(ui.item.mbid); // hidden input
				 $('form#form1').submit();
				} // end select
	})
	.data( "autocomplete" )._renderItem = function( ul, item ) {
			return $( "<li></li>" )
					.data( "item.autocomplete", item )
					.append( "<a><div class='suggest-img'><img src='" + item.img + "' alt='' /></div>" + item.label + "<div class='clear'></div></a>" )
					.appendTo( ul );
	}; // end auto complete


}); // end document ready
