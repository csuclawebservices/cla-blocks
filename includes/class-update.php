<?php

/**
 * Update class
 * 
 * @since 0.1.0
 */

namespace cla_blocks\includes;

class Update {
    /**
     * plugin_version
     * 
     * @since 0.1.0
     * @access protected
     * @var string  The plugin version
     */
    protected $plugin_version = '';

	/**
     * prefix
     * 
     * @since 0.1.0
     * @access protected
     * @var string  The plugin prefix
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
        if (empty($args['plugin_version']) || empty($args['prefix'])) {
            throw new \Exception('$args must be an array and include plugin_version and prefix');
        }

        // Setup install
        $this->setup();
    }



    /**
     * Check to see if the plugin needs to update and if so kick off the update process
     * 
     * @since 0.1.0
     * 
     * @return void
     */
    public function maybe_update() {
        if (!is_user_logged_in()) {
            return;
        }

        $installed_version = get_site_option($this->prefix . 'installed_version');

        if ($installed_version === false) {
            $installed_version = '0.0.0';
        }

        if (version_compare($installed_version, $this->plugin_version, '<')) {
            if (is_multisite()) {
                $this->update_multisite($installed_version);
            } else {
                $this->update_single_site($installed_version);
            }

            update_site_option($this->prefix . 'installed_version', $this->plugin_version);
            update_site_option($this->prefix . 'update_info', array(
                'from' => $installed_version,
                'to' => $this->plugin_version
            ));
        }
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
        // Add actions
        add_action('admin_init', array($this, 'maybe_update'));
    }



    /**
     * Run the update process on multisite
     * 
     * @since 0.1.0
     * 
     * @access protected
     * 
     * @param string    $installed_version  The version number of the currently installed plugin
     * @return void
     */
    protected function update_multisite($installed_version) {
        // Do network updates

        $sites = get_sites(array(
            'network_id' => null,
            'limit' => 10000
        ));

        foreach ($sites as $site) {
            switch_to_blog($site->id);

            $this->update_single_site($installed_version);

            restore_current_blog();
        }
    }



    /**
     * Run the update process
     * 
     * @since 0.1.0
     * 
     * @access protected
     * 
     * @param string    $installed_version  The version number of the currently installed plugin
     * @return void
     */
    protected function update_single_site($installed_version) {
        // Do updates
        if (version_compare($installed_version, '0.1.1', '<')) {
			$this->v_0_1_1();
		}

        // Flush the rewrite rules
        if (is_multisite() && wp_is_large_network()) {
            // WordPress Notice letting the admin know rewrite rules should be flushed
        } else {
            // On non-large networks flush the rules by deleting the rewrite rules option
            //delete_option('rewrite_rules');
        }

        do_action('cla_blocks_update_single_site');
    }



    protected function v_0_1_1() {
        // Initial release update / init - not needed but here for future use
    }
}