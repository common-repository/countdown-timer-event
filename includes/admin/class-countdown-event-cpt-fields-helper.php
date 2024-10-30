<?php

/**
 *
 */
class CTE_CPT_Fields_Helper {

	public static function cte_get_tabs() {

		$general_description = '<p>' . esc_html__( 'Choose the general settings for the plugin', 'countdown-timer-event' ) . '</p>';
		$design_description = '<p>' . esc_html__( 'The settings below adjust how the Countdown Timer Event will appear on the front-end.', 'countdown-timer-event' ) . '</p>';
		
		$style_description = '<p>' . esc_html__( 'Here you can style the look of your front end', 'countdown-timer-event' ) . '</p>';
		$customizations_description = '<p>' . esc_html__( 'Use this section to add custom CSS to your Countdown Timer Event for advanced modifications.', 'countdown-timer-event' ) . '</p>';
		

		return apply_filters( 'countdown_wp_gallery_tabs', array(
			'general' => array(
				'label'       => esc_html__( 'General', 'countdown-timer-event' ),
				'title'       => esc_html__( 'General Settings', 'countdown-timer-event' ),
				'description' => $general_description,
				"icon"        => "dashicons dashicons-admin-generic",
				'priority'    => 10,
			),
			
			'design' => array(
				'label'       => esc_html__( 'Design', 'countdown-timer-event' ),
				'title'       => esc_html__( 'Design Settings', 'countdown-timer-event' ),
				'description' => $design_description,
				"icon"        => "dashicons dashicons-text",
				'priority'    => 20,
			),
			
			'style' => array(
				'label'       => esc_html__( 'Style', 'countdown-timer-event' ),
				'title'       => esc_html__( 'Style Settings', 'countdown-timer-event' ),
				'description' => $style_description,
				"icon"        => "dashicons dashicons-admin-appearance",
				'priority'    => 70,
			),
			
			'customizations' => array(
				'label'       => esc_html__( 'Custom CSS', 'countdown-timer-event' ),
				'title'       => esc_html__( 'Custom CSS', 'countdown-timer-event' ),
				'description' => $customizations_description,
				"icon"        => "dashicons dashicons-admin-tools",
				'priority'    => 90,
			),
            
		) );

	}

	

	public static function cte_get_fields( $tab ) {

		$fields = apply_filters( 'countdown_wp_gallery_fields', array(
			'general' => array(
				
				'timezone_notice' => array(
					"name" => esc_html__( '', 'countdown-timer-event' ),
					"type" => "notice",
					'priority' => 10,
				),

				'from' => array(
					"name" => esc_html__( 'From', 'countdown-timer-event' ),
					"type" => "select_from",
					"description" => esc_html__( 'Current Timer of your WordPress Timezone(Read Only)', 'countdown-timer-event' ),
					'priority' => 20,
					
				),
				'to' => array(
					"name" => esc_html__( 'Expiry Time', 'countdown-timer-event' ),
					"type" => "select_to",
					"description" => esc_html__( 'Choose the Expiry date and time', 'countdown-timer-event' ),
					'priority' => 30,
					
				),
				
				"width"          => array(
					"name"        => esc_html__( 'Countdown Width', 'countdown-timer-event' ),
					"type"        => "text",
					"description" => esc_html__( 'Width of the gallery. Can be in % or pixels', 'countdown-timer-event' ),
					'default'     => '60%',
					'priority' => 30,
				),

				"align_design" => array(
					"name"        => esc_html__( 'Align', 'countdown-timer-event' ),
					"type"        => "select",
					"description" => __( 'Select align you want to use', 'countdown-timer-event' ),
					"default" 	  => 'center',
					"values"      => array(
						'left'    => esc_html__( 'Left', 'countdown-timer-event' ),
						'center'  => esc_html__( 'Center', 'countdown-timer-event' ),
						'right'   => esc_html__( 'Right', 'countdown-timer-event' ),

					),
					'priority' => 32,
				),

			
				'font_family' => array(
					"name"        => esc_html__( 'Font Family', 'countdown-timer-event' ),
					"type"        => "select",
					"description" => esc_html__( 'Select the font family you want to use', 'countdown-timer-event' ),
					'default'     => 'Arial',
					"values"      => array(
						'Times New Roman' => esc_html__( 'Default', 'countdown-timer-event' ),
						'Arial' 		  => esc_html__( 'Arial', 'countdown-timer-event' ),
						'Arial Black'     => esc_html__( 'Arial Black', 'countdown-timer-event' ),
						'Courier New'	  => esc_html__( 'Courier New', 'countdown-timer-event' ),
						'Georgia'		  => esc_html__( 'Georgia', 'countdown-timer-event' ),
						'Grande'		  => esc_html__( 'Grande', 'countdown-timer-event' ),
						'Helvetica'		  => esc_html__( 'Helvetica Neue', 'countdown-timer-event' ),
						'Impact' 		  => esc_html__( 'Impact', 'countdown-timer-event' ),
						'Lucida' 		  => esc_html__( 'Lucida', 'countdown-timer-event' ),
						'Lucida Grande'   => esc_html__( 'Lucida Grande', 'countdown-timer-event' ),
						'Open Sans'       => esc_html__( 'Open Sans', 'countdown-timer-event' ),
						'OpenSansBold'    => esc_html__( 'OpenSansBold', 'countdown-timer-event' ),
						'Palatino Linotype' => esc_html__( 'Palatino', 'countdown-timer-event' ),
						'Sans' 			  => esc_html__( 'Sans', 'countdown-timer-event' ),
						'sans-serif'	  => esc_html__( 'Sans-serif', 'countdown-timer-event' ),
						'Tahoma'          => esc_html__( 'Tahoma', 'countdown-timer-event' ),
						'Trebuchet'		  => esc_html__( 'Trebuchet', 'countdown-timer-event' ),
						'Verdana' 		  => esc_html__( 'Verdana', 'countdown-timer-event' ),
					),
					'priority' => 35,

				),

				"link"          => array(
					"name"        => esc_html__( 'Link After Timout', 'countdown-timer-event' ),
					"type"        => "text",
					"description" => esc_html__( 'Redirect Link After Timeout(default is #)', 'countdown-timer-event' ),
					'default'     => '#',
					'priority' => 38,
				),

				"margin"         => array(
					"name"        => esc_html__( 'Margin', 'countdown-timer-event' ),
					"type"        => "ui-slider",
					"description" => esc_html__( 'Margin in the Countdown Timer Layout', 'countdown-timer-event' ),
					"min"         => 0,
					"max"         => 100,
					"step"        => 1,
					"default"     => 40,
					'priority'    => 40,
				),
				
			),


			'design' => array(
				'type'          => array(
					"name"        => esc_html__( 'Select Design', 'countdown-timer-event' ),
					"type"        => "select",
					"description" => esc_html__( 'Select design you want to use', 'countdown-timer-event' ),
					'default'     => 'design-1',
					"values"      => array(
						'design-1'       => esc_html__( 'Design 1', 'countdown-timer-event' ),
						'design-2'       => esc_html__( 'Design 2', 'countdown-timer-event' ),
					),
					'priority' => 5,
				),

				"time_separator" => array(
					"name"        => esc_html__( 'Time Separator', 'countdown-timer-event' ),
					"type"        => "select",
					"description" => __( 'Select time separator', 'countdown-timer-event' ),
					"default" 	  => ':',
					"values"      => array(
						' '     => esc_html__( 'None', 'countdown-timer-event' ),
						':'     => esc_html__( 'Colon(:)', 'countdown-timer-event' ),
						'.' 	=> esc_html__( 'Dot(.)', 'countdown-timer-event' ),
						',' 	=> esc_html__( 'Comma(,)', 'countdown-timer-event' ),

					),
					'priority' => 10,
				),

				"backgroundColor"      => array(
					"name"        => esc_html__( 'Background Color', 'countdown-timer-event' ),
					"type"        => "color",
					"description" => esc_html__( 'Set the color of Background', 'countdown-timer-event' ),
					"default"     => "#ffffff",
					'priority'    => 15,
				),
				
				"message"          => array(
					"name"        => esc_html__( 'Countdown Message', 'countdown-timer-event' ),
					"type"        => "text",
					"description" => esc_html__( 'Type message for countdown', 'countdown-timer-event' ),
					'default'     => 'Hurry Up! Offer ends in',
					'priority' => 20,
				),
				"msgFontSize"    => array(
					"name"        => esc_html__( 'Message Font Size', 'countdown-timer-event' ),
					"type"        => "ui-slider",
					"min"         => 0,
					"max"         => 50,
					"default"     => 25,
					"description" => esc_html__( 'The Message font size in pixels', 'countdown-timer-event' ),
					'priority'    => 25,
				),	
				"msgColor"      => array(
					"name"        => esc_html__( 'Message Color', 'countdown-timer-event' ),
					"type"        => "color",
					"description" => esc_html__( 'Set the color of Message', 'countdown-timer-event' ),
					"default"     => "#000000",
					'priority'    => 30,
				),

				"countdownFontSize"    => array(
					"name"        => esc_html__( 'Countdown Font Size', 'countdown-timer-event' ),
					"type"        => "ui-slider",
					"min"         => 0,
					"max"         => 100,
					"default"     => 32,
					"description" => esc_html__( 'The title font size in pixels', 'countdown-timer-event' ),
					'priority'    => 35,
				),

				"countdownColor"     => array(
					"name"        => esc_html__( 'Countdown Color', 'countdown-timer-event' ),
					"type"        => "color",
					"description" => esc_html__( 'Set the color of captions', 'countdown-timer-event' ),
					"default"     => "#000000",
					'priority'    => 40,
				),

				"countdownUnitFontSize"    => array(
					"name"        => esc_html__( 'Countdown Unit Font Size', 'countdown-timer-event' ),
					"type"        => "ui-slider",
					"min"         => 0,
					"max"         => 60,
					"default"     => 25,
					"description" => esc_html__( 'The title font size in pixels', 'countdown-timer-event' ),
					'priority'    => 45,
				),

				"countdownUnitColor"     => array(
					"name"        => esc_html__( 'Countdown Unit Color', 'countdown-timer-event' ),
					"type"        => "color",
					"description" => esc_html__( 'Set the color of captions', 'countdown-timer-event' ),
					"default"     => "#000000",
					'priority'    => 50,
				),

				"innerBorderSize"   => array(
					"name"        => esc_html__( 'Inner Border Size', 'countdown-timer-event' ),
					"type"        => "ui-slider",
					"description" => esc_html__( 'Set the inner border size for countdown timer', 'countdown-timer-event' ),
					"min"         => 0,
					"max"         => 10,
					"default"     => 0,
					'priority'    => 55,
				),
				"innerBorderRadius" => array(
					"name"        => esc_html__( 'Inner Border Radius', 'countdown-timer-event' ),
					"type"        => "ui-slider",
					"description" => esc_html__( 'Set the inner border radius for countdown timer', 'countdown-timer-event' ),
					"min"         => 0,
					"max"         => 100,
					"default"     => 0,
					'priority'    =>60,
				),
				"innerPadding"   => array(
					"name"        => esc_html__( 'Inner Padding', 'countdown-timer-event' ),
					"type"        => "ui-slider",
					"description" => esc_html__( 'Set the inner padding for countdown timer', 'countdown-timer-event' ),
					"min"         => 0,
					"max"         => 50,
					"default"     => 0,
					'priority'    => 65,
				),
				"innerBorderColor"  => array(
					"name"        => esc_html__( 'Inner Border Color', 'countdown-timer-event' ),
					"type"        => "color",
					"description" => esc_html__( 'Set the inner border color for countdown timer', 'countdown-timer-event' ),
					"default"     => "#ffffff",
					'priority'    => 70,
				),
				"innerBgColor"  => array(
					"name"        => esc_html__( 'Inner Backgroud Color', 'countdown-timer-event' ),
					"type"        => "color",
					"description" => esc_html__( 'Set the inner background color for countdown timer', 'countdown-timer-event' ),
					"default"     => "#ffffff",
					'priority'    => 75,
				),

				"circleWidth"   => array(
					"name"        => esc_html__( 'Circle Width', 'countdown-timer-event' ),
					"type"        => "ui-slider",
					"description" => esc_html__( 'Set the Circle Width', 'countdown-timer-event' ),
					"min"         => 0,
					"max"         => 100,
					"default"     => 10,
					'priority'    => 80,
				),

				"circleBgColor"  => array(
					"name"        => esc_html__( 'Circle Backgroud Color', 'countdown-timer-event' ),
					"type"        => "color",
					"description" => esc_html__( 'Set the circle background color for countdown timer', 'countdown-timer-event' ),
					"default"     => "#66c5af",
					'priority'    => 85,
				),

				"circleFgColor"  => array(
					"name"        => esc_html__( 'Circle Foregroud Color', 'countdown-timer-event' ),
					"type"        => "color",
					"description" => esc_html__( 'Set the circle foreground color for countdown timer', 'countdown-timer-event' ),
					"default"     => "#cdd3d2",
					'priority'    => 90,
				),

				"hide_days"        => array(
					"name"        => esc_html__( 'Hide Days', 'countdown-timer-event' ),
					"type"        => "toggle",
					"default"     => 0,
					"description" => esc_html__( 'Hide Days section from front', 'countdown-timer-event' ),
					'priority'    => 95,
				),

				"hide_hours"        => array(
					"name"        => esc_html__( 'Hide Hours', 'countdown-timer-event' ),
					"type"        => "toggle",
					"default"     => 0,
					"description" => esc_html__( 'Hide Hours section from front', 'countdown-timer-event' ),
					'priority'    => 100,
				),		
				
				"hide_minutes"        => array(
					"name"        => esc_html__( 'Hide Minutes', 'countdown-timer-event' ),
					"type"        => "toggle",
					"default"     => 0,
					"description" => esc_html__( 'Hide Minutes section from front', 'countdown-timer-event' ),
					'priority'    => 105,
				),

				"hide_message"        => array(
					"name"        => esc_html__( 'Hide Message', 'countdown-timer-event' ),
					"type"        => "toggle",
					"default"     => 0,
					"description" => esc_html__( 'Hide Message from front', 'countdown-timer-event' ),
					'priority'    => 110,
				),
				
			),
			
			'style' => array(
				"borderSize"   => array(
					"name"        => esc_html__( 'Border Size', 'countdown-timer-event' ),
					"type"        => "ui-slider",
					"description" => esc_html__( 'Set the border size for countdown timer', 'countdown-timer-event' ),
					"min"         => 0,
					"max"         => 10,
					"default"     => 0,
					'priority'    => 10,
				),
				"borderRadius" => array(
					"name"        => esc_html__( 'Border Radius', 'countdown-timer-event' ),
					"type"        => "ui-slider",
					"description" => esc_html__( 'Set the border radius for countdown timer', 'countdown-timer-event' ),
					"min"         => 0,
					"max"         => 100,
					"default"     => 0,
					'priority'    => 20,
				),
				"borderColor"  => array(
					"name"        => esc_html__( 'Border Color', 'countdown-timer-event' ),
					"type"        => "color",
					"description" => esc_html__( 'Set the border color for countdown timer', 'countdown-timer-event' ),
					"default"     => "#ffffff",
					'priority'    => 30,
				),
				"shadowSize"   => array(
					"name"        => esc_html__( 'Shadow Size', 'countdown-timer-event' ),
					"type"        => "ui-slider",
					"description" => esc_html__( 'Set the shadow size for countdown timer', 'countdown-timer-event' ),
					"min"         => 0,
					"max"         => 20,
					"default"     => 0,
					'priority'    => 40,
				),
				"shadowColor"  => array(
					"name"        => esc_html__( 'Shadow Color', 'countdown-timer-event' ),
					"type"        => "color",
					"description" => esc_html__( 'Set the shadow color for countdown timer', 'countdown-timer-event' ),
					"default"     => "#ffffff",
					'priority'    => 50,
				),
			),
			
			'customizations' => array(
				"style"  => array(
					"name"        => esc_html__( 'Custom CSS', 'countdown-timer-event' ),
					"type"        => "custom_code",
					"syntax"      => 'css',
					"description" => '<strong>' . esc_html__( 'Just write the code without using the &lt;style&gt;&lt;/style&gt; tags', 'countdown-timer-event' ) . '</strong>',
					'priority' => 20,
				),
			),
		) );


		if ( 'all' == $tab ) {
			return $fields;
		}

		if ( isset( $fields[ $tab ] ) ) {
			return $fields[ $tab ];
		} else {
			return array();
		}

	}

	public static function cte_get_defaults() {
		return apply_filters( 'countdown_wp_lite_default_settings', array(
            'from' 						=> '',
            'to'						=> '',
            'width'                     => '60%',
            'align_design'				=> 'center',
            'font_family'				=> 'Arial',
            'link' 						=> '#',
            'time_separator'			=> ':',
            'backgroundColor'			=> '#ffffff',
            'margin'                    => '40',
            'type' 						=> 'design-1',
            'message' 					=> 'Hurry Up! Offer ends in',
            'msgFontSize'				=> '25',
            'msgColor'					=> '#000000',
            'countdownUnitFontSize' 	=> '25',
            'countdownUnitColor'		=> '#000000',
            'innerBorderSize'			=> '0',
            'innerBorderRadius'			=> '0',
            'innerPadding'				=> '0',
            'innerBorderColor'          => '#ffffff',
            'innerBgColor'          => '#ffffff',

           
            'countdownFontSize'			=> '32',
            'countdownColor' 			=> '#000000',
            'hide_message' 				=> 0,
            
            'circleWidth'				=> 10,
            'circleBgColor'				=> '#66c5af',
            'circleFgColor'				=> '#cdd3d2',
            'hide_days'					=> 0,
            'hide_hours'				=> 0,
            'hide_minutes'				=> 0,
            'borderRadius'              => '0',
            'borderColor'               => '#ffffff',
            'borderSize'                => '0',
            'shadowColor'               => '#ffffff',
            'shadowSize'                => 0,
            'script'                    => '',
            'style'                     => '',
          ) );
	}

}
