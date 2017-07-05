$(function() {
	$('.select a').click(function() {
		var tab_id=$(this).attr('id');
		tabClick(tab_id)
	});

	function tabClick(tab_id) {
		$('.select .type').removeClass('type_active');

		if (tab_id != $('.promo a.active').attr('id') ) {

			 $('.promo .random').removeClass('block_active');
			 $('#'+tab_id).addClass('type_active');
			 $('#con_' + tab_id).addClass('block_active');

		}
	}

	$('.main-tabs a').click(function() {
		var tab_id=$(this).attr('id');
		tabClick1(tab_id)
	});
	
	function tabClick1(tab_id) {
		$('.main-tabs .desc').removeClass('desc_active');

		if (tab_id != $('.main-tabs a.active').attr('id') ) {

			 $('.teeeest .di_tabs').removeClass('block_active');
			 $('#'+tab_id).addClass('desc_active');
			 $('#con_' + tab_id).addClass('block_active');

		}
	}

});