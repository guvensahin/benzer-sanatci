/**
 * yazar			Güven ŞAHİN <guvenn@hotmail.com.tr>
 * web				http://guven.kimdir.com
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
	
	
	
	// zclip
	$('a#kopyala').zclip({
		path : 'inc/js/zclip/ZeroClipboard.swf',
		copy : $('input#share_input').val(),
		afterCopy : function(){
			$('span#share_url_msg').css('display','inline').hide().fadeIn('slow');
			}
	});	
	
	
	
	// target blank
	$('a.sekme').attr('target','_blank');
	
	
	
	// facebook like for ie
	$('.fblike').attr('allowTransparency', 'true');
	
	
	
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
	
	
	
	// contact.php de matematik işlemini yükler
	$('span#soru_text').load('./soru.php');
	
	
	
	
}); // end document ready




// benzer sanatçıların youtube'daki ilk videolarını getirir
function get_video($index)
{
	var cn = '.y' + $index;
		q  = $('.name' + $index).text();
		q  = q.replace(/'/g,"");


	// aynı sayfada daha önce istek yapılıp youtube linki bulunmuş ise tekrardan yapılmasına gerek kalmaz
	var ylink = $(cn).attr('href');

	if (ylink == '#')
	{
		$.ajax({
		type	: 'POST',
		url		: 'get_video.php',
		data	: 'q=' + q,
		success	: function(cevap)
					{
						if (cevap == 'hata')
						{
							alert('Üzgünüz. Bu sanatçı için örnek video bulamadık.');
						}
						else
						{
							$(cn).attr('href',cevap);
							$(cn).click();
						}
					}
		}) // end ajax
	}
	else
	{
		$(cn).click();
	}
	
	return false;
} // end func



// lists.php de tıklanan sanatçıyı sistemde aratır
/*
15.06.2012 güncellemesiyle beraber listedeki sanatçılara direct link ile ulaşılmakta.

function searchx($cn)
{
	var q = $('a' + $cn).text();
	//alert(q);
	
	$('input#search-input').val(q);
	$('form#form1').submit();
	return false;
}
*/





// about.php paypal
function donate()
{
	$('form#donate').submit();
	return false;
}





