( function( $ ) {
	window.thb_photogallery_adjust = function( photogallery_container, old_height, target_photogallery, new_data_url ) {
		var scroll = photogallery_container.outerHeight() - old_height;

		$.scrollTo( "+=" + scroll + "px", 400, {
			"easing": "easeInOutQuint",
			"onAfter": function() {
				if( ! target_photogallery.find("#thb-infinite-scroll-nav").length ) {
					$("#thb-infinite-scroll-nav").remove();
				}
				else {
					photogallery_container.attr("data-url", new_data_url);
				}
			}
		} );
	};

	$( document ).on( "ready", function() {
		var photogalleries = $( ".thb-photogallery" );

		photogalleries.each( function( index ) {
			var	photogallery = $( this ),
				photogallery_container = photogallery.find( ".thb-photogallery-container" ),
				hasIsotope = typeof THB_Isotope !== 'undefined',
				button = photogallery.find( ".thb-infinite-scroll-button" ),
				photogallery_grid_container = photogallery_container;

			if ( photogallery_container.attr( 'class' ).indexOf( 'thb-grid-images-height-' ) > -1 ) {
				if ( photogallery_container.hasClass( 'thb-grid-images-height-fixed' ) ) {
					hasIsotope = false;
				}
			}

			if ( hasIsotope ) {
				photogallery_grid_container = new THB_Isotope( photogallery_container );
			}

			if ( button.length ) {
				button.on( "click", function() {
					$.thb.loadUrl(photogallery_container.attr("data-url"), {
						complete: function( data ) {
							var target_photogallery = $(data).find( ".thb-photogallery" ).eq( index );

							var items = target_photogallery.find(".thb-photogallery-container .item"),
								new_data_url = target_photogallery.find(".thb-photogallery-container").data("url"),
								old_height = photogallery_container.outerHeight();

							if ( hasIsotope ) {
								photogallery_grid_container.insert( items, function() {
									window.thb_photogallery_adjust( photogallery_container, old_height, target_photogallery, new_data_url );
								} );
							}
							else {
								photogallery_grid_container.append( items );
								window.thb_photogallery_adjust( photogallery_container, old_height, target_photogallery, new_data_url );
							}

							if ( window.thb_lightbox_handler ) {
								window.thb_lightbox_handler.init();
							}
						}
					});

					return false;
				} );
			}
		} );
	} );
} )( jQuery );