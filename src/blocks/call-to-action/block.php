<?php

/**
 * Call to Action class
 * 
 * @since 0.1.0
 */

namespace cla_blocks\includes\blocks\call_to_action;

class Call_to_Action extends \cla_blocks\includes\Block {
	public function register_block_type() {
		register_block_type($this->dir, array(
			'render_callback' => array($this, 'render_callback')
		));
	}



	public function render_block($attributes, $content, $block_instance) {
		$wrapper = '<div %s>%s</div>';
		$classes = array($this->base_class . '-container');
		$markup = '';

		$image = '';
		$link = '';
		$label = '';

		// Media
		if (!empty($attributes['mediaId'])) {
			$classes[] = 'has-image';

			$image_attributes = wp_get_attachment_image_src($attributes['mediaId'], 'large');

			if ($image_attributes) {
				$image = '<figure class="' . $this->base_class . '__media-container"><img class="' . $this->base_class . '__media" src="' . $image_attributes[0] . '" /></figure>';
			}
		} else {
			$classes[] = 'no-image';
		}

		// Link
		if (!empty($attributes['urlLabel'])) {
			$label = $attributes['urlLabel'];
		}

		if (!empty($attributes['url'])) {
			$classes[] = 'has-link';

			$link = '<div class="wp-block-button ' . $this->base_class . '__link"><a href="' . esc_url($attributes['url']) . '" class="wp-block-button__link">' . $label . '</a></div>';
		} else {
			$classes[] = 'no-link';
		}

		ob_start();

		?>
		<div class="<?php echo $this->base_class; ?>">
			<?php echo $image; ?>
			<div class="<?php echo $this->base_class; ?>__content">
				<?php echo $content; ?>
				<?php echo $link; ?>
			</div>
		</div><?php

		$markup = ob_get_clean();

		return sprintf($wrapper, get_block_wrapper_attributes(array('class' => implode(' ', $classes))), $markup);
	}
}