<?php

/**
 * Uninstall class
 * 
 * @since 0.1.0
 */

namespace cla_blocks\includes;

class Uninstall {
	/**
     * prefix
     * 
     * @since 0.1.0
     * @access protected
     * @var string  The plugin prefix
     */
    protected $prefix = 'prefix_';



    /**
     * Uninstall constructor
     * 
     * @since 0.1.0
     */
    public function __construct($args = array()) {
        if (!defined('WP_UNINSTALL_PLUGIN')) {
            die;
        }

		if (!empty($args['prefix'])) {
			$this->prefix = $args['prefix'];
		}

        // Run uninstall
        $this->uninstall();
    }



    /**
     * Uninstall the plugin
     * 
     * @since 0.1.0
     * @access protected
     * @return void
     */
    protected function uninstall(): void {
        $this->uninstall_globals();

        if (is_multisite()) {
            $this->uninstall_multisite();
        } else {
            $this->uninstall_single_site();
        }
    }



    /**
     * Uninstall plugin globals
     * 
     * @since 0.1.0
     * @access protected
     * @return void
     */
    protected function uninstall_globals() {
		delete_site_option($this->prefix . 'installed_version');
		delete_site_option($this->prefix . 'update_info');
    }



    /**
     * Uninstall the plugin on a single site
     * 
     * @since 0.1.0
     * @access protected
     * @return void
     */
    protected function uninstall_single_site() {
        
    }



    /**
     * Uninstall the plugin on multisite
     * 
     * @since 0.1.0
     * @access protected
     * @return void
     */
    protected function uninstall_multisite() {
        $sites = get_sites(array(
            'network_id' => null,
            'limit' => 10000
        ));

        foreach ($sites as $blog) {
            switch_to_blog($blog['blog_id']);

            $this->uninstall_single_site();

            restore_current_blog();
        }
    }
}