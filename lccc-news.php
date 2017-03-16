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

function build_event_date_list(){
	//Create an Array for storing the dates that have events
			$dates_with_events = array();
		
		//Grab posts (endpoints)
			$lcccevents = '';
			$stockerevents = '';
			$athleticevents = '';
			$sportevents = '';
			$categoryevents = '';
			$domain = 'http://www.lorainccc.edu';
			//$domain = 'http://' . $_SERVER['SERVER_NAME'];
			$lcccevents = new Endpoint( $domain . '/mylccc/wp-json/wp/v2/lccc_events/?per_page=100' );
			$athleticevents = new Endpoint( $domain . '/athletics/wp-json/wp/v2/lccc_events/?per_page=100' );
			$stockerevents = new Endpoint( 'http://sites.lorainccc.edu/stocker/wp-json/wp/v2/lccc_events/?per_page=100' );
		
			//Create instance
	$multi = new MultiBlog( 1 );
		$multi->add_endpoint ( $lcccevents );
		$multi->add_endpoint ( $athleticevents );
		$multi->add_endpoint ( $stockerevents );
		
	//Fetch Posts(Events) from Endpoints
	$posts = $multi->get_posts();
	if(empty($posts)){
		echo 'No Posts Found!';
	}
		
	//establishing current date for testing
		 $currentdate = date("Y-m-d");
		
 //Filling array with dates with events
		 foreach ( $posts as $post ){
					if( $post->event_end_date > $currentdate ){
									array_push($dates_with_events, $post->event_end_date);
					}
			}
		$dates_with_events = array_unique($dates_with_events);
		$dates_with_events = array_filter($dates_with_events);
		$dates_with_events = array_values($dates_with_events);
	
	return $dates_with_events;
	
}

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
	
		wp_enqueue_script('ajax-calendar', plugin_dir_url( __FILE__ ).'js/ajax-calendar.js',array('jquery','Moment-Js'),'1',true);
	
	//Look into passing an array or function or  multiblog into the javascript to create list of dates to populate the calendar
	wp_localize_script('ajax-calendar', 'wpDirectory', array(
    'pluginsUrl' => plugins_url(),
				'arrayOfDates' => build_event_date_list(),
));

	
	wp_enqueue_script( 'angular-resource', '//ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular-resource.js', array('angular-core'), '1.0', false );
	
	wp_enqueue_script( 'ui-router', 'https://cdnjs.cloudflare.com/ajax/libs/angular-ui-router/0.2.15/angular-ui-router.min.js', array( 'angular-core' ), '1.0', false );
	
		wp_enqueue_script( 'angular-route', 'https://ajax.googleapis.com/ajax/libs/angularjs/1.4.7/angular-route.min.js', array( 'angular-core' ), '1.0', false );
	
	
			wp_enqueue_style('font-awesome', plugin_dir_url( __FILE__ ) . 'css/font-awesome/css/font-awesome.min.css');

		wp_enqueue_style('calendar-css', plugin_dir_url( __FILE__ ) . 'css/calendar.css');
		
}
add_action ('init','lccc_news_scripts');

require_once( plugin_dir_path( __FILE__ ).'php/plugin_functions.php' );

require_once( plugin_dir_path( __FILE__ ).'php/rest-api-fetch.php' );

require_once( plugin_dir_path( __FILE__ ).'php/lccc_calendarwidget.php' );
