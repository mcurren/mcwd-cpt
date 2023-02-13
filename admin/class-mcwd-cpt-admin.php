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

		add_action('init', array( $this, 'register_custom_taxonomies' ));

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

			$labels = array(
				'name'                  => $type['name_plural'],
				'singular_name'         => $type['name_singular'],
				'menu_name'             => $type['name_plural'],
				'name_admin_bar'        => $type['name_singular'],
				'archives'              => $type['name_singular'] . ' Archives',
				'attributes'            => $type['name_singular'] . ' Attributes',
				'all_items'             => 'All ' . $type['name_plural'],
				'add_new_item'          => 'Add New ' . $type['name_singular'],
				'add_new'               => 'Add New',
				'new_item'              => 'New ' . $type['name_singular'],
				'edit_item'             => 'Edit ' . $type['name_singular'],
				'update_item'           => 'Update ' . $type['name_singular'],
				'view_item'             => 'View ' . $type['name_singular'],
				'view_items'            => 'View ' . $type['name_plural'],
				'search_items'          => 'Search ' . $type['name_singular'],
				'not_found'             => 'Not found',
				'not_found_in_trash'    => 'Not found in Trash',
				'featured_image'        => 'Featured Image',
				'set_featured_image'    => 'Set featured image',
				'remove_featured_image' => 'Remove featured image',
				'use_featured_image'    => 'Use as featured image',
				'insert_into_item'      => 'Insert into ' . $type['name_singular'],
				'uploaded_to_this_item' => 'Uploaded to this ' . $type['name_singular'],
				'items_list'            => $type['name_plural'] . ' list',
				'items_list_navigation' => $type['name_plural'] . ' list navigation',
				'filter_items_list'     => 'Filter ' . $type['name_plural'] . ' list',
			);

			$args = array(
				'label'                 => $type['name_singular'],
				'labels'                => $labels,
				'supports'              => array( 'title', 'editor', 'thumbnail', 'revisions', 'page-attributes', 'excerpt' ),
				'taxonomies'            => $type['taxonomies'],
				'hierarchical'          => false,
				'public'                => true,
				'show_ui'               => true,
				'show_in_menu'          => true,
				'menu_position'         => 20,
				'menu_icon'             => $type['menu_icon'],
				'show_in_admin_bar'     => true,
				'show_in_nav_menus'     => true,
				'can_export'            => true,
				'has_archive'           => $type['has_archive'],
				'exclude_from_search'   => false,
				'publicly_queryable'    => true,
				'capability_type'       => 'page',
				'show_in_rest'          => true,
				'rest_base'             => $type['rest_base'],
			);

			register_post_type( $type['slug'], $args );
		
		endforeach;

	}

	public function register_custom_taxonomies() {

		foreach( $this->taxonomies as $tax ) :
		
			$labels = array(
				'name'                       => $tax['name_plural'],
				'singular_name'              => $tax['name_singular'],
				'menu_name'                  => $tax['name_plural'],
				'all_items'                  => 'All ' . $tax['name_plural'],
				'parent_item'                => 'Parent ' . $tax['name_singular'],
				'parent_item_colon'          => 'Parent ' . $tax['name_singular'] . ':',
				'new_item_name'              => 'New ' . $tax['name_singular'] . ' Name',
				'add_new_item'               => 'Add New ' . $tax['name_singular'],
				'edit_item'                  => 'Edit ' . $tax['name_singular'],
				'update_item'                => 'Update ' . $tax['name_singular'],
				'view_item'                  => 'View ' . $tax['name_singular'],
				'separate_items_with_commas' => 'Separate ' . $tax['name_plural'] . 'with commas',
				'add_or_remove_items'        => 'Add or remove ' . $tax['name_plural'],
				'choose_from_most_used'      => 'Choose from the most used',
				'popular_items'              => 'Popular ' . $tax['name_plural'],
				'search_items'               => 'Search ' . $tax['name_plural'],
				'not_found'                  => 'Not Found',
				'no_terms'                   => 'No ' . $tax['name_plural'],
				'items_list'                 => $tax['name_plural'] . ' list',
				'items_list_navigation'      => $tax['name_plural'] . ' list navigation',
			);

			$args = array(
				'labels'                     => $labels,
				'hierarchical'               => true,
				'public'                     => true,
				'show_ui'                    => true,
				'show_admin_column'          => true,
				'show_in_nav_menus'          => true,
				'show_tagcloud'              => false,
				'show_in_rest'               => true,
				'rest_base'                  => $tax['rest_base'],
			);
					
			register_taxonomy( $tax['slug'], $tax['post_types'], $args );

		endforeach;

	}

}
