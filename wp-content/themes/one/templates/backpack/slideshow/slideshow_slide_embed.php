<?php
	$video_atts = array(
		'autoplay'    => $slide['autoplay'],
		'loop'        => $slide['loop'],
		'fill'        => ! $slide['fit'],
		'code'		  => thb_get_video_code( $slide['id'] )
	);

	$is_youtube = strpos($slide['id'], 'youtu') !== false;
	$is_vimeo = strpos($slide['id'], 'vimeo') !== false;

	if ( $is_youtube ) {
		$slide['id'] = 'http://www.youtube.com/watch?v=' . thb_get_video_code($slide['id']);
	}
?>

<div <?php thb_attributes( $slide_attrs ); ?> <?php thb_data_attributes( $slide_data ); ?> <?php thb_data_attributes( $video_atts ); ?>>
	<?php if ( ! $is_youtube && ! $is_vimeo ) : ?>
		<?php thb_video( $slide['id'], $video_atts ); ?>
	<?php else : ?>
		<a class="rsImg" data-rsVideo="<?php echo $slide['id']; ?>" href="<?php echo thb_get_video_thumbnail($slide['id'], 'thumbnail_large'); ?>"></a>
	<?php endif; ?>


	<?php
		if ( $slide['overlay_display'] ) {
			thb_overlay( $slide['overlay_color'], $slide['overlay_opacity'] );
		}
	?>

	<?php thb_slide_caption( $slide ); ?>

	<div class="thb-video-controls">
		<a class="thb-video-play" href="#">Play video</a>
		<a class="thb-video-stop" href="#">Stop video</a>
	</div>
</div>