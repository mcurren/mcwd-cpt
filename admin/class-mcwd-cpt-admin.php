<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://curren.me
 * @since      1.0.0
 *
 * @package    Mcwd_Cpt
 * @subpackage Mcwd_Cpt/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Mcwd_Cpt
 * @subpackage Mcwd_Cpt/admin
 * @author     Mike Curren <mike@curren.me>
 */
class Mcwd_Cpt_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * The Post Types declared in the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array    $version    The post types to be decalred.
	 */
	private $post_types;

	/**
	 * The custom Taxonomies declared in the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array    $version    The taxonomies to be decalred.
	 */
	private $taxonomies;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version, $post_types, $taxonomies ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->post_types = $post_types;
		$this->taxonomies = $taxonomies;

		add_action('init', array( $this, 'register_custom_post_types' ));

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Mcwd_Cpt_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Mcwd_Cpt_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/mcwd-cpt-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Mcwd_Cpt_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Mcwd_Cpt_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/mcwd-cpt-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function register_custom_post_types() {

		foreach( $this->post_types as $type ) : 

			$args = array(
				'label'								=> $type['title'],
				'labels'							=> array(
						'name'							=> $type['label_plural'],
						'singular_name'			=> $type['label_singular'],
						'add_new'						=> 'Add ' . $type['label_singular'],
						'add_new_item'			=> 'Add New ' . $type['label_singular'],
						'edit_item'					=> 'Edit ' . $type['label_singular'],
						'new_item'					=> 'New ' . $type['label_singular'],
						'view_item'					=> 'View ' . $type['label_singular'],
						'search_items'			=> 'Search ' . $type['label_plural'],
						'not_found'					=> 'No ' . $type['label_plural'] . ' found',
						'not_found_in_trash'=> 'No ' . $type['label_plural'] . ' found in trash',
						'menu_name' 				=> $type['label_plural'],
						'name_admin_bar'		=> $type['label_plural'],
					),
				'public'							=> true,
				'exclude_from_search'	=> false,
				'show_ui'							=> true,
				'menu_position'				=> 23,
				'menu_icon'						=> $type['menu_icon'],
				'has_archive'					=> $type['has_archive'],
				'supports'						=> array('title', 'thumbnail', 'excerpt', 'page_attributes', 'editor'),
				'taxonomies'					=> $type['taxonomies'],
				'show_in_rest'				=> true,
			);

			register_post_type( $type['slug'], $args );

		endforeach;

	}

}
