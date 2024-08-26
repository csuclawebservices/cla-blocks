<?php

/**
 * Sequence Item class
 * 
 * @since 0.1.0
 */

namespace cla_blocks\includes\blocks\sequence_item;

class Sequence_Item extends \cla_blocks\includes\Block {
	public function register_block_type() {
		register_block_type($this->dir, array(
			'render_callback' => array($this, 'render_callback')
		));
	}



	public function render_block($attributes, $content, $block_instance) {
		$wrapper = '<div %s>%s</div>';
		$classes = array($this->base_class . '-container');
		$markup = '';

		$title = '';
		$titleHeadingLevel = '2';

		// Title
		if (!empty($attributes['title'])) {
			$classes[] = 'has-title';

			if (!empty($attributes['titleHeadingLevel'])) {
				$titleHeadingLevel = $attributes['titleHeadingLevel'];
			}

			$title = '<h' . $titleHeadingLevel . ' class="' . $this->base_class . '__title">' . $attributes['title'] . '</h' . $titleHeadingLevel . '>';
		} else {
			$classes[] = 'no-title';
		}

		ob_start();

		?>
		<div class="<?php echo $this->base_class; ?>">
			<?php echo $title; ?>
			<div class="<?php echo $this->base_class; ?>__content">
				<?php echo $content; ?>
			</div>
		</div><?php

		$markup = ob_get_clean();

		return sprintf($wrapper, get_block_wrapper_attributes(array('class' => implode(' ', $classes))), $markup);
	}
}