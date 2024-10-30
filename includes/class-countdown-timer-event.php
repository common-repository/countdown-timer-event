<?php
/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 */

class CTE_Countdown_Timer_Event {
    

    private function cte_load_dependencies() {

        require_once CTE_COUNTDOWN_TIMER_EVENT_INCLUDES . 'libraries/class-countdown-template-loader.php';
        require_once CTE_COUNTDOWN_TIMER_EVENT_INCLUDES . 'helper/class-countdown-timer-event-helper.php';
        require_once CTE_COUNTDOWN_TIMER_EVENT_INCLUDES . 'admin/class-countdown-timer-event-cpt.php';
        require_once CTE_COUNTDOWN_TIMER_EVENT_INCLUDES . 'public/class-countdown-shortcode.php';
    }

    private function cte_define_admin_hooks() {
        add_action( 'admin_enqueue_scripts', array( $this, 'cte_admin_scripts' ), 20 );
        new CTE_Countdown_WP_CPT();
    }
    private function cte_define_public_hooks() {}
    
    /*
     * Including required files
     */
    public function cte_dropdown_include_files() {

    }
    
	/* Enqueue Admin Scripts */
	public function cte_admin_scripts( $hook ) {

		global $id, $post;

        // Get current screen.
        $screen = get_current_screen();

        // Check if is cte_countdown_timer custom post type
        if ( 'cte_countdown_timer' !== $screen->post_type ) {
            return;
        }

        // Set the post_id
        $post_id = isset( $post->ID ) ? $post->ID : (int) $id;

		if ( 'post-new.php' == $hook || 'post.php' == $hook ) {

			/* CPT Styles & Scripts */
			// Media Scripts
			wp_enqueue_media( array(
	            'post' => $post_id,
	        ) );

	       /* $countdown_wp_helper = array(
	        	'items' => array(),
	        	'settings' => array(),
	        	'strings' => array(
	        		'limitExceeded' => sprintf( __( 'You excedeed the limit of 20 photos. You can remove an image or %supgrade to pro%s', 'countdown-timer-event' ), '<a href="#" target="_blank">', '</a>' ),
	        	),
	        	'id' => $post_id,
	        	'_wpnonce' => wp_create_nonce( 'countdown-ajax-save' ),
	        	'ajax_url' => admin_url( 'admin-ajax.php' ),
	        );*/

	        // Get all items from current gallery.
	        /*$images = get_post_meta( $post_id, 'countdown-images', true );
	        if ( is_array( $images ) && ! empty( $images ) ) {
	        	foreach ( $images as $image ) {
	        		if ( ! is_numeric( $image['id'] ) ) {
	        			continue;
	        		}

	        		$attachment = wp_prepare_attachment_for_js( $image['id'] );
	        		$image_url  = wp_get_attachment_image_src( $image['id'], 'large' );
					$image_full = wp_get_attachment_image_src( $image['id'], 'full' );

					$image['full']        = $image_full[0];
					$image['thumbnail']   = $image_url[0];
					$image['orientation'] = $attachment['orientation'];

					$countdown_wp_helper['items'][] = $image;

	        	}
	        }*/

	        // Get current gallery settings.
	        $settings = get_post_meta( $post_id, 'cte-countdown-timer-settings', true );
	        if ( is_array( $settings ) ) {
	        	$countdown_wp_helper['settings'] = wp_parse_args( $settings, CTE_CPT_Fields_Helper::cte_get_defaults() );
	        }else{
	        	$countdown_wp_helper['settings'] = CTE_CPT_Fields_Helper::cte_get_defaults();
	        }

	        
			wp_enqueue_style( 'wp-color-picker' );
			
			wp_enqueue_style( 'cte-countdown-timer-event-cpt',           CTE_COUNTDOWN_TIMER_EVENT_ASSETS . 'css/countdown-timer-event-cpt.css', null, CTE_COUNTDOWN_TIMER_EVENT_CURRENT_VERSION );

			wp_enqueue_script( 'cte-countdown-timer-event-settings',      CTE_COUNTDOWN_TIMER_EVENT_ASSETS . 'js/cte-countdown-timer-event-settings.js', array( 'jquery', 'jquery-ui-slider', 'wp-color-picker', 'jquery-ui-sortable' ), CTE_COUNTDOWN_TIMER_EVENT_CURRENT_VERSION, true );
			
			wp_enqueue_style( 'cte-countdown-bootstrap-css', CTE_COUNTDOWN_TIMER_EVENT_ASSETS . 'css/bootstrap.css', null, CTE_COUNTDOWN_TIMER_EVENT_CURRENT_VERSION );

			/*fontawesome*/
			wp_enqueue_style('cte-countdown-font-awesome-5.0.8', CTE_COUNTDOWN_TIMER_EVENT_ASSETS.'fonts/font-awesome-latest/css/fontawesome-all.min.css');

			wp_enqueue_script( 'cte-countdown-timer-conditions',    CTE_COUNTDOWN_TIMER_EVENT_ASSETS . 'js/cte-countdown-timer-conditions.js', array(), CTE_COUNTDOWN_TIMER_EVENT_CURRENT_VERSION, true );

			do_action( 'cte_countdown_scripts_before_countdown' );

			wp_enqueue_script( 'CTECountdownWP', CTE_COUNTDOWN_TIMER_EVENT_ASSETS . 'js/cte-countdown-timer-event.js', array(), CTE_COUNTDOWN_TIMER_EVENT_CURRENT_VERSION, true );
			
			wp_localize_script( 'CTECountdownWP', 'CTECountdownWPHelper', $countdown_wp_helper );
			
			do_action( 'cte_countdown_scripts_after_countdown' );

		}

	}


    // loading language files
    public function cte_load_plugin_textdomain() {
        $rs = load_plugin_textdomain('countdown-timer-event', FALSE, basename(dirname(__FILE__)) . '/languages/');
    }

    
    public function __construct() {
        
		$this->cte_load_dependencies();
		$this->cte_define_admin_hooks();
		$this->cte_define_public_hooks();

        
        // Including required files
        add_action('plugins_loaded', array($this, 'cte_dropdown_include_files'));      

        //loading plugin translation files
        add_action('plugins_loaded', array($this, 'cte_load_plugin_textdomain'));

        /*if ( is_admin() ) {
            $plugin = plugin_basename(__FILE__);
        }*/
    }

}
