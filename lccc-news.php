<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.lorainccc.edu/
 * @since             1.0.0
 * @package           Lccc_News
 *
 * @wordpress-plugin
 * Plugin Name:       LCCC News
 * Plugin URI:        http://www.lorainccc.edu/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            David Brattoli
 * Author URI:        http://www.lorainccc.edu/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       lccc-news
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-lccc-news-activator.php
 */
function activate_lccc_news() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-lccc-news-activator.php';
	Lccc_News_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-lccc-news-deactivator.php
 */
function deactivate_lccc_news() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-lccc-news-deactivator.php';
	Lccc_News_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_lccc_news' );
register_deactivation_hook( __FILE__, 'deactivate_lccc_news' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-lccc-news.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_lccc_news() {

	$plugin = new Lccc_News();
	$plugin->run();

}
run_lccc_news();



function my_plugin_init() {
	if( class_exists( 'WordPressAngularJS' ) ) {
 
		// do my plugin stuff here
 
	}else{
		function angular_admin_notice() {
   			$class = 'notice notice-error is-dismissible';
						$message = __( '	
The plugin <a href="https://wordpress.org/plugins/angularjs-for-wp/">AngularJS for WordPress</a> by <a href="https://profiles.wordpress.org/guavaworks/">Roy Sivan</a> is currently Inactive or Unistalled. Please install and activate the plugin so that LCCC News plugin can function properly.', 'sample-text-domain' );
						printf( '<div class="%1$s"><p>%2$s</p></div>', $class, $message ); 
					}
add_action( 'network_admin_notices', 'angular_admin_notice' );

	}
}
add_action( 'plugins_loaded', 'my_plugin_init' );

function lccc_news_scripts() {

	wp_enqueue_script('Moment-Js', plugin_dir_url( __FILE__ ) . 'js/moment.js');

	wp_enqueue_script('Moment-with-locale-Js', plugin_dir_url( __FILE__ ) . 'js/moment-with-locales.min.js');
	
		wp_enqueue_script('angular-calendar', plugin_dir_url( __FILE__ ) . 'js/angular-calendar.js','angular-core','1',true);
	
			wp_enqueue_style('font-awesome', plugin_dir_url( __FILE__ ) . 'css/font-awesome/css/font-awesome.min.css');

}
add_action ('init','lccc_news_scripts');