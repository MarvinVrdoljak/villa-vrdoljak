<?php
	$subtitle = thb_get_portfolio_item_subtitle();
?>
<li id="post-<?php the_ID(); ?>" <?php thb_portfolio_post_class(); ?> <?php thb_portfolio_item_datafilters(); ?>>
	<a href="<?php echo thb_portfolio_item_permalink(); ?>" rel="bookmark" class="work-thumb">
		<?php if( ($fi = thb_get_featured_image( 'full' )) != '' ) : ?>
			<img src="<?php echo $fi; ?>" alt="">
		<?php endif; ?>

		<div class="thb-work-overlay">
			<div class="overlay-wrapper">
				<div class="work-data">
					<h3><?php the_title(); ?></h3>
					<?php if( $subtitle != "" ) : ?>
						<p><?php echo $subtitle; ?></p>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</a>
</li>