<?php

/**
 *  Helper Class for Countdown Timer Event
 */

 class CTE_Countdown_Timer_WP_Helper {
	
	/**
	 * Callback to sort tabs/fields on priority.
	 *
	 * @since 1.0.0
	 *
	 * @return bool
	 */
	public static function sort_data_by_priority( $a, $b ) {
		if ( ! isset( $a['priority'], $b['priority'] ) ) {
			return -1;
		}
		if ( $a['priority'] == $b['priority'] ) {
			return 0;
		}
		return $a['priority'] < $b['priority'] ? -1 : 1;
	}
	
}