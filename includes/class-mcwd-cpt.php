<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://curren.me
 * @since      1.0.0
 *
 * @package    Mcwd_Cpt
 * @subpackage Mcwd_Cpt/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Mcwd_Cpt
 * @subpackage Mcwd_Cpt/includes
 * @author     Mike Curren <mike@curren.me>
 */
class Mcwd_Cpt {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Mcwd_Cpt_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * The Post Types declared in the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array    $version    The post types to be decalred.
	 */
	protected $post_types;

	/**
	 * The custom Taxonomies declared in the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array    $version    The taxonomies to be decalred.
	 */
	protected $taxonomies;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'MCWD_CPT_VERSION' ) ) {
			$this->version = MCWD_CPT_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'mcwd-cpt';

		if ( defined( 'MCWD_CPT_POST_TYPES' ) ) {
			$this->post_types = MCWD_CPT_POST_TYPES;
		} else {
			$this->post_types = array();
		}

		if ( defined( 'MCWD_CPT_TAXONOMIES' ) ) {
			$this->taxonomies = MCWD_CPT_TAXONOMIES;
		} else {
			$this->taxonomies = array();
		}

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Mcwd_Cpt_Loader. Orchestrates the hooks of the plugin.
	 * - Mcwd_Cpt_i18n. Defines internationalization functionality.
	 * - Mcwd_Cpt_Admin. Defines all hooks for the admin area.
	 * - Mcwd_Cpt_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-mcwd-cpt-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-mcwd-cpt-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-mcwd-cpt-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-mcwd-cpt-public.php';

		$this->loader = new Mcwd_Cpt_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Mcwd_Cpt_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Mcwd_Cpt_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Mcwd_Cpt_Admin(
			$this->get_plugin_name(),
			$this->get_version(),
			$this->get_post_types(),
			$this->get_taxonomies()
		);

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Mcwd_Cpt_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Mcwd_Cpt_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Retrieve the post types to be declared.
	 *
	 * @since     1.0.0
	 * @return    string    The post types to be declared.
	 */
	public function get_post_types() {
		return $this->post_types;
	}

	/**
	 * Retrieve the taxonomies to be declared.
	 *
	 * @since     1.0.0
	 * @return    string    The taxonomies to be declared.
	 */
	public function get_taxonomies() {
		return $this->taxonomies;
	}

}
