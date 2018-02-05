<div class="thb-section-block-header">
	<?php if ( $title != '' ) : ?>
		<h1 class="thb-section-block-title"><?php echo apply_filters( 'the_title', $title ); ?></h1>
	<?php endif; ?>
</div>

<?php
$list_items = explode( "\n", $list );
?>

<?php if ( count( $list_items ) > 0 ) : ?>
	<ul class="thb-list">
		<?php $i=0; foreach( $list_items as $item ) : ?>
			<li class="thb-list-item">
				<?php thb_icon( $icon, $icon_color ); ?>
				<?php echo apply_filters( 'the_title', $item ); ?>
			</li>
		<?php $i++; endforeach; ?>
	</ul>
<?php endif; ?>