<?php
	$thb_fi = $args['thb_fi'];
?>

<?php if ( thb_is_portfolio_likes_active() && $thb_fi != '' ) : ?>
	<?php thb_like(); ?>
<?php endif; ?>

<?php if( $thb_fi != '' ) : ?>
	<a href="<?php echo thb_portfolio_item_get_permalink(); ?>" rel="bookmark" class="work-thumb">
		<img src="<?php echo $thb_fi; ?>" alt="">

		<?php thb_get_template_part( 'templates/thb-portfolio/portfolio-item-data', $args ); ?>
	</a>
<?php endif; ?>

<?php if ( $thb_fi == '' ) : ?>
	<?php thb_get_template_part( 'templates/thb-portfolio/portfolio-item-data-a', $args ); ?>
<?php endif; ?>