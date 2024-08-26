<?php

/**
 * Image Group class
 * 
 * @since 0.1.0
 */

namespace cla_blocks\includes\blocks\image_group;

class Image_Group extends \cla_blocks\includes\Block {
	public function register_block_type() {
		register_block_type($this->dir, array(
			'render_callback' => array($this, 'render_callback')
		));
	}



	public function render_block($attributes, $content, $block_instance) {
		$wrapper = '<div %s>%s</div>';
		$classes = array($this->base_class . '-container');
		$markup = '';

		if (isset($attributes['maxColumns'])) {
			$classes[] = $this->base_class . '-max-columns-' . $attributes['maxColumns'];
		}

		ob_start();
		?>
		<div class="<?php echo $this->base_class; ?>">
			<?php echo $content; ?>
		</div><?php

		$markup = ob_get_clean();

		return sprintf($wrapper, get_block_wrapper_attributes(array('class' => implode(' ', $classes))), $markup);
	}
}