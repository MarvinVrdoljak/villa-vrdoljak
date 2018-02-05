<?php
	$attributes = array(
		'id' => sprintf( 'thb-section-%s-row-%s-column-%s', $section_index, $row_index, $index ),
		'class' => sprintf( 'thb-section-column thb-section-column-size-%s', $column['size'] ),
	);

	$background_color = thb_isset( $column['appearance'], 'background_color', '' );
	$padding_top      = thb_isset( $column['appearance'], 'padding_top', '' );
	$padding_right    = thb_isset( $column['appearance'], 'padding_right', '' );
	$padding_bottom   = thb_isset( $column['appearance'], 'padding_bottom', '' );
	$padding_left     = thb_isset( $column['appearance'], 'padding_left', '' );

	$attributes['style'] = '';

	if ( ! empty( $background_color ) ) {
		$attributes['style'] .= sprintf( 'background-color:%s;', $background_color );
		$attributes['class'] .= ' thb-skin-' . thb_color_get_opposite_skin( $background_color );
	}

	if ( ! empty( $padding_top ) ) {
		$attributes['style'] .= sprintf( 'padding-top:%spx;', $padding_top );
	}

	if ( ! empty( $padding_right ) ) {
		$attributes['style'] .= sprintf( 'padding-right:%spx;', $padding_right );
	}

	if ( ! empty( $padding_bottom ) ) {
		$attributes['style'] .= sprintf( 'padding-bottom:%spx;', $padding_bottom );
	}

	if ( ! empty( $padding_left ) ) {
		$attributes['style'] .= sprintf( 'padding-left:%spx;', $padding_left );
	}

	$attributes['class'] .= ' ' . thb_isset( $column['appearance'], 'class', '' );

	$carousel = thb_isset( $column['appearance'], 'carousel', 0 );

	if ( $carousel == '1' ) {
		$attributes['class'] .= ' thb-carousel';

		$attributes = array_merge( thb_get_carousel_attributes( $column['appearance'] ), $attributes );
	}
?>

<div <?php thb_attributes( $attributes ); ?>>
	<div class="thb-section-column-inner-wrapper">
		<?php
			if ( isset( $column['blocks'] ) && ! empty( $column['blocks'] ) ) {
				foreach ( $column['blocks'] as $index => $block ) {
					$block_object = thb_builder_instance()->getBlock( $block['type'] );

					if ( $block_object !== false ) {
						thb_get_module_template_part( 'backpack/builder', 'block', array(
							'column_index'  => 0,
							'section_index' => $section_index,
							'row_index'     => $row_index,
							'block'         => $block,
							'index'         => $index,
						) );
					}
				}
			}
		?>
	</div>
</div>