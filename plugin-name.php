<?php

/**
 * Plugin Name:       Plugin Name
 * Plugin URI:        https://wordpress.org/plugins/plugin-name
 * Description:       test plugin
 * Version:           1.0.0
 * Author:            Noruzzaman
 * Author URI:        https://github.com/noruzzamanrubel/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       plugin-name
 * Domain Path:       /languages
 */

/**
 * If this file is called directly, abort.
 */
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Require the Composer autoloader
 */
require_once __DIR__ . '/vendor/autoload.php';

/**
 * Import necessary classes and namespaces
 */
use plugin\name\Activator;
use plugin\name\Deactivator;
use plugin\name\Admin\Admin;
use plugin\name\Frontend\Frontend;
use plugin\name\Loader;
use plugin\name\I18n;

/**
 * Main class for the Plugin Name plugin.
 */
final class Plugin_name {

	/**
	 * Properties for plugin information
	 */
	protected $loader;
	public $version     = '1.0.0';
	public $plugin_name = 'Plugin Name';
	public $plugin_slug = 'plugin-name';

	/**
	 * Constructor for the plugin_name class.
	 */
	public function __construct() {

		/**
		 * Define plugin constants
		 */
		$this->define_constants();

		/**
		 * Initialize the loader
		 */
		$this->loader = new Loader();

		/**
		 * Set the plugin's localization
		 */
		$this->set_locale();

		/**
		 * If in the admin, define admin hooks
		 */
		if (is_admin()) {
			$this->define_admin_hooks();
		}

		/**
		 * Define public hooks
		 */
        $this->define_public_hooks();

		/**
		 * Register activation and deactivation hooks
		 */
		register_activation_hook( __FILE__, [ $this, 'plugin_name_activate'] );
        register_deactivation_hook( __FILE__, [ $this, 'plugin_name_deactivate' ] );

	}

	/**
     * Define the constants used by the plugin.
     */
    public function define_constants() {

		/**
		 * Plugin version
		 */
		define( 'PLUGIN_NAME_VERSION', $this->version );

		/**
		 * Plugin paths and URLs
		 */
		define( 'PLUGIN_NAME_PATH', plugin_dir_path( __FILE__ ) );
		define( 'PLUGIN_NAME_URL', plugin_dir_url( __FILE__ ) );

		/**
		 * Plugin slug, name, and base name
		 */
		define( 'PLUGIN_NAME_SLUG', $this->plugin_slug );
		define( 'PLUGIN_NAME_NAME', $this->plugin_name );
		define( 'PLUGIN_NAME_BASE_NAME', plugin_basename( __FILE__ ) );
    }

	/**
	 * Set the localization for the plugin.
	 */
	private function set_locale() {

        /**
		 * Initialize the I18n class for localization
		 */
        $plugin_i18n = new I18n();

		/**
		 * Load the plugin text domain
		 */
		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Define admin-specific hooks and actions.
	 */
	private function define_admin_hooks() {

		/**
		 * Initialize the Admin class for admin functionality
		 */
		$plugin_admin = new Admin( $this->get_plugin_name(), $this->get_version() );

		/**
		 * Enqueue admin styles and scripts
		 */
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Define public-facing hooks and actions.
	 */
	private function define_public_hooks() {

		/** 
		 * Initialize the Frontend class for public-facing functionality
		 */
		$plugin_public = new Frontend( $this->get_plugin_name(), $this->get_version() );

		/** 
		 * Enqueue public styles and scripts
		 */
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the plugin by initializing the loader.
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * Get the plugin name.
	 *
	 * @return string The plugin name.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * Get the loader instance.
	 *
	 * @return Loader The loader instance.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Get the plugin version.
	 *
	 * @return string The plugin version.
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Activation hook callback to perform actions on plugin activation.
	 */
	public function plugin_name_activate() {
		Activator::activate();
	}

	/**
	 * Deactivation hook callback to perform actions on plugin deactivation.
	 */
	public function plugin_name_deactivate() {
		Deactivator::deactivate();
	}

}

/** 
 * Instantiate the plugin class and run it
 */
$pluginInstance = new Plugin_name();
$pluginInstance->run();