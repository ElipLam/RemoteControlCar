
(function ($) {
	"use strict";
	$('.column100').on('mouseover',function(){
		var table1 = $(this).parent().parent().parent();
		var table2 = $(this).parent().parent();
		var verTable = $(table1).data('vertable')+"";
		var column = $(this).data('column') + ""; 

		$(table2).find("."+column).addClass('hov-column-'+ verTable);
		$(table1).find(".row100.head ."+column).addClass('hov-column-head-'+ verTable);
	});

	$('.column100').on('mouseout',function(){
		var table1 = $(this).parent().parent().parent();
		var table2 = $(this).parent().parent();
		var verTable = $(table1).data('vertable')+"";
		var column = $(this).data('column') + ""; 

		$(table2).find("."+column).removeClass('hov-column-'+ verTable);
		$(table1).find(".row100.head ."+column).removeClass('hov-column-head-'+ verTable);
	});
    

})(jQuery);

$(document).ready(function(){
	$("#user tr").click(function(){
		var text1 = $(this).find('#username1').text();
		$("#inputUsername1").val(text1);

		var text2 = $(this).find('#password1').text();
		$("#inputPassword1").val(text2);

		var text3 = $(this).find('#id1').text();
		$("#inputId1").val(text3);

	})

	$("#car tr").click(function(){
		var id = $(this).find('#carid').text();
		$("#inputcarid").val(id);

		var name = $(this).find('#carname').text();
		$("#inputcarname").val(name);

		var state = $(this).find('#carstate').text();
		$("#inputcarstate").val(state);
	})
});