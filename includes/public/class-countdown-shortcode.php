<?php


class CTE_Countdown_Shortcode {


	private $loader;

	function __construct() {

		$this->loader  = new CTE_Countdown_Template_Loader();

		add_shortcode( 'countdown_timer', array( $this, 'cte_countdown_shortcode_handler' ) );
		add_shortcode( 'Countdown_Timer', array( $this, 'cte_countdown_shortcode_handler' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'cte_gallery_scripts' ) );
	}

	public function cte_gallery_scripts() {

		wp_enqueue_style( 'countdown-index-css', CTE_COUNTDOWN_TIMER_EVENT_ASSETS . 'css/custom.css', null, CTE_COUNTDOWN_TIMER_EVENT_CURRENT_VERSION );

		wp_enqueue_style( 'bootstrap-css', CTE_COUNTDOWN_TIMER_EVENT_ASSETS . 'css/bootstrap.css', null, CTE_COUNTDOWN_TIMER_EVENT_CURRENT_VERSION );

						
		/*================Layout 1================*/
		wp_enqueue_style( 'jquery-classycountdown-css', CTE_COUNTDOWN_TIMER_EVENT_ASSETS . 'css/jquery.classycountdown.css', null, CTE_COUNTDOWN_TIMER_EVENT_CURRENT_VERSION );
		
		wp_enqueue_script( 'jquery-classycountdown-js', CTE_COUNTDOWN_TIMER_EVENT_ASSETS . 'js/jquery.classycountdown.js', array( 'jquery' ), CTE_COUNTDOWN_TIMER_EVENT_CURRENT_VERSION, false );

		wp_enqueue_script( 'jquery-knob-js', CTE_COUNTDOWN_TIMER_EVENT_ASSETS . 'js/jquery.knob.js', array( 'jquery' ), CTE_COUNTDOWN_TIMER_EVENT_CURRENT_VERSION, false );
		
		wp_enqueue_script( 'jquery-throttle-js', CTE_COUNTDOWN_TIMER_EVENT_ASSETS . 'js/jquery.throttle.js', array( 'jquery' ), CTE_COUNTDOWN_TIMER_EVENT_CURRENT_VERSION, false );
		
		wp_enqueue_script( 'script-layout-1', CTE_COUNTDOWN_TIMER_EVENT_ASSETS . 'js/scripts.js', array( 'jquery' ), CTE_COUNTDOWN_TIMER_EVENT_CURRENT_VERSION, false );
		
		/*================Layout 2=================*/
		
		wp_enqueue_script( 'moment-timezone-js', CTE_COUNTDOWN_TIMER_EVENT_ASSETS . 'js/moment-timezone.min.js', array( 'jquery' , 'moment' ), CTE_COUNTDOWN_TIMER_EVENT_CURRENT_VERSION, false );
		
		wp_enqueue_script( 'moment-with-data-js', CTE_COUNTDOWN_TIMER_EVENT_ASSETS . 'js/moment-timezone-with-data.min.js', array( 'jquery' ), CTE_COUNTDOWN_TIMER_EVENT_CURRENT_VERSION, false );

		wp_enqueue_script( 'countdown-index', CTE_COUNTDOWN_TIMER_EVENT_ASSETS . 'js/cte-countdown-index.js', array( 'jquery' ), CTE_COUNTDOWN_TIMER_EVENT_CURRENT_VERSION, false );

		wp_enqueue_style('rpg-font-awesome-5.0.8', CTE_COUNTDOWN_TIMER_EVENT_ASSETS. 'fonts/font-awesome-latest/css/fontawesome-all.min.css');

	}


	public function cte_countdown_shortcode_handler( $atts ) {

		$default_atts = array(
			'id' => false,
			'align' => '',
		);

		$atts = wp_parse_args( $atts, $default_atts );

		if ( ! $atts['id'] ) {
			return esc_html__( 'Countdown Timer Event not found.', 'countdown-timer-event' );
		}

		/* Generate uniq id for this gallery */
		$cte_id = 'cte-' . $atts['id'];

		// Check if is an old Portfolio post or new.
		$gallery = get_post( $atts['id'] );
		if ( 'cte_countdown_timer' != get_post_type( $gallery ) ) {
			$cdt_posts = get_posts( array(
				'post_type' => 'cte_countdown_timer',
				'post_status' => 'publish',
				'meta_query' => array(
					array(
						'key'     => 'countdown-id',
						'value'   => $atts['id'],
						'compare' => '=',
					),
				),
			) );

			if ( empty( $cdt_posts ) ) {
				return esc_html__( 'Countdown Timer Event not found.', 'countdown-timer-event' );
			}

			$atts['id'] = $cdt_posts[0]->ID;

		}

		/* Get Countdown Timer Event settings */
		$settings = get_post_meta( $atts['id'], 'cte-countdown-timer-settings', true );
		$default  = CTE_CPT_Fields_Helper::cte_get_defaults();
		$settings = wp_parse_args( $settings, $default );

		$type = '1';
		if ( isset( $settings['type'] ) ) {
			$type = $settings['type'];
		}else{
			$settings['type'] = '2';
		}
		

		do_action('portfolio_extra_scripts',$settings);

		
		$settings['cte_id'] = $cte_id;
		$settings['align']      = $atts['align'];

		$template_data = array(
			'cte_id' => $cte_id,
			'settings'   => $settings,
			'loader'     => $this->loader,
		);

		ob_start();

		/* Config for gallery script */
		/*$js_config = array(
			'type'            => $type,
			'columns'         => 12,
		);*/
		
		//$template_data['js_config'] = apply_filters( 'countdown_timer_event_settings', $js_config, $settings );
		$template_data              = apply_filters( 'countdown_timer_template_data', $template_data );

	
		
		echo $this->cte_generate_css( $cte_id, $settings );
				
		
		$this->loader->set_template_data( $template_data );


    	$this->loader->get_template_part( 'countdown', 'timer' ); //load countdown-timer.php

    	$html = ob_get_clean();
    	return $html;
	}
	
	private function cte_generate_css( $cte_id, $settings ) {

		$css = "<style>";
        
        $css .= "#{$cte_id} { width:" . esc_attr($settings['width']) . ";}";

        $css .= "#{$cte_id} { float:" . esc_attr($settings['align_design']) . ";}";

        $css .= "#{$cte_id} *{ font-family:" . esc_attr($settings['font_family']) . ";}";
        
		if ( $settings['borderSize'] ) {
			$css .= "#{$cte_id} { border: " . absint($settings['borderSize']) . "px solid " . sanitize_hex_color($settings['borderColor']) . "; }";
		}

		if ( $settings['borderRadius'] ) {
			$css .= "#{$cte_id} { border-radius: " . absint($settings['borderRadius']) . "px; }";
		}

		if ( $settings['shadowSize'] ) {
			$css .= "#{$cte_id} { box-shadow: " . sanitize_hex_color($settings['shadowColor']) . " 0px 0px " . absint($settings['shadowSize']) . "px; }";
		}

		
		$css .= "#{$cte_id} { background-color: " . sanitize_hex_color($settings['backgroundColor']) . ";  }";
		
		$css = apply_filters( 'cte_shortcode_css', $css, $cte_id, $settings );


		if ( strlen( $settings['style'] ) ) {
			$css .= esc_html($settings['style']);
		}

		$css .= "</style>\n";

		return $css;

	}
}

new CTE_Countdown_Shortcode();