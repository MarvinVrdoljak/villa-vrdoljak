<?php

if ( !isset( $args ) ) {
	$args = array();
}

if ( !isset( $params ) ) {
	$params = array();
}

$classes = '';
$data_attrs = array();

if ( isset( $params['carousel'] ) && $params['carousel'] == '1' ) {
	$classes .= ' thb-carousel';
	$data_attrs = thb_get_carousel_attributes( $params );
}
else {
	$classes .= ' ' . thb_get_portfolio_classes( $columns, $gutter );
}

thb_portfolio_query( $args );

?>

<?php if( have_posts() ) : ?>

	<ul class="<?php echo $classes; ?>" <?php thb_attributes( $data_attrs ); ?>>
		<?php while( have_posts() ) : ?>
			<?php the_post(); ?>

			<?php
				thb_portfolio_item( array(
					'portfolio_item_template' => $portfolio_item_template
				) );
			?>
		<?php endwhile; ?>
	</ul>

<?php endif; ?>
<?php wp_reset_query(); ?>