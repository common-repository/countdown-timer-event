<?php

if ( ! class_exists( 'Gamajo_Template_Loader' ) ) {
  require CTE_COUNTDOWN_TIMER_EVENT_LIBRARIES . 'class-gamajo-template-loader.php';
}

/**
 *
 * Template loader for Countdown Timer Event.
 *
 * Only need to specify class properties here.
 *
 */
class CTE_Countdown_Template_Loader extends Gamajo_Template_Loader {

  /**
   * Prefix for filter names.
   *
   * @since 1.0.0
   *
   * @var string
   */
  protected $filter_prefix = 'cte_countdown_timer';

  /**
   * Directory name where custom templates for this plugin should be found in the theme.
   *
   * @since 1.0.0
   *
   * @var string
   */
  protected $theme_template_directory = 'countdown-timer-event';

  /**
   * Reference to the root directory path of this plugin.
   *
   * Can either be a defined constant, or a relative reference from where the subclass lives.
   *
   * In this case, `PORTFOLIO_PATH` would be defined in the root plugin file as:
   *
   * @since 1.0.0
   *
   * @var string
   */
  protected $plugin_directory = CTE_COUNTDOWN_TIMER_EVENT_DIR;

  /**
   * Directory name where templates are found in this plugin.
   *
   * Can either be a defined constant, or a relative reference from where the subclass lives.
   *
   * @since 1.0.0
   *
   * @var string
   */
  protected $plugin_template_directory = 'includes/public/templates';
}