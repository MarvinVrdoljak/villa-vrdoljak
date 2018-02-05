<div class="thb-photogallery">
	<?php if ( count( $slides ) > 0 ) : ?>
		<ul id="<?php thb_grid_layout_id(); ?>" class="thb-photogallery-container thb-images-container <?php thb_grid_layout_class( $columns, $gutter, $height ); ?>" data-url="<?php echo thb_photogallery_ajax_dataurl(); ?>">
			<?php foreach( $slides as $slide ) : ?>
				<li class="<?php thb_grid_layout_item_class(); ?>">
					<?php
						thb_image( $slide['id'], $image_size, array(
							'link'       => true,
							'link_class' => 'item-thumb',
							'overlay'    => true,
							'link_title' => $slide['caption']
						) );
					?>
				</li>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>

	<?php if ( $show_load_more ) : ?>
		<div id="thb-infinite-scroll-nav">
			<a href="#" id="thb-infinite-scroll-button" class="thb-infinite-scroll-button"><?php _e( 'Load more', 'thb_text_domain' ); ?></a>
		</div>
	<?php endif; ?>
</div>