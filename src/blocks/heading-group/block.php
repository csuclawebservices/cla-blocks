<?php

/**
 * Heading Group class
 * 
 * @since 0.1.0
 */

namespace cla_blocks\includes\blocks\heading_group;

class Heading_Group extends \cla_blocks\includes\Block {
	public function register_block_type() {
		register_block_type($this->dir, array(
			'render_callback' => array($this, 'render_callback')
		));
	}



	public function render_block($attributes, $content, $block_instance) {
		$wrapper = '<div %s>%s</div>';
		$classes = array($this->base_class . '-container');
		$markup = '';

		$attributes = wp_parse_args($attributes, array(
			'level' => 2,
			'orientation' => 'horizontal'
		));

		$heading_tag = 'h' . $attributes['level'];
		$block_gap = '';

		if (isset($attributes['style']['spacing']['blockGap'])) {
			$block_gap = 'gap:' . $this->convert_custom_properties($attributes['style']['spacing']['blockGap']) . ';';
		}

		$classes[] = $this->base_class . '-container--orientation-' . $attributes['orientation'];

		ob_start();

		?>
		<<?php echo $heading_tag; ?> class="<?php echo $this->base_class; ?>" style="<?php echo $block_gap; ?>">
			<?php echo $content; ?>
		</<?php echo $heading_tag; ?>><?php

		$markup = ob_get_clean();

		return sprintf($wrapper, get_block_wrapper_attributes(array('class' => implode(' ', $classes))), $markup);
	}



	protected function set_hooks() {
		add_filter('render_block_cla-blocks/heading-group', array($this, 'wp_hook_render_block'), 10, 3);
	}



	public function wp_hook_render_block($block_content, $block, $instance): string {
		if (!empty($block_content)) {
			$block_content = str_replace(array('<p ', '</p>'), array('<span ', '</span>'), $block_content);
		}

		return $block_content;
	}
}