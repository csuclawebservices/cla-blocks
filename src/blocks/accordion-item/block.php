<?php

/**
 * Image Group Item class
 * 
 * @since 0.2.0
 */

namespace cla_blocks\includes\blocks\accordion_item;

class Accordion_Item extends \cla_blocks\includes\Block {
	public function register_block_type() {
		register_block_type($this->dir, array(
			'render_callback' => array($this, 'render_callback')
		));
	}



	public function render_block($attributes, $content, $block_instance) {
		$wrapper = '<div %s>%s</div>';
		$id = $attributes['id'];
		$classes = array($this->base_class . '-container');
		$markup = '';

		$expanded = 'false';
		$title = '';
		$titleHeadingLevel = '3';

		// Expanded
		if (isset($attributes['expanded']) && $attributes['expanded'] === true) {
			$expanded = 'true';
		}

		// Title
		if (!empty($attributes['title'])) {
			if (!empty($attributes['titleHeadingLevel'])) {
				$titleHeadingLevel = $attributes['titleHeadingLevel'];
			}

			$title = '<button class="' . $this->base_class . '__button" aria-controls="cla-blocks-accordion-item__content-' . $id . '" aria-expanded="' . $expanded . '"><h' . $titleHeadingLevel . ' id="' . $this->base_class . '__button-heading-' . $id . '" class="' . $this->base_class . '__button-heading">' . $attributes['title'] . '</h' . $titleHeadingLevel . '><span class="' . $this->base_class . '__button-status"></span></button>';
		}

		ob_start();

		?>
		<div class="<?php echo $this->base_class; ?>">
			<?php echo $title; ?>
			<div id="<?php echo $this->base_class . '__content-' . $id; ?>" class="<?php echo $this->base_class; ?>__content" aria-labelledby="<?php echo $this->base_class . '__button-heading-' . $id; ?>">
				<?php echo $content; ?>
			</div>
		</div><?php

		$markup = ob_get_clean();

		return sprintf($wrapper, get_block_wrapper_attributes(array('class' => implode(' ', $classes))), $markup);
	}
}