<?php 

$settings = $data->settings;

$background = $settings['backgroundColor'];
$to = $settings['to'];
$time_separator = $settings['time_separator'];
$margin = $settings['margin'];
$message = $settings['message'];
$msgFontSize = $settings['msgFontSize'];
$msgColor = $settings['msgColor'];
$countdownUnitFontSize = $settings['countdownUnitFontSize'];
$countdownUnitColor = $settings['countdownUnitColor'];
$innerBorderSize = $settings['innerBorderSize'];
$innerBorderRadius = $settings['innerBorderRadius'];
$innerPadding = $settings['innerPadding'];
$innerBorderColor = $settings['innerBorderColor'];
$innerBgColor = $settings['innerBgColor'];

$countdownFontSize = $settings['countdownFontSize'];
$countdownColor = $settings['countdownColor'];
$hide_message = $settings['hide_message'];

$circleWidth = $settings['circleWidth']/100;
$circleBgColor = $settings['circleBgColor'];
$circleFgColor = $settings['circleFgColor'];
$link	= $settings['link'];
$hide_days = $settings['hide_days'];
$hide_hours = $settings['hide_hours'];
$hide_minutes = $settings['hide_minutes'];

$dateObj = explode('-', $to );
$timeObj = explode('T', $dateObj[2] );
$dateObj[2] = $timeObj[0];
$timeObj = explode(':', $timeObj[1] );

/*for timezone*/
// Creating compitible date according to UTF GMT time zone formate for older browwser
$timezone 		= get_option('gmt_offset'); //5.5
$tmzone 		= timezone_name_from_abbr("", $timezone*60*60 , 0) ;
$dtend 			=  new DateTime($to, new DateTimeZone($tmzone));		// end date obj
$dtnow 			=  new DateTime("now", new DateTimeZone($tmzone));  	// currant 
$totalseconds 	= $dtend->getTimestamp() - $dtnow->getTimestamp();		// total diffrence seconds

$status 	= get_post_status( $id );


if( $totalseconds < 0 ) {
		$totalseconds = 0;
	}


/*===================================*/
if ( !empty($to) && $status == 'publish'  ) { ?>
	<div class="main-area">
		<div class="full-height position-static" >
			<div class="row" >
				<div class="col" >
					<section class="" >

												
						<?php if($hide_message == 0) { ?>

						<h3 class="txt-center" 
							style="font-size:<?php echo $msgFontSize ?>px;
							color: <?php echo $msgColor ?>;
							"> 
							<?php echo $message; ?>
						</h3>

						<?php } ?>

						<div class="display-table center-text">
							<div class="display-table-cell">
								
								<div class="rounded-countdown">
									<div class="countdown" data-remaining-sec="<?php echo $totalseconds ?>">
										
									</div>
								</div>
								
							</div><!-- display-table-cell -->
						</div><!-- display-table -->

					</section><!-- right-section -->
				</div>
			</div> 
		</div><!-- container -->
		

		<?php 
			$settingsArray = array(
				'theme' => 'flat-colors-very-wide', 
				'style' => 
					array(
						'days' => array(
							'gauge' => array(
								'thickness' => $circleWidth,
								'bgColor'   => $circleBgColor,
	                       		'fgColor'	=> $circleFgColor,
	                       		'lineCap' 	=> 'butt' 
							), 
						'textCSS' => 'color:' .$countdownColor,
						), 
						'hours' => array(
							'gauge' => array(
								'thickness' => $circleWidth,
								'bgColor'   => $circleBgColor,
	                       		'fgColor'	=> $circleFgColor,
	                       		'lineCap' 	=> 'butt' 
							), 
						'textCSS' => 'color:' .$countdownColor,
						),
						'minutes' => array(
							'gauge' => array(
								'thickness' => $circleWidth,
								'bgColor'   => $circleBgColor,
	                       		'fgColor'	=> $circleFgColor,
	                       		'lineCap' 	=> 'butt' 
							), 
						'textCSS' => 'color:' .$countdownColor,
						), 
						'seconds' => array(
							'gauge' => array(
								'thickness' => $circleWidth,
								'bgColor'   => $circleBgColor,
	                       		'fgColor'	=> $circleFgColor,
	                       		'lineCap' 	=> 'butt' 
							), 
						'textCSS' => 'color:' .$countdownColor,
						) 
					),
				'labelsOptions'=> array(
					'lang' => array(
						'days' => 'Days', 
						'hours' => 'Hours', 
						'minutes' => 'Minutes', 
						'seconds' => 'Seconds', 
					), 
					'style' => 'font-size:'.$countdownUnitFontSize.'px',
				),
				'link' => $link,
			);
		?>

		<div class="countdown-date-conf" data-conf="<?php echo htmlspecialchars(json_encode($settingsArray)); ?>">
		
		</div>
	</div><!-- main-area -->
	<?php
	
} ?>

	
