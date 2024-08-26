<?php

/**
 * Sample class
 * 
 * @since 0.1.0
 */

namespace cla_blocks\includes\blocks\sample;

class Sample extends \cla_blocks\includes\Block {
	public function register_block_type() {
		register_block_type($this->dir, array(
			'render_callback' => array($this, 'render_callback')
		));
	}



	public function render_block($attributes, $content, $block_instance) {
		ob_start();

		?><div>
			<h2>Multi Inner Blocks</h2>
			<div class="first-section">
				<h3>First Section</h3>
				<?php echo apply_filters('the_content', $content); ?>
			</div>
			<div class="second-section">
				<h3>Second Section</h3>
				<?php echo apply_filters('the_content', $content); ?>
			</div>
		</div><?php

		return ob_get_clean();
	}
}