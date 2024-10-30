<?php
/**
 * The cpt plugin class.
 *
 * This is used to define the custom post type that will be used for Countdown Timer Event
 *
 * @since      1.0.0
 */
class CTE_Countdown_WP_CPT {
    
	private $labels    = array();
	private $args      = array();
	private $metaboxes = array();
	private $cpt_name;
    private $builder;
    
    
	public function __construct() {

        $this->labels = apply_filters('cte_countdown_wp_cpt_labels', array(
            'singular_name'         => esc_html__( 'Countdown Timer', 'countdown-timer-event' ),
			'menu_name'             => esc_html__( 'Countdown Timer', 'countdown-timer-event' ),
			'name_admin_bar'        => esc_html__( 'Countdown Timer', 'countdown-timer-event' ),
			'archives'              => esc_html__( 'Item Archives', 'countdown-timer-event' ),
			'attributes'            => esc_html__( 'Item Attributes', 'countdown-timer-event' ),
			'parent_item_colon'     => esc_html__( 'Parent Item:', 'countdown-timer-event' ),
			'all_items'             => esc_html__( 'Countdown Timers', 'countdown-timer-event' ),
			'add_new_item'          => esc_html__( 'Add New Item', 'countdown-timer-event' ),
			'add_new'               => esc_html__( 'Add New', 'countdown-timer-event' ),
			'new_item'              => esc_html__( 'New Item', 'countdown-timer-event' ),
			'edit_item'             => esc_html__( 'Edit Item', 'countdown-timer-event' ),
			'update_item'           => esc_html__( 'Update Item', 'countdown-timer-event' ),
			'view_item'             => esc_html__( 'View Item', 'countdown-timer-event' ),
			'view_items'            => esc_html__( 'View Items', 'countdown-timer-event' ),
			'search_items'          => esc_html__( 'Search Item', 'countdown-timer-event' ),
			'not_found'             => esc_html__( 'Not found', 'countdown-timer-event' ),
			'not_found_in_trash'    => esc_html__( 'Not found in Trash', 'countdown-timer-event' ),
			'featured_image'        => esc_html__( 'Featured Image', 'countdown-timer-event' ),
			'set_featured_image'    => esc_html__( 'Set featured image', 'countdown-timer-event' ),
			'remove_featured_image' => esc_html__( 'Remove featured image', 'countdown-timer-event' ),
			'use_featured_image'    => esc_html__( 'Use as featured image', 'countdown-timer-event' ),
			'insert_into_item'      => esc_html__( 'Insert into item', 'countdown-timer-event' ),
			'uploaded_to_this_item' => esc_html__( 'Uploaded to this item', 'countdown-timer-event' ),
			'items_list'            => esc_html__( 'Items list', 'countdown-timer-event' ),
			'items_list_navigation' => esc_html__( 'Items list navigation', 'countdown-timer-event' ),
			'filter_items_list'     => esc_html__( 'Filter items list', 'countdown-timer-event' ),
        ));

        $this->args = apply_filters( 'cte_countdown_wp_cpt_args', array(
			'label'                 => esc_html__( 'Countdown Timer', 'countdown-timer-event' ),
			'description'           => esc_html__( 'Countdown Post Type Description.', 'countdown-timer-event' ),
			'supports'              => array( 'title' ),
			'public'                => false,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 5,
			'menu_icon'             => CTE_COUNTDOWN_TIMER_EVENT_IMAGES . 'countdown.png',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => false,
			'can_export'            => true,
			'has_archive'           => false,
			'exclude_from_search'   => true,
			'rewrite'               => false,
			'show_in_rest'          => true,
        ) );
        
        $this->metaboxes = apply_filters( 'cte_countdown_wp_cpt_metaboxes', array(
			'cte-countdown-timer-settings' => array(
				'title' => esc_html__( 'Settings', 'countdown-timer-event' ),
				'callback' => 'cte_output_gallery_settings',
				'context' => 'normal',
			),
			'cte_countdown-wp-shortcode' => array(
				'title' => esc_html__( 'Shortcode', 'countdown-timer-event' ),
				'callback' => 'cte_output_countdown_shortcode',
				'context' => 'side',
			),
        ) );
        
		$this->cpt_name = apply_filters( 'cte_countdown_wp_cpt_name', 'cte_countdown_timer' );

        add_action( 'init', array( $this, 'cte_register_cpt' ) );

        /* Fire our meta box setup function on the post editor screen. */
		add_action( 'load-post.php', array( $this, 'cte_meta_boxes_setup' ) );
        add_action( 'load-post-new.php', array( $this, 'cte_meta_boxes_setup' ) );
        
        
		// Post Table Columns
		add_filter( "manage_{$this->cpt_name}_posts_columns", array( $this, 'cte_add_columns' ) );
		add_action( "manage_{$this->cpt_name}_posts_custom_column" , array( $this, 'cte_output_column' ), 10, 2 );

		/* Load Fields Helper */
		require_once CTE_COUNTDOWN_TIMER_EVENT_ADMIN . 'class-countdown-event-cpt-fields-helper.php';

		/* Load Builder */
		require_once CTE_COUNTDOWN_TIMER_EVENT_ADMIN . 'class-countdown-event-field-builder.php';
		$this->builder = CTE_Field_Builder::cte_get_instance();

    }
    
	public function cte_register_cpt() {

		$args = $this->args;
		$args['labels'] = $this->labels;
		register_post_type( $this->cpt_name, $args );

    }
    public function cte_meta_boxes_setup() {
		/* Add meta boxes on the 'add_meta_boxes' hook. */
  		add_action( 'add_meta_boxes', array( $this, 'cte_add_meta_boxes' ) );
  		/* Save post meta on the 'save_post' hook. */
		add_action( 'save_post', array( $this, 'cte_save_meta_boxes' ), 10, 2 );
    }
    
    
	public function cte_add_meta_boxes() {

		global $post;

		foreach ( $this->metaboxes as $metabox_id => $metabox ) {
            
            if ( 'cte_countdown-wp-shortcode' == $metabox_id && 'auto-draft' == $post->post_status ) {
				break;
			}
            
			add_meta_box(
                $metabox_id,      // Unique ID
			    $metabox['title'],    // Title
			    array( $this, $metabox['callback'] ),   // Callback function
			    'cte_countdown_timer',         // Admin page (or post type)
			    $metabox['context'],         // Context
			    'high'         // Priority
			);
		}

    }
    
    
	public function cte_output_gallery_settings() {
        $this->builder->cte_render( 'settings' );
    }

	public function cte_output_countdown_shortcode( $post ) {
		$this->builder->cte_render( 'shortcode', $post );
	}

    
	public function cte_save_meta_boxes( $post_id, $post ) {

		/* Get the post type object. */
		$post_type = get_post_type_object( $post->post_type );

		/* Check if the current user has permission to edit the post. */
		if ( !current_user_can( $post_type->cap->edit_post, $post_id ) || 'cte_countdown_timer' != $post_type->name ) {
			return $post_id;
		}


		if ( isset( $_POST['cte-countdown-timer-settings'] ) ) {

			$fields_with_tabs = CTE_CPT_Fields_Helper::cte_get_fields( 'all' );

			// Here we will save all our settings
			$countdown_timer_event_settings = array();

			// We will save only our settings.
			foreach ( $fields_with_tabs as $tab => $fields ) {

				// We will iterate throught all fields of current tab
				foreach ( $fields as $field_id => $field ) {

					if ( isset( $_POST['cte-countdown-timer-settings'][ $field_id ] ) ) {

						

						switch ( $field_id ) {
							
							case 'shadowSize':
								$countdown_timer_event_settings[ $field_id ] = absint( $_POST['cte-countdown-timer-settings'][ $field_id ] );
								break;
							case 'shadowColor':
								$countdown_timer_event_settings[ $field_id ] = sanitize_hex_color( $_POST['cte-countdown-timer-settings'][ $field_id ] );
								break;
							default:
								if( is_array( $_POST['cte-countdown-timer-settings'][ $field_id ] ) ){
									$sanitized = array_map( 'sanitize_text_field', $_POST['cte-countdown-timer-settings'][ $field_id ] );
									$countdown_timer_event_settings[ $field_id ] = apply_filters( 'countdown_wp_settings_field_sanitization', $sanitized, $_POST['cte-countdown-timer-settings'][ $field_id ] ,$field_id, $field );
								}else{
									$countdown_timer_event_settings[ $field_id ] = apply_filters( 'countdown_wp_settings_field_sanitization', sanitize_text_field( $_POST['cte-countdown-timer-settings'][ $field_id ] ), $_POST['cte-countdown-timer-settings'][ $field_id ] ,$field_id, $field );
								}

								break;
						}

					}else{
						if ( 'toggle' == $field['type'] ) {
							$countdown_timer_event_settings[ $field_id ] = '0';
						}else{
							$countdown_timer_event_settings[ $field_id ] = '';
						}
					}

				}

			}

			update_post_meta( $post_id, 'cte-countdown-timer-settings', $countdown_timer_event_settings );

		}

	}

    

    public function cte_add_columns( $columns ){

		$date = $columns['date'];
		unset( $columns['date'] );
		$columns['shortcode'] = esc_html__( 'Shortcode', 'countdown-timer-event' );
		$columns['date'] = $date;
		return $columns;

	}

	
	public function cte_output_column( $column, $post_id ){

		if ( 'shortcode' == $column ) {
			$shortcode = '[countdown_timer id="' . $post_id . '"]';
			echo '<input type="text" value="' . esc_attr( $shortcode ) . '"  onclick="select()" readonly style="width:35%;">';
           /*echo '<a href="#" class="copy-countdown-wp-shortcode button button-primary" style="margin-left:15px;">'.esc_html__('Copy Shortcode','countdown-timer-event').'</a><span style="margin-left:15px;"></span>';*/
		}

	}

}

