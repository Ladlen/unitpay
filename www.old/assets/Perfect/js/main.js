$(function(){
//diagrams small



	
	/*  calculator  */
	
	//calc();
	var amount=$('.amount');

	//$('.plans_select').on('change', calc);

	/*amount.on('change keyup', function(){
			var min=parseFloat($('.calc-min').text());
			var max=parseFloat($('.calc-max').text());
			var percent=$('.plans_select').val();
			var e=$(this).val();
			if (e>max) e=max;
			$(this).val(e);
			var position=Math.round((e-min)*($( "#drag" ).parent().width()-$( "#drag" ).width())/(max-min));
			if (position<0) position=0;
			$('#drag').animate({'left': position+'px'},400);
			calculate(e, percent);
		}).on('keypress', isNumberKey);
*/
$('.macpay-buyButton').on('click',function(){
			var tovar_id  =$('#item-selected').val();
			var tovar_block=$('div[rel='+tovar_id+']');
			var min=tovar_block.find('.min_count').text();
			var max=tovar_block.find('.max_count').text();
			var price=tovar_block.find('.price').text();
			$('#count_buy').text(min);
			$('.min_text').text(min);
			$('.max_text').text(max);
			$('#amount > i').html(min*price+' <small>RUB</small>');
			$('#drag').css({'left':'0px'});
});



	$( "#drag" ).draggable({cursor: "e-resize", axis: "x" ,containment: "parent", drag: function(event, ui) 
			{ 
			var tovar_id  =$('#item-selected').val();
			var tovar_block=$('div[rel='+tovar_id+']');
			var price=tovar_block.find('.price').text();
			var min=tovar_block.find('.min_count').text();
			var max=tovar_block.find('.max_count').text();
			//$('.min_text').text(min);
			//$('.max_text').text(max);
			var c=ui.position.left;
			var e=Math.round(parseFloat(min)+c*(max-min)/($(this).parent().width()-$(this).width()));
			$('#count_buy').text(e);
			
			$('#end-number').val(e);
			$('#number-of-items-'+tovar_id).val(e);
			$('#amount > i').html(e*price+' <small>RUB</small>');
 			//var output=Math.round(e).toFixed(0)*100/100;
 			//$('.amount').val(output);
           	//calculate(e, percent);
		 	}
		 });




	/* this is tabs_plagin*/
	



/* other function*/

function calculate(x,y)
	{
	var ret=Math.round(x*y).toFixed(0)/100;
	$('.profit > span').html(ret+'<small>$</small>');
}
	
	
function isNumberKey(event) {
	var charCode = (event.which) ? event.which : event.keyCode;
	if (charCode > 31 && (charCode < 48 || charCode > 57))
		return false;
	return true;
}






function calc() {
	var percent = $('.plans_select').val();
	switch (percent) {
		case '120':
					 min = '200';
					 max = '500';
					
				break;
		case '112':
				 min = '5';
					 max = '1000';
					
			
				break;
		case '130':
					min = '5';
					 max = '1000';
					
			
			break;
			
		case '150':
					 min = '50';
					 max = '1000';
					
			
			break;
			
		case '200':
					 min = '100';
					 max = '1000';
			
			break;
		case '300':
			 		 min = '150';
					 max = '1000';
			
			break;
			
		}
	$('.calc-min').text(min);
	$('.calc-max').text(max);
	$('.amount').val(min);
	$('#drag').animate({'left': '0px'},400);
	calculate(min, percent);
	}

	
	



	
 
});


