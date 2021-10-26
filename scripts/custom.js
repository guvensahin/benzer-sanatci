/**
 * yazar			Güven ŞAHİN <guvensahin@outlook.com>
 * web				http://guvensahin.com
 * son güncelleme	12 Eylül 2012
 */

$(function(){
	
	// timeago
	// Turkish
	jQuery.extend($.timeago.settings.strings, {
	   suffixAgo: 'önce',
	   suffixFromNow: null,
	   seconds: '1 dakikadan',
	   minute: '1 dakika',
	   minutes: '%d dakika',
	   hour: '1 saat',
	   hours: '%d saat',
	   day: '1 gün',
	   days: '%d gün',
	   month: '1 ay',
	   months: '%d ay',
	   year: '1 yıl',
	   years: '%d yıl'
	});	
	
	$("abbr.timeago").timeago();
	
	
	
	// poshytip
	$('.poshytip').poshytip({
		className: 'tip-twitter',
		showTimeout: 1,
		alignTo: 'target',
		alignX: 'center',
		offsetY: 5,
		allowTipHover: false
	});
	
	
	// target blank
	$('a.sekme').attr('target','_blank');
	
	
	
	// search input ve highlight
	// global
	sval = 'Sanatçı ara...';
	
	$('#search-input').val(sval);
	
	
	$('#search-input').focus(function()
	{
		if($(this).val() == sval){ $(this).val('') };
		
		$('.search-element-highlight').animate({backgroundColor:'#f3f3f3'},750);
	});
	
	$('#search-input').blur(function()
	{
		if($(this).val() == ''){ $(this).val(sval) };
		
		$('.search-element-highlight').animate({backgroundColor:'#fff'},500);
	});
	
	
	
	// buton ile herhangi bir içerik yazmadan direk arama yapmaya kalkışılır ise
	$('#search-button').click(function()
	{
		if($('#search-input').val() == sval)
		{
			alert('Lütfen bir sanatçı ismi yazınız.');
			return false;
		}
	});
	
	
	
	// main menu highlight
	$('#nav ul li').mouseover(function()
	{
		$(this).animate({backgroundColor:'#f3f3f3'},150);
	});
	
	$('#nav ul li').mouseout(function()
	{
		$(this).animate({backgroundColor:'#fff'},150);
	});
	
	
	
	/********************* AJAX *********************/
	
	
	// result.php de benzeri gösterilen sanatçının resmini getirir	
	var q = $('h1.similar_search').text();
	
	if (q != "")
	{
		$.ajax({
		type	 : 'POST',
		url		 : 'get_info.php',
		data	 : 'q=' + q,
		dataType : 'json',
		success	 : function(cevap)
					{
						$('img.similar_search').attr('src',cevap.large);
					}
		}) // end ajax
	} // end if
	
	
	
	// result.php de listelenen sanatçıların biolarını getirir
	$('h2.similar_artist').each(function(i,v)
	{
		$.ajax({
		type	 : 'POST',
		url		 : 'get_info.php',
		data	 : 'q=' + $(this).text(),
		dataType : 'json',
		success	 : function(cevap)
					{
						$('p.bio' + i).html(cevap.bio);
					}
		}) // end ajax
	});
	
	
	
	// anasayfada rastgele değişen resimleri getirir
	$('div.random-kapsul').load('./get_top_artists.php', function(){
		$(this).hide().fadeIn('normal');
		});
	
	
	
	// lists.php de son görüntülenen sanatçıların resimlerini getirir
	$('a.last_viewed').each(function(i,v)
	{
		$.ajax({
		type	 : 'POST',
		url		 : 'get_info.php',
		data	 : 'q=' + $(this).text(),
		dataType : 'json',
		success	 : function(cevap)
					{
						$('img.last_viewed_img' + i).attr('src',cevap.large);
					}
		}) // end ajax
	});
	

	// anasayfa autocomplete
	if ($('#search-input').length > 0)
	{
		// auto complete
		$("#search-input").autocomplete({
			minLength: 1,
			source: 'suggest.php',
			select: function (event, ui) {
				$('#search-input').val(ui.item.label);
				$('input#mbid').val(ui.item.mbid); // hidden input
				$('form#form1').submit();
			} // end select
		})
			.data("autocomplete")._renderItem = function (ul, item) {
				return $("<li></li>")
					.data("item.autocomplete", item)
					.append("<a><div class='suggest-img'><img src='" + item.img + "' alt='' /></div>" + item.label + "<div class='clear'></div></a>")
					.appendTo(ul);
			}; // end auto complete
	}
	
	
}); // end document ready
