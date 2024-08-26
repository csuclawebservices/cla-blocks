<?php

/**
 * Image Group Item class
 * 
 * @since 0.1.0
 */

namespace cla_blocks\includes\blocks\image_group_item;

class Image_Group_Item extends \cla_blocks\includes\Block {
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

		ob_start();

		?>
		<div class="<?php echo $this->base_class; ?>">
		<?php echo $image; ?>
			<div class="<?php echo $this->base_class; ?>__content">
				<?php echo $content; ?>
			</div>
		</div><?php

		$markup = ob_get_clean();

		return sprintf($wrapper, get_block_wrapper_attributes(array('class' => implode(' ', $classes))), $markup);
	}



	protected function set_hooks() {
		add_filter('render_block_' . $this->name, array($this, 'wp_hook_render_block'), 10, 3);
	}



	public function wp_hook_render_block($block_content, $block, $instance) {
		$p = new \cla_blocks\includes\HTML_Processor($block_content);

		// Select the container div
		$p->next_tag('div');

		// Get the container aspect-ratio style property value
		$aspect_ratio = $p->get_style_property('aspect-ratio');

		// Remove the aspect-ratio style property from the container div
		$p->remove_style_property('aspect-ratio');

		// Select the image element
		$p->next_tag(array('class_name' => 'cla-blocks-image-group-item__media'));

		// Add the aspect-ratio style property to the image element
		if (!empty($aspect_ratio)) {
			$p->set_style_property('aspect-ratio', $aspect_ratio);
		}

		// Get the updated html
		$block_content = $p->get_updated_html();

		return $block_content;
	}
}