<?php

$classes = apply_filters( 'cte_countdown_timer_event_extra_classes', 'countdown-timer', $data->settings );
$items_attributes = apply_filters( 'cte_countdown_timer_event_items_attributes', array(),$data->settings );

?>


<div id="<?php echo esc_attr($data->cte_id) ?>" class="<?php echo esc_attr($classes); ?> <?php echo ( $data->settings['align'] != '' ) ? esc_attr( 'align' . $data->settings['align'] ) : ''; ?>" style="display: block;position: relative; max-width: 100%;" >



<?php


$layout = $data->settings['type'];


require "design/$layout/index.php";
?>
</div>
<?php 
return;

?>





	

