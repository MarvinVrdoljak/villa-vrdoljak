<?php
	$slides = thb_get_showcase_item_slides();
	$container_attrs = array();
	$container_attrs['thb-slideshow'] = '';
	$container_attrs = array_merge( $container_attrs, $data );

	$show_block = count( $slides ) > 0;
?>

<?php if ( $show_block ) : ?>
	<div class="thb-slideshow <?php echo $classes; ?>" <?php thb_data_attributes( $container_attrs ); ?>>
		<?php $i=0; foreach( $slides as $slide ) : ?>
			<?php
				$slide_content_data = array(
					'index' => $i,
					'slide' => $slide,
					'images_size' => $images_size,
					'slide_attrs' => array(
						'class' => 'slide slide-type-' . $slide['type'] . ' ' . $slide['class']
					),
					'slide_data' => array(),
					'mode' => $mode
				);

				$slide_content_data = apply_filters( 'thb_slide_content_data', $slide_content_data );

				thb_slide_content( $slide['type'], $slide_content_data );
			?>
		<?php $i++; endforeach; ?>
	</div>
<?php endif; ?>