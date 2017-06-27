(function($){
	$('#i_am_typed').typed({
		strings:[
			'a web programmer.',
			'a web designer.',
			'a graphic designer.',
			'an entrepreneur.',
			'a coffee lover.',
			'a freelancer.',
			'a fancy blogger.'
		],
		startDelay:3,
		loop:true,
		backDelay:2000,
		shuffle:true
	});

	window.invoke = function(e,o){
		o = (typeof o === 'undefined') ? true : false;
		e = (typeof e === 'undefined' || !e || e == '') ? '[data-invoke]' : '[data-invoke~='+e+']';
		return o ? $(e) : e;
	}

	window.isBlocked = function(o){
		return $.inArray(o,Galactic.blocked) !== -1;
	}

	window.getAction = function(){
		return window.location.pathname;
	}

	$.fn.block = function(o){
		var t = $(this);
		t.find('input, button, textarea').each(function(e,v){
			$(v).prop('disabled', true);
		});

		t.find('.g-recaptcha').css('opacity', .5);
		Galactic.blocked.push(o);
	}

	$.fn.unblock = function(o){
		var t = $(this);
		t.find('input, button, textarea').each(function(e,v){
			$(v).prop('disabled', false);
		});

		t.find('.g-recaptcha').css('opacity', 1);
		Galactic.blocked.splice($.inArray(o,Galactic.blocked), 1);
	}

	$.fn.resetForm = function(){
		var t = $(this);
		t.find('input textarea').val('');
	}

	Galactic = {
		blocked:[],
		init: function(){
			var w = $(window), d = $(document);

			d.on( 'submit', invoke('contact', false), this.sendEnquiry )
			.on( 'click', invoke('modal', false), this.modal )
			.on( 'click', invoke('scroll', false), this.scrollTo )
			.on( 'click', '[data-href]', this.navTo )
			.on( 'click', '.menu-toggle', this.toggleMenu )
			.on( 'click', '.nav ul a', function(e){
				e.preventDefault();

				var t = $(this), x = t.attr('href');
				if ( x === '' ) return false;

				$.scrollTo(x,500);
				return true;
			});

			w.on( 'scroll load', this.changeNavigation )
			.on( 'scroll', animatedScroll )
			.on( 'resize', function(){
				var t = $(this), m = $('.nav ul');
				if ( t.width() > 768 ){
					m.show();
					if (m.hasClass('open')){
						m.removeClass('open');
					}
				}
			})
			.on( 'load', function(){
				var t = $(this), h = t.height();
				// t.scrollTop(1);
				// t.scrollTop(0);

				$('.animated-onscroll').removeClass('animated').css('opacity', 0);

				window.masonry = $('.masonry').masonry({
					itemSelector: '.grid-item'
				});

				$('.single-blog .the-content a').not('.blog-navigation a').each(function(i,t){
					t = $(t);
					t.prop( 'target', '_blank' );
				});

				if ( $('#particles-js').length > 0 ){
					particlesJS.load( 'particles-js', 'media/t/particles-js.json' );
					$('#particles-js').hide().fadeIn(2000);
				}
			});

			var win_height_padded = w.height() * 1.1;

			function animatedScroll() {
				var scrolled = w.scrollTop(), win_height_padded = w.height() * 1.1;

				// Showed...
				$(".animated-onscroll:not(.animated)").each(function(){
					var $this = $(this), offset = $this.offset().top, a = $this.data('animation'), delay = $this.data('delay'),
						s = scrolled+win_height_padded, o = offset+100;

					if ( (typeof a !== 'undefined' && a !== '') && (s>o) ){
						if ( delay ){
							window.setTimeout(function(){
								$this.addClass('animated ' + a).css('opacity',1);
							}, parseInt(delay,10));
						} else {
							$this.addClass('animated ' + a).css('opacity',1);
						}
					}
				});

				// Hidden...
				$(".animated-onscroll.animated").each(function (index) {
					var $this = $(this), offset = $this.offset().top;
					if (scrolled + win_height_padded < offset) {
						$(this).removeClass('animated fadeInUp flipInX lightSpeedIn');
					}
				});
			}

			animatedScroll();
		},

		toggleMenu: function(e){
			if ( typeof e === 'object' )
				e.preventDefault();

			var t = $(this), m = $('.nav ul'), c = m.find('li'), open = false;
			t.toggleClass('open');

			if ( t.hasClass('open') ) open = true;

			if ( open ){
				m.css('display', 'flex').addClass('open');
			} else {
				m.css('display', 'none').removeClass('open');
			}

			m.on('click', 'a', function(){
				t.removeClass('open');

				if ( m.hasClass('open') )
					m.css('display', 'none');
			});
		},

		notify: function(m,c){
			var p = $('.noty-container'), h;

			if ( typeof c !== 'undefined' )
				c = ' ' + c;

			h = $('<div/>', {class:'noty animated jello'+c}).html(m);
			p.append(h);
			p.find(h).hide().fadeIn(200);

			function dismiss(){
				h.addClass('animated bounceOutRight').fadeOut(500, function(){
					h.remove();
				});
			}

			h.on('click', function(){
				dismiss();
			});

			setTimeout(function(){
				dismiss();
			}, 8000);
		},

		highlightRequired: function(r){
			if ( typeof r !== 'object' || r.length < 1 )
				return false;

			$.each(r, function(k,v){
				if ( k === '' ) return;

				var m = v || 'Please fill in this input.', t = $('[name='+k+']');

				if ( k == 'g-recaptcha-response' ){
					Galactic.notify(m, 'red');
				} else {
					t.addClass('error');
					if ( t.next('label.error').length < 1 )
						t.after( $('<label/>', {class:'error'}).text(m) );

					t.on('input change', function(){
						if ( t.val() !== '' ){
							t.removeClass('error');
							t.next('label').hide();
						} else {
							t.addClass('error');
							t.next('label').show();
						}
					});
				}
			});
		},

		sendAlert: function(o){
			if ( typeof o.message === 'undefined' || typeof o.message !== 'undefined' && o.message === '' )
				return false;

			var m = o.message, c = o.color || 'green';
			Galactic.notify(m,c);
			return true;
		},

		sendEnquiry: function(e){
			e.preventDefault();

			var t = $(this), v = t.serialize();
			if ( isBlocked('contact_form') )
				return false;

			t.block('contact_form');
			$.post(getAction() + '?action=send_enquiry', v, function(o){
				console.log(o);
				Galactic.sendAlert(o);

				if ( typeof o.required !== 'undefined' ){
					Galactic.highlightRequired(o.required);
				}

				t.unblock('contact_form');
				if ( o.status === true ){
					t.trigger('reset');
					grecaptcha.reset();
					return true;
				}
			}, 'JSON', true)
			.fail(function(e){ console.error(e.responseText) });
		},

		navTo: function(e){
			e.preventDefault();
			var t = $(this), h = t.data('href');
			window.location.href = h;
		},

		scrollTo: function(e){
			if ( typeof e === 'object' )
				e.preventDefault();

			var t = $(this), x = $(t.data('target'));
			$.scrollTo(x,500);
		},

		modal: function(e){
			e.preventDefault();
			var t = $(this), b = $('body'), x = $(t.data('target')), c = x.find('.close-btn'), w = $(window), y = w.scrollTop(),
				ov = $('<div/>', {class:'dismiss'}).css({position:'absolute',top:0,left:0,right:0,bottom:0});

			w.scrollTop(0);
			b.addClass('modal-open');
			x.css('display', 'flex');
			x.prepend(ov);

			c.add('.popup > .dismiss').on('click', function(e){
				e.preventDefault();
				b.removeClass('modal-open');
				x.hide();
				w.scrollTop(y);
			});
		},

		changeNavigation: function(e){
			var t = $(this), h = t.scrollTop(), n = $('.nav'), nh = $('.nav').height(), anim = 'animated fast fadeIn';
			// n.scrollspy();

			h > (nh/2)
			? n.removeClass(anim).addClass('sticky ' + anim)
			: n.removeClass('sticky ' + anim).addClass(anim);
		}
	}

	Galactic.init();
})(jQuery);