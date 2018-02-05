/**
 * Number counters
 * -----------------------------------------------------------------------------
 */
 (function($) {

	$( ".thb-counter-wrapper" ).each( function() {
		var el = $(this),
			counter = $(this).find( ".thb-counter" );

		el.data( "thb-counter", new Odometer({
			el: counter.get(0),
			value: 0,
			format: ''
		}) );
	} );

 })(jQuery);

/**
 * Radial pie charts
 * -----------------------------------------------------------------------------
 */
(function($) {

	$('.thb-radial-chart-data').each( function() {
		var el = $(this),
			opts = {
				scaleLength: false,
				lineWidth: el.data( 'width' ),
				lineCap: el.data( 'cap' ),
				size: el.data( 'size' ),
				barColor: el.data( 'color' ),
				trackColor: el.data( 'track' ),
				animate: {
					duration: 2500,
					enabled: false
				},
				onStep: function( from, to, percent ) {
					el.parent().find( ".thb-radial-chart-step-value" ).html( Math.round( percent ) );
				}
			};

		el.easyPieChart(opts);
	});

})(jQuery);

/**
 * Toggle
 * -----------------------------------------------------------------------------
 */
(function($) {

	$.fn.thb_toggle = function( parameters ) {
		var parameters = jQuery.extend({
			speed: 350,
			easing: 'swing',
			trigger: '.thb-toggle-trigger',
			content: '.thb-toggle-content',
			openClass: 'open',
			before: function() {},
			after: function() {}
		}, parameters);

		return this.each(function() {
			var container = $(this),
				trigger = container.find(parameters.trigger),
				content = container.find(parameters.content);

			/**
			 * Toggle data
			 */
			this.toggle_speed = parameters.speed,
			this.toggle_easing = parameters.easing;
			container.toggle_open = container.hasClass(parameters.openClass);

			/**
			 * Open the toggle
			 */
			container.bind('thb_toggle.open', function() {
				container.addClass(parameters.openClass);
				content.slideDown(this.toggle_speed, this.toggle_easing);
				container.toggle_open = true;
			});

			/**
			 * Close the toggle
			 */
			container.bind('thb_toggle.close', function() {
				container.removeClass(parameters.openClass);
				content.slideUp(this.toggle_speed, this.toggle_easing);
				container.toggle_open = false;
			});

			/**
			 * Before
			 */
			container.bind('thb_toggle.before', parameters.before);

			/**
			 * After
			 */
			container.bind('thb_toggle.after', parameters.after);

			/**
			 * Events
			 */
			trigger.click(function() {
				container.trigger('thb_toggle.before');
				container.trigger( container.toggle_open ? 'thb_toggle.close' : 'thb_toggle.open' );
				container.trigger('thb_toggle.after');

				return false;
			});

			/**
			 * Init
			 */
			if( container.toggle_open ) {
				content.show();
			}
		});
	}

	$(document).ready(function() {
		$('.thb-toggle').thb_toggle();
	});

})(jQuery);

/**
 * Accordion
 * -----------------------------------------------------------------------------
 */
(function($) {

	$.fn.thb_accordion = function( parameters ) {
		var parameters = jQuery.extend({
			toggle: '.thb-toggle',
			speed: 350,
			easing: 'swing'
		}, parameters);

		return this.each(function( i, el ) {
			var container = $(this),
				items = container.find(parameters.toggle);

			items.each(function() {
				$(this).bind('thb_toggle.before', function() {
					this.toggle_speed = parameters.speed;
					this.toggle_easing = parameters.easing;

					items.not( $(this) ).each(function() {
						$(this).trigger('thb_toggle.close');
					});
				});
			});
		});
	}

	$(document).ready(function() {
		$('.thb-section-column-block-thb_accordion').thb_accordion();
	});

})(jQuery);

/**
 * Tabs
 * -----------------------------------------------------------------------------
 */
(function($) {

	$.fn.thb_tabs = function( parameters ) {
		var parameters = jQuery.extend({
			nav: '.thb-tabs-nav',
			tabContents: '.thb-tabs-contents',
			contents: '.thb-tab-content',
			openClass: 'open',
			speed: 350,
			easing: 'swing'
		}, parameters);

		return this.each(function() {
			var container = $(this),
				nav = container.find(parameters.nav),
				triggers = nav.find('a'),
				tabContents = container.find(parameters.tabContents),
				contents = container.find(parameters.contents);

			container.bind('thb_tabs.goto', function(e, i) {
				triggers.parent().removeClass(parameters.openClass);
				triggers
					.eq(i)
					.parent()
					.addClass(parameters.openClass);

				contents
					.hide()
					.eq(i)
						.show();
			});

			triggers.each(function(i, el) {
				$(this).click(function() {
					container.trigger('thb_tabs.goto', [i]);
					return false;
				});
			});

			/**
			 * Init
			 */
			var idx = 0;
			container.trigger('thb_tabs.goto', [idx]);

			tabContents.css('min-height', nav.height());
		});
	};

	$( document ).ready( function() {
		window.thb_builder_calls.push( function( root ) {
			$( '.thb-section-column-block-thb_tabs', root ).thb_tabs();
		} );
	} );

})(jQuery);