<?php

/**
 * CLA Blocks
 * 
 * @since 0.1.0
 */

namespace cla_blocks\includes;

class CLA_Blocks {
	protected static $instance = null;

	protected $blocks = array();
	protected $install = null;
	protected $update = null;

	public readonly string $dir;
	public readonly string $min_php_version;
	public readonly string $min_wp_version;
	public readonly string $prefix;
	public readonly string $textdomain;
	public readonly string $uri;
	public readonly string $version;

	/**
	 * CLA_Blocks constructor
	 * 
	 * @since 0.1.0
	 */
	protected function __construct() {
		// Initialize properties
		$this->dir = plugin_dir_path(__DIR__);
		$this->min_php_version = '8.1';
		$this->min_wp_version = '6.6';
		$this->prefix = 'cla_blocks_';
		$this->textdomain = 'cla-blocks';
		$this->uri = plugins_url('/', __DIR__);
		$this->version = '0.0.0cla-blocks';

		// Load files
		$this->load();

		// Setup app
		$this->setup();

		// Set hooks
		$this->set_hooks();

		// Uninstall plugin
		if (defined('WP_UNINSTALL_PLUGIN')) {
			$this->uninstall();
		}
	}



	/**
	 * Enqueues scripts and styles in the Editor iframe and the front-end
	 * 
	 * @since 0.1.0
	 * 
	 * @return void
	 */
	protected function enqueue_block_assets() {
		wp_enqueue_style('cla-blocks');
    }



	/**
	 * Enqueues scripts and styles in the editor (not in the iframe)
	 * 
	 * @since 0.0.1
	 * 
	 * @return void
	 */
	protected function enqueue_block_editor_assets() {
		wp_enqueue_style('cla-blocks-editor-css', $this->uri . 'assets/css/editor.css');
	}



	/**
	 * Enqueues scripts and styles on the front-end
	 * 
	 * @since 0.1.0
	 * 
	 * @return void
	 */
	protected function enqueue_scripts_styles() {
		
	}



	/**
	 * Get a singleton instance
	 * 
	 * @since 0.1.0
	 * 
	 * @return CLA_Blocks
	 */

	public static function get_instance(): CLA_Blocks {
		if (is_null(static::$instance)) {
			static::$instance = new static();
		}

		return static::$instance;
	}



	/**
	 * Load all necessary files for the plugin to operate
	 * 
	 * @since 0.1.0
	 * 
	 * @access protected
	 * 
	 * @return void
	 */
	protected function load(): void {
		require_once $this->dir . 'includes/class-install.php';
		require_once $this->dir . 'includes/class-update.php';
		require_once $this->dir . 'includes/class-html-processor.php';
	}



	/**
	 * Load blocks
	 * 
	 * @since 0.1.0
	 * 
	 * @access protected
	 * 
	 * @return void
	 */
	protected function load_blocks(): void {
		if (!function_exists('register_block_type')) return;

		$blocks_dir_path = $this->dir . 'includes/blocks/';
		$blocks_dir_uri = $this->uri . 'includes/blocks/';

		// Load interface and base class
		require_once $this->dir . 'includes/interfaces/interface-block.php';
		require_once $this->dir . 'includes/class-block.php';

		// Load blocks
		require_once $this->dir . 'includes/blocks/accordion/block.php';
		require_once $this->dir . 'includes/blocks/accordion-item/block.php';
		require_once $this->dir . 'includes/blocks/call-to-action/block.php';
		require_once $this->dir . 'includes/blocks/heading-group/block.php';
		require_once $this->dir . 'includes/blocks/image-group/block.php';
		require_once $this->dir . 'includes/blocks/image-group-item/block.php';
		require_once $this->dir . 'includes/blocks/sequence/block.php';
		require_once $this->dir . 'includes/blocks/sequence-item/block.php';

		// Instantiate blocks
		$this->blocks['cla-blocks/accordion'] = new blocks\accordion\Accordion(array('blocks_dir_path' => $blocks_dir_path, 'blocks_dir_uri' => $blocks_dir_uri, 'prefix' => $this->prefix, 'textdomain' => $this->textdomain));
		$this->blocks['cla-blocks/accordion-item'] = new blocks\accordion_item\Accordion_Item(array('blocks_dir_path' => $blocks_dir_path, 'blocks_dir_uri' => $blocks_dir_uri, 'prefix' => $this->prefix, 'textdomain' => $this->textdomain));
		$this->blocks['cla-blocks/call-to-action'] = new blocks\call_to_action\Call_to_Action(array('blocks_dir_path' => $blocks_dir_path, 'blocks_dir_uri' => $blocks_dir_uri, 'prefix' => $this->prefix, 'textdomain' => $this->textdomain));
		$this->blocks['cla-blocks/heading-group'] = new blocks\heading_group\Heading_Group(array('blocks_dir_path' => $blocks_dir_path, 'blocks_dir_uri' => $blocks_dir_uri, 'prefix' => $this->prefix, 'textdomain' => $this->textdomain));
		$this->blocks['cla-blocks/image-group'] = new blocks\image_group\Image_Group(array('blocks_dir_path' => $blocks_dir_path, 'blocks_dir_uri' => $blocks_dir_uri, 'prefix' => $this->prefix, 'textdomain' => $this->textdomain));
		$this->blocks['cla-blocks/image-group-item'] = new blocks\image_group_item\Image_Group_Item(array('blocks_dir_path' => $blocks_dir_path, 'blocks_dir_uri' => $blocks_dir_uri, 'prefix' => $this->prefix, 'textdomain' => $this->textdomain));
		$this->blocks['cla-blocks/sequence'] = new blocks\sequence\Sequence(array('blocks_dir_path' => $blocks_dir_path, 'blocks_dir_uri' => $blocks_dir_uri, 'prefix' => $this->prefix, 'textdomain' => $this->textdomain));
		$this->blocks['cla-blocks/sequence-item'] = new blocks\sequence_item\Sequence_Item(array('blocks_dir_path' => $blocks_dir_path, 'blocks_dir_uri' => $blocks_dir_uri, 'prefix' => $this->prefix, 'textdomain' => $this->textdomain));

		foreach ($this->blocks as $block) {
			$block->register_block_type();
		}
	}



	/**
	 * Register scripts and styles
	 * 
	 * @since 0.1.0
	 * 
	 * @access protected
	 * 
	 * @return void
	 */
	protected function register_scripts_styles() {
		// Styles
		wp_register_style('cla-blocks', $this->uri . 'assets/css/style.css', array(), $this->version);

		// Scripts
		wp_register_script('cla-blocks-accordion', $this->uri . 'assets/js/cla-blocks-accordion.js', array(), $this->version, array());
	}



	/**
	 * Set necessary hooks for this class
	 * 
	 * @since 0.1.0
	 * 
	 * @access protected
	 * 
	 * @return void
	 */
	protected function set_hooks(): void {
		// WP Init
		add_action('init', array($this, 'wp_hook_init'));

		// Block Categories
		add_filter('block_categories_all', array($this, 'wp_hook_block_categories_all'), 10, 2);

		// Block Type Metadata Settings
		add_filter('block_type_metadata_settings', array($this, 'wp_hook_block_type_metadata_settings'), 10, 2);

		// Block Assets (front-end and back-end)
		add_action('enqueue_block_assets', array($this, 'wp_hook_enqueue_block_assets'));

		// Block Editor Assets (back-end)
		add_action('enqueue_block_editor_assets', array($this, 'wp_hook_enqueue_block_editor_assets'));

		// Enqueue Scripts and Styles (front-end)
		add_action('wp_enqueue_scripts', array($this, 'wp_hook_wp_enqueue_scripts'));
	}



	/**
	 * Initialize classes
	 * 
	 * @since 0.1.0
	 * 
	 * @access protected
	 * 
	 * @return void
	 */
	protected function setup(): void {
		// Install the plugin
		$this->install = new Install(array(
			'min_php_version'	=> $this->min_php_version,
			'min_wp_version'	=> $this->min_wp_version,
			'plugin_dir'		=> $this->dir,
			'plugin_file'		=> 'cla-blocks.php',
			'plugin_version'	=> $this->version,
			'prefix'			=> $this->prefix
		));

		// Update the plugin
		new Update(array(
			'plugin_version'	=> $this->version,
			'prefix'			=> $this->prefix
		));
	}



	/**
	 * Initiate the Uninstall process for the plugin
	 * 
	 * @since 0.1.0
	 * 
	 * @access protected
	 * 
	 * @return void
	 */
	protected function uninstall(): void {
		require_once $this->dir . 'includes/class-uninstall.php';

		new Uninstall(array(
			'prefix'	=> $this->prefix
		));
	}



	/**
	 * Filters the block categories to add or remove as needed
	 * 
	 * @since 0.4.0
	 * 
	 * @access public
	 * 
	 * @param array						$block_categories		The existing block categories
	 * @param WP_Block_Editor_Context 	$block_editor_context	The current block editor context
	 * @return array
	 */
	public function wp_hook_block_categories_all($block_categories, $block_editor_context) {
		array_unshift($block_categories, array(
			'slug' => 'cla',
			'title' => 'College of Liberal Arts'
		));

		return $block_categories;
	}



	public function wp_hook_block_type_metadata_settings($settings, $metadata) {
		// cla-blocks/call-to-action
		if ($settings['name'] === 'cla-blocks/call-to-action') {
			$settings['example']['attributes']['mediaId'] = 999999999;
			$settings['example']['attributes']['mediaUrl'] = $this->uri . 'assets/images/placeholder-image.jpg';
		}

		// cla-blocks/image-group-item
		if ($settings['name'] === 'cla-blocks/image-group-item') {
			$settings['attributes']['mediaId']['default'] = 999999999;
			$settings['attributes']['mediaUrl']['default'] = $this->uri . 'assets/images/placeholder-image.jpg';
		}

		return $settings;
	}



	public function wp_hook_enqueue_block_assets() {
		$this->enqueue_block_assets();
	}



	public function wp_hook_enqueue_block_editor_assets() {
		$this->enqueue_block_editor_assets();
	}



	/**
	 * WP Hook: init
	 * 
	 * @since 0.1.0
	 * 
	 * @access public
	 * 
	 * @return void
	 */
	public function wp_hook_init(): void {
		$this->register_scripts_styles();
		$this->load_blocks();
	}



	public function wp_hook_wp_enqueue_scripts() {
		$this->enqueue_scripts_styles();
	}
}
CLA_Blocks::get_instance();