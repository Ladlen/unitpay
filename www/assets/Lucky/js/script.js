function parallaxIt() {
  var $fwindow = $(window);

  $('[data-type="content"]').each(function(index, e) {
    var scrollTop = $fwindow.scrollTop();
    var $contentObj = $(this);

    $fwindow.on('scroll resize', function() {
      scrollTop = $fwindow.scrollTop();

      $contentObj.css('top', ($contentObj.height() * index) - scrollTop);
    });
  });

  $('[data-type="background"]').each(function() {
    var $backgroundObj = $(this);

    $fwindow.on('scroll resize', function() {
      var yPos = -($fwindow.scrollTop() / $backgroundObj.data('speed'));
      console.log(yPos)
      var coords = '50% ' + yPos + 'px';

      // Move the background
      $backgroundObj.css({
        backgroundPosition: coords
      });
    });
  });

  $fwindow.trigger('scroll');
}

parallaxIt();



jQuery(document).ready(function() {
  $objWindow = $(window);
  $('div[data-type="background"]').each(function() {
    var $bgObj = $(this);
    $(window).scroll(function() {
      var yPos = -($objWindow.scrollTop() / $bgObj.data('speed'));
      var coords = '100% ' + yPos + 'px';
      $bgObj.css({
        backgroundPosition: coords
      });
    });
  });
  
  
	

  var menuLeft = document.getElementById('cbp-spmenu-s1'),
    	showLeft = document.getElementById('showLeft'),
			body = document.body;

	if(showLeft) {
		showLeft.onclick = function() {
    classie.toggle(this, 'active');
    classie.toggle(menuLeft, 'cbp-spmenu-open');
    disableOther('showLeft');
  };
	}

  function disableOther(button) {
    if (button !== 'showLeft') {
      classie.toggle(showLeft, 'disabled');
    }
  }
  
  
$('[data-toggle]').click(function(){
    var trg = $(this).attr('data-toggle');
    $(this).parent().children().removeClass('active');
    $(this).addClass('active');
    $(trg).parent().children().removeClass('active');
    $(trg).addClass('active');
  })
  
  
  
  $('[data-toggle]').click(function(){
    var trg = $(this).attr('data-toggle');
    $(this).parent().children().removeClass('active');
    $(this).addClass('active');
    $(trg).parent().children().removeClass('active');
    $(trg).addClass('active');
  })
  
  $(document).scroll(function(){
    if(window.scrollY < 148) {
      $('.header-nav').removeClass('fixed')
    } else {
      $('.header-nav').addClass('fixed')
    }
  })
  
  
  $(".filter__inner-wr").on("click", ".filter__param-cont", function(){
  $(this).toggleClass("active");
  });
  
  $( ".search-wr-input, .search-wr-input-mob" ).autocomplete({
    source: '/search.php?autocomplete=1',
    create: function () {
        $(this).data('ui-autocomplete')._renderItem = function (ul, item) {
            return $('<li>')
                .append(
             '<div class="search-wr__loadout js-live-search_loadout">' +
              '<a href="'+item.link+'" class="search-prod">' +
													'<div class="search-prod__img-wr">' +
														'<div class="search-prod__img" style="background-image: url(\''+item.icon+'\');">' +
														'</div>' +
													'</div>' +

													'<div class="search-prod__main">' +
														'<h4 class="search-prod__name">'+item.label+'</h4>' +

														'<p class="search-prod__genre">ЖАНР: <span>'+item.genre+'</span>' +
														'</p>' +

														'<span class="price price--ssm">'+item.price+' <span class="rub">Р</span></span>' +
													'</div>' +
												'</a>' +
              '</div>'
            )
                .appendTo(ul);
        };
    }
  });
  
			
			 $(document).ready(function() {
                n = ( $(".cons-name_comments").length );
				 var count = $('.count_com').length;
				 $( ".count_com" ).text( + n + "" );
            });
	
	
});

jQuery(function() {

});

/* ---------------------- MOBILE ------------- */

