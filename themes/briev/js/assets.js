(function($){
	Briev = {
		init: function(){
			$(document)
			.on('click', '.menu-toggle', this.toggleMenu)
			.on('click', '.sidebar-overlay', function(){
				$('.menu-toggle').trigger('click');
			});

			$(window).on('resize', function(){
				var t = $(this), s = $('.sidebar');

				if ( t.width() > 768 )
					s.css('width', '250px').children().show();
			});
		},

		toggleMenu: function(e){
			e.preventDefault();

			var t = $(this), s = $('.sidebar'), o = $('.sidebar-overlay'), b = $('body, .global');

			t.toggleClass('open');
			if ( t.hasClass('open') ){
				b.addClass('no-overflow');
				o.show();
				s.animate({
					width:'250px'
				}, 200, function(){
					s.children('.sidebar-top').css('display','flex');
					s.children('.sidebar-top, .menu-content').fadeIn(300);
				});
			} else {
				b.removeClass('no-overflow');
				s.children('.sidebar-top, .menu-content').fadeOut(300, function(){
					s.animate({width:0}, 200);
					o.hide();
				});
			}
		}
	}
	Briev.init();
})(jQuery);