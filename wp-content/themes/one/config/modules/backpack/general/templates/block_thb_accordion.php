<?php if( have_posts() ) : while( have_posts() ) : the_post(); ?>

	<?php $i=0; foreach( $accordion_items as $item ) : ?>
		<div class="thb-toggle">
			<h1 class="thb-toggle-trigger">
				<?php thb_icon( $item['icon'], $item['color'] ); ?>
				<?php echo apply_filters( 'the_title', $item['title'] ); ?>
			</h1>

			<div class="thb-toggle-content">
				<?php echo apply_filters( 'the_content', $item['content']); ?>
			</div>
		</div>
	<?php $i++; endforeach; ?>

<?php endwhile; endif; ?>

<?php wp_reset_query(); ?>