<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://curren.me
 * @since             1.0.0
 * @package           Mcwd_Cpt
 *
 * @wordpress-plugin
 * Plugin Name:       MCWD Site Utilities
 * Plugin URI:        https://curren.me
 * Description:       Primarily a programmatic declaration of Custom Post Types & Taxonomies for a WordPress site.
 * Version:           1.0.0
 * Author:            Mike Curren
 * Author URI:        https://curren.me
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       mcwd-cpt
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Current plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'MCWD_CPT_VERSION', '1.0.0' );

/**
 * Custom Post Type variables.
 * Each custom post type to be declared should define the following 
 * variables in an array: 
 * slug, title, label_menu, label_singular, label_plural, 
 * menu_icon, taxonomies, has_archive
 */
define( 'MCWD_CPT_POST_TYPES', array(
	array(
		'slug' 						=> 'projects',
		'title' 					=> 'Portfolio Projects',
		'label_menu' 			=> 'Portfolio',
		'label_singular' 	=> 'Project',
		'label_plural'		=> 'Projects',
		'menu_icon'				=> 'dashicons-open-folder',
		'taxonomies'			=> array('portfolio_category'),
		'has_archive'			=> false,
	),
) );

/**
 * Custom Taxonomy variables.
 * Each custom taxonomy to be declared should define the following 
 * variables in an array: 
 * ...
 */
define( 'MCWD_CPT_TAXONOMIES', array(

) );
	
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-mcwd-cpt-activator.php
 */
function activate_mcwd_cpt() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mcwd-cpt-activator.php';
	Mcwd_Cpt_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-mcwd-cpt-deactivator.php
 */
function deactivate_mcwd_cpt() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mcwd-cpt-deactivator.php';
	Mcwd_Cpt_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_mcwd_cpt' );
register_deactivation_hook( __FILE__, 'deactivate_mcwd_cpt' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-mcwd-cpt.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_mcwd_cpt() {

	$plugin = new Mcwd_Cpt();
	$plugin->run();

}
run_mcwd_cpt();