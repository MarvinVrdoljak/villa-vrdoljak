<?php

$args = array(
	'items_per_page'              => $query_filter['num'],
	'items_orderby'               => $query_filter['orderby'],
	'items_order'                 => $query_filter['order'],
	'items_filter'                => $query_filter['filter'],
	'items_filter_exclude'        => thb_isset( $query_filter, 'filter_exclude', '' ),
	'items_include_subcategories' => $query_filter['include_subcategories'],
	'paged'                       => 1
);

if ( isset( $_GET['filter'] ) ) {
	$args['items_filter'] = sanitize_text_field( $_GET['filter'] );
}

if ( isset( $_GET['filter_exclude'] ) ) {
	$args['items_filter_exclude'] = sanitize_text_field( $_GET['filter_exclude'] );
}

$params = array(
	'ajax_pagination'              => (int) $works_ajax_pagination,
	'carousel'                     => $carousel,
	'carousel_module'              => $carousel_module,
	'carousel_show_nav_arrows'     => $carousel_show_nav_arrows,
	'carousel_nav_arrows_position' => $carousel_nav_arrows_position,
	'carousel_show_pagination'     => $carousel_show_pagination,
	'carousel_autoplay'            => $carousel_autoplay,
	'carousel_transition_time'     => $carousel_transition_time,
);

?>

<?php if ( $title != '' || ( $carousel_show_nav_arrows && $carousel_nav_arrows_position == 'top' ) ) : ?>
	<div class="thb-section-block-header">
		<?php if ( $title != '' ) : ?>
			<h1 class="thb-section-block-title"><?php echo apply_filters( 'the_title', $title ); ?></h1>
		<?php endif; ?>

		<?php if ( $carousel_show_nav_arrows && $carousel_nav_arrows_position == 'top' ) : ?>
			<?php thb_carousel_nav_arrows(); ?>
		<?php endif; ?>
	</div>
<?php endif; ?>

<div class="thb-portfolio" <?php thb_portfolio_data_attributes( $params ); ?>>
	<?php
		if ( $carousel == '1' ) {
			add_filter( 'thb_portfolio_classes', '__return_empty_array' );
		}
		else {
			if ( apply_filters( 'thb_portfolio_block_display_filter', (bool) $disable_filter != true, $layout ) ) {
				thb_portfolio_filter( $args );
			}
		}

		thb_portfolio_loop( array(
			'args'          => $args,
			'layout'        => $layout,
			'columns'       => $grid_columns,
			'gutter'        => $grid_gutter,
			'images_height' => $grid_images_height,
			'params'        => $params
		) );

		wp_reset_query();
	?>
</div>