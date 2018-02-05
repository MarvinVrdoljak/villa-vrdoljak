<?php

$slides_manager = new THB_PhotogalleryBlockSlidesManager( 'photogallery_slide' );
$slides = $slides_manager->getBlockSlides( $photogallery_slide );

$caption_visible = $title != '';
?>

<?php if ( $caption_visible ) : ?>
	<div class="thb-section-block-header">
		<?php if ( $title != '' ) : ?>
			<h1 class="thb-section-block-title"><?php echo apply_filters( 'the_title', $title ); ?></h1>
		<?php endif; ?>
	</div>
<?php endif; ?>

<?php
	thb_photogallery( $grid_columns, $grid_gutter, $grid_images_height, array(
		'slides'         => $slides,
		'show_load_more' => false
	) );
?>