<?php
	$caption_visible = $title != '' || $content != '';
	
	$video_atts = array(
		'autoplay'    => $autoplay,
		'loop'        => $loop
	);
?>

<?php if ( $caption_visible ) : ?>
	<div class="thb-section-block-header">
		<?php if ( $title != '' ) : ?>
			<h1 class="thb-section-block-title"><?php echo apply_filters( 'the_title', $title ); ?></h1>
		<?php endif; ?>
	</div>

	<?php if ( $content != '' ) : ?>
		<div class="thb-text">
			<?php echo apply_filters( 'the_content', $content ); ?>
		</div>
	<?php endif; ?>
<?php endif; ?>

<div class="thb-section-block-thb_video-video-holder <?php if ( $caption_visible ) : ?>w-text<?php endif; ?>">
	<?php thb_video( $id, $video_atts ); ?>
</div>