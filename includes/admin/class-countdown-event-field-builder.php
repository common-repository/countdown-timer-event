<?php

/**
 * 
 */
class CTE_Field_Builder {

	
	/**
	 * Get an instance of the field builder
	 */
	public static function cte_get_instance() {
		static $inst;
		if ( ! $inst ) {
			$inst = new CTE_Field_Builder();
		}
		return $inst;
	}

	public function cte_get_id(){
		global $id, $post;

        // Get the current post ID. If ajax, grab it from the $_POST variable.
        if ( defined( 'DOING_AJAX' ) && DOING_AJAX && array_key_exists( 'post_id', $_POST ) ) {
            $post_id = absint( $_POST['post_id'] );
        } else {
            $post_id = isset( $post->ID ) ? $post->ID : (int) $id;
        }

        return $post_id;
	}

	/**
     * Helper method for retrieving settings values.
     *
     * @since 1.0.0
     *
     * @global int $id        The current post ID.
     * @global object $post   The current post object.
     * @param string $key     The setting key to retrieve.
     * @param string $default A default value to use.
     * @return string         Key value on success, empty string on failure.
     */
    public function cte_get_setting( $key, $default = false ) {

        // Get config
        $settings = get_post_meta( $this->cte_get_id(), 'cte-countdown-timer-settings', true );

        // Check config key exists
        if ( isset( $settings[ $key ] ) ) {
            return $settings[ $key ];
        } else {
            return $default ? $default : '';
        }

    }

	public function cte_render( $metabox, $post = false ) {

		switch ( $metabox ) {
			
			case 'settings':
				$this->cte_render_settings_metabox();
				break;
			case 'shortcode':
				$this->cte_render_shortcode_metabox( $post );
				break;
			default:
				do_action( "countdown_wp_metabox_fields_{$metabox}" );
				break;
		}

	}

	

	/* Create HMTL for settings metabox */
	private function cte_render_settings_metabox() {
		$tabs = CTE_CPT_Fields_Helper::cte_get_tabs();

		// Sort tabs based on priority.
		uasort( $tabs, array( 'CTE_Countdown_Timer_WP_Helper', 'sort_data_by_priority' ) );

		$tabs_html = '';
		$tabs_content_html = '';
		$first = true;

		// Generate HTML for each tab.
		foreach ( $tabs as $tab_id => $tab ) {
			$tab['id'] = $tab_id;
			$tabs_html .= $this->cte_render_tab( $tab, $first );

			$fields = CTE_CPT_Fields_Helper::cte_get_fields( $tab_id );
			// Sort fields based on priority.
			uasort( $fields, array( 'CTE_Countdown_Timer_WP_Helper', 'sort_data_by_priority' ) );

			$current_tab_content = '<div id="countdown-wp-' . esc_attr( $tab['id'] ) . '" class="' . ( $first ? 'active-tab' : '' ) . '">';

			// Check if our tab have title & description
			if ( isset( $tab['title'] ) || isset( $tab['description'] ) ) {
				$current_tab_content .= '<div class="tab-content-header">';
				$current_tab_content .= '<div class="tab-content-header-title">';
				if ( isset( $tab['title'] ) && '' != $tab['title'] ) {
					$current_tab_content .= '<h2>' . esc_html( $tab['title'] ) . '</h2>';
				}
				if ( isset( $tab['description'] ) && '' != $tab['description'] ) {
					$current_tab_content .= '<div class="tab-header-tooltip-container countdown-wp-tooltip"><span><i class="fa fa-lightbulb"></i></span>';
					$current_tab_content .= '<div class="tab-header-description countdown-wp-tooltip-content">' . wp_kses_post( $tab['description'] ) . '</div>';
					$current_tab_content .= '</div>';
				}
				$current_tab_content .= '</div>';
				$current_tab_content .= '</div>';
			}

			// Generate all fields for current tab
			$current_tab_content .= '<div class="form-table-wrapper">';
			$current_tab_content .= '<table class="form-table"><tbody>';
			foreach ( $fields as $field_id => $field ) {
				$field['id'] = $field_id;
				$current_tab_content .= $this->cte_render_row( $field );
			}
			$current_tab_content .= '</tbody></table>';
			// Filter to add extra content to a specific tab
			$current_tab_content .= apply_filters( 'countdown_wp_' . $tab_id . '_tab_content', '' );
			$current_tab_content .= '</div>';
			$current_tab_content .= '</div>';
			$tabs_content_html .= $current_tab_content;

			if ( $first ) {
				$first = false;
			}

		}

		$html = '<div class="countdown-timer-settings-container"><div class="countdown-wp-tabs">%s</div><div class="countdown-wp-tabs-content">%s</div>';
		printf( $html, $tabs_html, $tabs_content_html );
	}

	/* Create HMTL for shortcode metabox */
	private function cte_render_shortcode_metabox( $post ) {
		$shortcode = '[countdown_timer id="' . $post->ID . '"]';
		echo '<input type="text" style="width:100%;" value="' . esc_attr( $shortcode ) . '"  onclick="select()" readonly>';
		// Add Copy Shortcode button
        echo '<a href="#" id="copy-countdown-wp-shortcode" class="button button-primary" style="margin-top:10px;">'.esc_html__('Copy shortcode','countdown-timer-event').'</a><span style="margin-left:15px;"></span>';
     }

	/* Create HMTL for a tab */
	private function cte_render_tab( $tab, $first = false ) {
		$icon = '';
		$badge = '';

		if ( isset( $tab['icon'] ) ) {
			$icon = '<i class="' . esc_attr( $tab['icon'] ) . '"></i>';
		}

		if ( isset( $tab['badge'] ) ) {
			$badge = '<sup>' . esc_html( $tab['badge'] ) . '</sup>';
		}
		return '<div class="countdown-wp-tab' . ( $first ? ' active-tab' : '' ) . ' countdown-wp-' . esc_attr( $tab['id'] ) . '" data-tab="countdown-wp-' . esc_attr( $tab['id'] ) . '">' . $icon . wp_kses_post( $tab['label'] ) . $badge . '</div>';
	}

	/* Create HMTL for a row */
	private function cte_render_row( $field ) {
		$format = '<tr data-container="' . esc_attr( $field['id'] ) . '"><th scope="row"><label>%s</label>%s</th><td>%s</td></tr>';

		if ( 'textarea' == $field['type'] || 'custom_code' == $field['type'] ) {
			$format = '<tr data-container="' . esc_attr( $field['id'] ) . '"><td colspan="2"><label class="th-label">%s</label>%s<div>%s</div></td></tr>';
		}

		$format = apply_filters( "countdown_wp_field_type_{$field['type']}_format", $format, $field );

		$default = '';

		// Check if our field have a default value
		if ( isset( $field['default'] ) ) {
			$default = $field['default'];
		}

		// Generate tooltip
		$tooltip = '';
		if ( isset( $field['description'] ) && '' != $field['description'] ) {
			$tooltip .= '<div class="countdown-wp-tooltip"><span><i class="fa fa-lightbulb"></span>';
			$tooltip .= '<div class="countdown-wp-tooltip-content">' . wp_kses_post( $field['description'] ) . '</div>';
			$tooltip .= '</div>';
		}

		// Get the current value of the field
		$value = $this->cte_get_setting( $field['id'], $default );
		return sprintf( $format, wp_kses_post( $field['name'] ), $tooltip, $this->cte_render_field( $field, $value ) );
	}

	/* Create HMTL for a field */
	private function cte_render_field( $field, $value = '' ) {
		$html = '';

		
		/*======================================================*/
		global $post;
		// get timezon from WP settings
		$current_offset = get_option('gmt_offset');
		$tzstring 		= get_option('timezone_string');

		// Remove old Etc mappings. Fallback to gmt_offset.
		if ( false !== strpos($tzstring,'Etc/GMT') ){
			$tzstring = '';
		}

		if ( empty($tzstring) ) { // Create a UTC+- zone if no timezone string exists
			if ( 0 == $current_offset ) {
				$tzstring = 'UTC+0';
			} elseif ($current_offset < 0) {
				$tzstring = 'UTC' . $current_offset;
			} else {
				$tzstring = 'UTC+' . $current_offset;
			}
		}

		// Getting saved values
		$date 	= get_post_meta( $post->ID, 'timer_date', true );
		$date 	= ($date != '') ? $date : current_time('Y-m-d\TH:i:s');
		$endTime = date('Y-m-d\TH:i:s',strtotime('+1 hour',strtotime($date)));
		
		/*==========================================================*/
		
		switch ( $field['type'] ) {

			case 'notice':
				
 				ob_start();
				?>

				<div class='countdown-notice'>
					<?php echo sprintf( __('Countdown Timer Event works with your own WordPress Timezone which can be set from <a href="%s" target="_blank">General Setting</a> Page.', 'cte_countdown_timer'), admin_url('options-general.php') ); ?> <br>
					<?php echo __('Your Current timezone is', 'cte-countdown-timer') .' : '. $tzstring; ?>
				</div>

				<?php  			
				$html = ob_get_clean();
				
			break;

			case 'select_from': 
				
				$html = '<input type="datetime-local" id="" name="cte-countdown-timer-settings[' . esc_attr( $field['id'] ) . ']" data-setting="' . esc_attr( $field['id'] ) . '" value="' . esc_attr( $date ) . '" readonly style="max-width:40%;"> ';
			break;
			
			case 'select_to':
				$current_time = current_time('Y-m-d\TH:i');
				$html = '<input type="datetime-local" name="cte-countdown-timer-settings[' . esc_attr( $field['id'] ) . ']" data-setting="' . esc_attr( $field['id'] ) .  '" style="max-width:40%;" value="' . esc_attr( $value ) . '"  min="' . esc_attr( $current_time ) . '" required>';
			break;
			
			case 'text':
				$html = '<input type="text" class="regular-text" name="cte-countdown-timer-settings[' . esc_attr( $field['id'] ) . ']" data-setting="' . esc_attr( $field['id'] ) . '" style="max-width:33%;" value="' . esc_attr( $value ) . '">';
				break;
			case 'select' :
				$html = '<select name="cte-countdown-timer-settings[' . esc_attr( $field['id'] ) . ']" data-setting="' . esc_attr( $field['id'] ) . '" style="max-width:33%;" class="regular-text">';
				foreach ( $field['values'] as $key => $option ) {
					if ( is_array( $option ) ) {
						$html .= '<optgroup label="' . esc_attr( $key ) . '">';
						foreach ( $option as $key_subvalue => $subvalue ) {
							$html .= '<option value="' . esc_attr( $key_subvalue ) . '" ' . selected( $key_subvalue, $value, false ) . '>' . esc_html( $subvalue ) . '</option>';
						}
						$html .= '</optgroup>';
					}else{
						$html .= '<option value="' . esc_attr( $key ) . '" ' . selected( $key, $value, false ) . '>' . esc_html( $option ) . '</option>';
					}
				}
				if ( isset( $field['disabled'] ) && is_array( $field['disabled'] ) ) {
					$html .= '<optgroup label="' . esc_attr( $field['disabled']['title'] ) . '">';
					foreach ( $field['disabled']['values'] as $key => $disabled ) {
						$html .= '<option value="' . esc_attr( $key ) . '" disabled >' . esc_html( $disabled ) . '</option>';
					}
					$html .= '</optgroup>';
				}
				$html .= '</select>';
				break;
			case 'ui-slider':
				$min  = isset( $field['min'] ) ? $field['min'] : 0;
				$max  = isset( $field['max'] ) ? $field['max'] : 100;
				$step = isset( $field['step'] ) ? $field['step'] : 1;
				if ( '' === $value ) {
					if ( isset( $field['default'] ) ) {
						$value = $field['default'];
					}else{
						$value = $min;
					}
				}
				$attributes = 'data-min="' . esc_attr( $min ) . '" data-max="' . esc_attr( $max ) . '" data-step="' . esc_attr( $step ) . '"';
				$html .= '<div class="col-sm-4 slider-container countdown-wp-ui-slider-container">';
					$html .= '<input readonly="readonly" data-setting="' . esc_attr( $field['id'] ) . '"  name="cte-countdown-timer-settings[' . esc_attr( $field['id'] ) . ']" type="text" class="rl-slider countdown-wp-ui-slider-input" id="input_' . esc_attr( $field['id'] ) . '" value="' . $value . '" ' . $attributes . '/>';
					$html .= '<div id="slider_' . esc_attr( $field['id'] ) . '" class="ss-slider countdown-wp-ui-slider"></div>';
				$html .= '</div>';
				break;
			case 'color' :
				$html .= '<div class="countdown-wp-colorpickers">';
				$html .= '<input id="' . esc_attr( $field['id'] ) . '" class="countdown-wp-color" data-setting="' . esc_attr( $field['id'] ) . '" name="cte-countdown-timer-settings[' . esc_attr( $field['id'] ) . ']" value="' . esc_attr( $value ) . '">';
				$html .= '</div>';
				break;
			case "toggle":
				$html .= '<div class="countdown-wp-toggle">';
					$html .= '<input class="countdown-wp-toggle__input" type="checkbox" data-setting="' . esc_attr( $field['id'] ) . '" id="' . esc_attr( $field['id'] ) . '" name="cte-countdown-timer-settings[' . esc_attr( $field['id'] ) . ']" value="1" ' . checked( 1, $value, false ) . '>';
					$html .= '<div class="countdown-wp-toggle__items">';
						$html .= '<span class="countdown-wp-toggle__track"></span>';
						$html .= '<span class="countdown-wp-toggle__thumb"></span>';
						$html .= '<svg class="countdown-wp-toggle__off" width="6" height="6" aria-hidden="true" role="img" focusable="false" viewBox="0 0 6 6"><path d="M3 1.5c.8 0 1.5.7 1.5 1.5S3.8 4.5 3 4.5 1.5 3.8 1.5 3 2.2 1.5 3 1.5M3 0C1.3 0 0 1.3 0 3s1.3 3 3 3 3-1.3 3-3-1.3-3-3-3z"></path></svg>';
						$html .= '<svg class="countdown-wp-toggle__on" width="2" height="6" aria-hidden="true" role="img" focusable="false" viewBox="0 0 2 6"><path d="M0 0h2v6H0z"></path></svg>';
					$html .= '</div>';
				$html .= '</div>';
				break;
			case "custom_code":
				$html = '<div class="countdown-wp-code-editor" data-syntax="' . esc_attr( $field['syntax'] ) . '">';
				$html .= '<textarea data-setting="' . esc_attr( $field['id'] ) . '" name="cte-countdown-timer-settings[' . esc_attr( $field['id'] ) . ']" id="countdown-wp-' . esc_attr( $field['id'] ) . '" class="large-text code"  rows="10" cols="50">' . wp_kses_post($value) . '</textarea>';
				$html .= '</div>';
				break;
			
			default:
				/* Filter for render custom field types */
				$html = apply_filters( "countdown_wp_render_{$field['type']}_field_type", $html, $field, $value );
				break;
		}

		return $html;

	}


}