<?php

/**
 * Install class
 * 
 * @since 0.1.0
 */

namespace cla_blocks\includes;

class Install {
    /**
     * min_php_version
     * 
     * @since 0.1.0
     * @access protected
     * @var  string  The minimum php version
     */
    protected $min_php_version = '';

    /**
     * min_wp_version
     * 
     * @since 0.1.0
     * @access protected
     * @var string  The minimum WordPress version
     */
    protected $min_wp_version = array();

    /**
     * plugin_dir
     * 
     * @since 0.1.0
     * @access protected
     * @var string  The absolute path to the plugin root directory
     */
    protected $plugin_dir = array();

    /**
     * plugin_file
     * 
     * @since 0.1.0
     * @access protected
     * @var string  The name of the main plugin file
     */
    protected $plugin_file = array();

    /**
     * plugin_version
     * 
     * @since 0.1.0
     * @access protected
     * @var string  The plugin version
     */
    protected $plugin_version = array();

	/**
	 * prefix
	 * 
	 * @since 0.1.0
	 * @access protected
	 * @var string	The plugin prefix
	 */
	protected $prefix = 'prefix_';



    /**
     * Install constructor
     * 
     * @since 0.1.0
     * 
     * @return void
     */
    public function __construct($args = array()) {
        // Set config
        $this->set_config($args);

        // Throw an exception if $args is not an array or if it's empty
        if (empty($args['min_php_version']) || empty($args['min_wp_version']) || empty($args['plugin_dir']) || empty($args['plugin_file']) || empty($args['plugin_version'])) {
            throw new \Exception('$args must be an array and include min_php_version, min_wp_version, plugin_dir, plugin_file, and plugin_version');
        }

        // Setup install
        $this->setup();
    }



    /**
     * Run the activation process on multisite
     * 
     * This will run the activation process on each individual site on the multisite instance
     * 
     * @since 0.1.0
     * 
     * @access protected
     * 
     * @return void
     */
    protected function activate_multisite() {
        // Do network updates

        $sites = get_sites(array(
            'network_id' => null,
            'limit' => 10000
        ));

        foreach ($sites as $blog) {
            switch_to_blog($blog['blog_id']);

            $this->activate_single_site();

            restore_current_blog();
        }
    }



    /**
     * Run the activation process on a single site
     * 
     * @since 0.1.0
     * 
     * @access protected
     * 
     * @return void
     */
    protected function activate_single_site() {
        do_action($this->prefix . 'activate_single_site');
    }



    /**
     * Handles the plugin activation process
     * 
     * @since 0.1.0
     * 
     * @return void
     */
    public function activation($network_wide = false) {
        $meets_requirements = $this->plugin_meets_requirements();

        // Check for minimum WordPress and PHP versions
        if ($meets_requirements !== true) {
            $this->activation_failure();
        }

        if ($network_wide === true) {
            $this->activate_multisite();
        } else {
            $this->activate_single_site();
        }
    }



    /**
     * Handles the plugin activation failure process
     * 
     * @since 0.1.0
     * 
     * @access protected
     * 
     * @return void
     */
    protected function activation_failure($message = '') {
        if (empty($message) || !is_string($message)) {
            $message = $this->plugin_file . ' requires WordPress ' . $this->min_wp_version . ' and PHP ' . $this->min_php_version . '.';
        }

        deactivate_plugins(array(basename($this->plugin_dir) . '/' . $this->plugin_file), false, is_network_admin());
        die($message);
    }



    /**
     * Run the deactivation process on multisite
     * 
     * This will run the deactivation process on each individual site on the multisite instance
     * 
     * @since 0.1.0
     * 
     * @access protected
     * 
     * @return void
     */
    protected function deactivate_multisite() {
        $sites = get_sites(array(
            'network_id' => null,
            'limit' => 10000
        ));

        foreach ($sites as $blog) {
            switch_to_blog($blog['blog_id']);

            $this->deactivate_single_site();

            restore_current_blog();
        }
    }



    /**
     * Run the deactivation process on a single site
     * 
     * @since 0.1.0
     * 
     * @access protected
     * 
     * @return void
     */
    protected function deactivate_single_site() {
		do_action($this->prefix . 'deactivate_single_site');
    }



    /**
     * Handles the plugin deactivation process
     * 
     * @since 0.1.0
     * 
     * @return void
     */
    public function deactivation($network_deactivating = false) {
        if ($network_deactivating === true) {
            $this->deactivate_multisite();
        } else {
            $this->deactivate_single_site();
        }
    }



    /**
     * Checks to see if the plugin mimimum requirements are met
     * 
     * @since 0.1.0
     * 
     * @access protected
     * 
     * @return bool  Returns true if the minimum requirements are met. False if not.
     */
    protected function plugin_meets_requirements() {
        global $wp_version;

        $meets_requirements = true;

        if (version_compare($wp_version, $this->min_wp_version, '<')) {
            $meets_requirements = false;
        } else if (version_compare(phpversion(), $this->min_php_version, '<')) {
            $meets_requirements = false;
        }

        return $meets_requirements;
    }



    /**
     * Parse the class config arguments and set properties
     * 
     * @since 0.1.0
     * 
     * @access protected
     * 
     * @param array     $args   Install args
     * @return void
     */
    protected function set_config($args = array()) {
        if (!empty($args['min_php_version'])) {
            $this->min_php_version = $args['min_php_version'];
        }

        if (!empty($args['min_wp_version'])) {
            $this->min_wp_version = $args['min_wp_version'];
        }

        if (!empty($args['plugin_dir'])) {
            $this->plugin_dir = $args['plugin_dir'];
        }

        if (!empty($args['plugin_file'])) {
            $this->plugin_file = $args['plugin_file'];
        }

        if (!empty($args['plugin_version'])) {
            $this->plugin_version = $args['plugin_version'];
        }

		if (!empty($args['prefix'])) {
			$this->prefix = $args['prefix'];
		}
    }



    /**
     * Setup the class
     * 
     * @since 0.1.0
     * 
     * @access protected
     * 
     * @return void
     */
    protected function setup() {
        // Register activation hook
        register_activation_hook($this->plugin_dir . $this->plugin_file, array($this, 'activation'));

        // Register deactivation hook
        register_deactivation_hook($this->plugin_dir . $this->plugin_file, array($this, 'deactivation'));
    }
}