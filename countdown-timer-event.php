<?php
/*
 Plugin Name: Countdown Timer Event
 Plugin URI: #

 Description: Countdown Timer Event is easy to use and display the responsive countdown timers into pages/posts.
 Author: wptexture
 Author URI: http://testerwp.com/

 Version: 1.0 
 Text Domain: countdown-timer-event

 * @package Countdown Timer Event
 * @version 1.0 
 */
/** Configuration **/

if ( !defined( 'CTE_COUNTDOWN_TIMER_EVENT_CURRENT_VERSION' ) ) {
    define( 'CTE_COUNTDOWN_TIMER_EVENT_CURRENT_VERSION', '1.0.0' );
}


define( 'CTE_COUNTDOWN_TIMER_EVENT_DIR'              , plugin_dir_path(__FILE__) );
define( 'CTE_COUNTDOWN_TIMER_EVENT_URL'              , plugin_dir_url(__FILE__) );

define( 'CTE_COUNTDOWN_TIMER_EVENT_INCLUDES'         , CTE_COUNTDOWN_TIMER_EVENT_DIR        . 'includes'     . DIRECTORY_SEPARATOR );
define( 'CTE_COUNTDOWN_TIMER_EVENT_LANGUAGES'        , CTE_COUNTDOWN_TIMER_EVENT_DIR        . 'languages'    . DIRECTORY_SEPARATOR );
define( 'CTE_COUNTDOWN_TIMER_EVENT_TEMPLATES'       , CTE_COUNTDOWN_TIMER_EVENT_DIR        . 'templates'    . DIRECTORY_SEPARATOR );
define( 'CTE_COUNTDOWN_TIMER_EVENT_ADMIN'            , CTE_COUNTDOWN_TIMER_EVENT_INCLUDES   . 'admin'        . DIRECTORY_SEPARATOR );
define( 'CTE_COUNTDOWN_TIMER_EVENT_LIBRARIES'        , CTE_COUNTDOWN_TIMER_EVENT_INCLUDES   . 'libraries'    . DIRECTORY_SEPARATOR );

define( 'CTE_COUNTDOWN_TIMER_EVENT_ASSETS'           , CTE_COUNTDOWN_TIMER_EVENT_URL . 'assets/' );
define( 'CTE_COUNTDOWN_TIMER_EVENT_JS'               , CTE_COUNTDOWN_TIMER_EVENT_URL . 'assets/js/' );
define( 'CTE_COUNTDOWN_TIMER_EVENT_IMAGES'           , CTE_COUNTDOWN_TIMER_EVENT_URL . 'assets/images/' );



/**
* Activating plugin and adding some info
*/
function cte_activate() {
    update_option( "cte-countdown-timer-event-v", CTE_COUNTDOWN_TIMER_EVENT_CURRENT_VERSION );
    update_option("cte-countdown-timer-event-type","FREE");
    update_option("cte-countdown-timer-event-installDate",date('Y-m-d h:i:s') );
}

/**
 * Deactivate the plugin
 */
function cte_deactivate() {
    // Do nothing
} 

// Installation and uninstallation hooks
register_activation_hook(__FILE__, 'cte_activate' );
register_deactivation_hook(__FILE__, 'cte_deactivate' );

/**
 * The core plugin class.
 */
require CTE_COUNTDOWN_TIMER_EVENT_INCLUDES . 'class-countdown-timer-event.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function cte_countdown_timer_run() {
	// instantiate the plugin class
    $CTE_countdown = new CTE_Countdown_Timer_Event();
} 
cte_countdown_timer_run();