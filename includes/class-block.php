<?php

/**
 * Block class
 * 
 * @since 0.1.0
 */

namespace cla_blocks\includes;

abstract class Block implements interfaces\Block {
	/**
	 * The block directory path.
	 *
	 * @since 0.1.0
	 * @var string $dir
	 */
	public readonly string $dir;

	/**
	 * The block name.
	 * 
	 * @since 0.1.0
	 * @var string $name
	 */
	public readonly string $name;

	/**
	 * Prefix
	 * 
	 * @since 0.1.0
	 * @var string $prefix
	 */
	public readonly string $prefix;

	/**
	 * The block slug.
	 * 
	 * @since 0.1.0
	 * @var string $slug
	 */
	public readonly string $slug;

	/**
	 * Textdomain
	 * 
	 * @since 0.1.0
	 * @var string $textdomain
	 */
	public readonly string $textdomain;

	/**
	 * The block directory uri.
	 *
	 * @since 0.1.0
	 * @var string $uri
	 */
	public readonly string $uri;

	/**
	 * The base class for the block
	 * 
	 * @since 0.1.0
	 * @var string $base_class
	 */
	public readonly string $base_class;



    /**
     * Admin constructor
     * 
     * @since 0.1.0
	 * 
     * @return void
     */
    public function __construct($args = array()) {
		$block_info = new \ReflectionClass(get_called_class());
		$block_path = $block_info->getFileName();
		$dir_path = dirname($block_path);
		$relative_path = basename($dir_path);

		$this->prefix = $args['prefix'];

		// Set paths
		$this->dir = trailingslashit($args['blocks_dir_path'] . $relative_path . '/');
		$this->uri = trailingslashit($args['blocks_dir_uri'] . $relative_path . '/');

		// Set slug
		$this->slug = $relative_path;

		// Set textdomain
		$this->textdomain = $args['textdomain'];

		// Set name
		$this->name = $this->textdomain . '/' . $this->slug;

		// Base class name (no trailing hyphen)
		$this->base_class = str_replace('_', '-', $this->prefix) . $this->slug;

		// Set Hooks
		$this->set_hooks();
    }



	/**
	 * Enqueues the blocks assets for the editor and view
	 * 
	 * @since 0.1.0
	 * 
	 * @access public
	 * 
	 * @return void
	 */
	public function enqueue_block_assets() {
		// Do nothing in this method. It should be overridden by the child if assets need to be enqueued.
	}



	/**
	 * Enqueues the blocks editor assets
	 * 
	 * @since 0.1.0
	 * 
	 * @access public
	 * 
	 * @return void
	 */
	public function enqueue_block_editor_assets() {
		// Do nothing in this method. It should be overridden by the child if assets need to be enqueued.
	}



	abstract public function register_block_type();



	/**
	 * Render the block for the front-end
	 * 
	 * This should be overridden by the block class
	 */
	public function render_block($attributes, $content, $block_instance) {
		return '';
	}



	/**
	 * Render the block for the front-end
	 * 
	 * @since 0.1.0
	 * 
	 * @access public
	 * 
	 * @param array 	$attributes	The block attributes
	 * @param string	$content	The content from the save function of the block JavaScript
	 * @param WP_Block	$block_instance	The WP_Block
	 * @return string
	 */
	public function render_callback($attributes, $content, $block_instance) {
		ob_start();

		do_action($this->prefix . 'block_render_callback_before', $this->name, $attributes, $content, $block_instance);

		echo apply_filters($this->prefix . 'block_render_callback', $this->render_block($attributes, $content, $block_instance), $this->name, $attributes, $content, $block_instance);

		do_action($this->prefix . 'block_render_callback_after', $this->name, $attributes, $content, $block_instance);

		return ob_get_clean();
	}



	protected function set_hooks() {

	}
}