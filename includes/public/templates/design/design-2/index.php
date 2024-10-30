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

/*end date and time which is in $to*/
$data = 
	array(
		"link"		=> $link,
		"time_zone" => $tmzone,
		"endYear" 	=> $dateObj[0] ,
		"endMonth" 	=> $dateObj[1] ,
		"endDate" 	=> $dateObj[2] ,
		"endHours" 	=> $timeObj[0] ,
		"endMinutes"=> $timeObj[1] ,
		"endSeconds"=> 00 ,
	);


?>

<div class="row">
	<div class="col">
		<div class="flex-col-c-m" style="margin: <?php echo $margin ?>px;"><!-- p-t-50 -->
				
				
				<?php if($hide_message == 0) { ?>

					<h3 class="txt-center" 
						style="font-size:<?php echo $msgFontSize ?>px;
						color: <?php echo $msgColor ?>;
						"> 
					
						<?php echo $message; ?>
					</h3>

				<?php } ?>

				<div class="flex-w flex-c cd100" data-countdown=<?php echo json_encode($data); ?>>
					<?php if($hide_days == 0) { ?>
						
						<div class="flex-col-c wsize1" style="
								padding: <?php echo $innerPadding ?>px;
								border: <?php echo $innerBorderSize ?>px solid <?php echo $innerBorderColor ?>;
								border-radius: <?php echo $innerBorderRadius ?>%;
								background-color: <?php echo $innerBgColor ?>;

								">
							<span class="l1-txt2 p-b-37 days" style="font-size:<?php echo $countdownFontSize ?>px;
							color: <?php echo $countdownColor ?>;
							"><!-- 35 --></span>
							<span class="m1-txt2" style="font-size:<?php echo $countdownUnitFontSize ?>px;
							color: <?php echo $countdownUnitColor ?>;
							">Days</span>
						</div>

						<span class="l1-txt2 dis-none-sm" style="font-size:<?php echo $countdownFontSize ?>px;"><?php echo $time_separator; ?></span><!-- p-t-15 -->

					<?php } ?>

					<?php if($hide_hours == 0) { ?>

						<div class="flex-col-c wsize1" style="
								padding: <?php echo $innerPadding ?>px;
								border: <?php echo $innerBorderSize ?>px solid <?php echo $innerBorderColor ?>;
								border-radius: <?php echo $innerBorderRadius ?>%;
								background-color: <?php echo $innerBgColor ?>;

								">
							<span class="l1-txt2 p-b-37 hours" style="font-size:<?php echo $countdownFontSize ?>px;
							color: <?php echo $countdownColor ?>;
							"><!-- 17 --></span>
							<span class="m1-txt2" style="font-size:<?php echo $countdownUnitFontSize ?>px;
							color: <?php echo $countdownUnitColor ?>;
							">Hours</span>
						</div>

						<span class="l1-txt2 dis-none-lg" style="font-size:<?php echo $countdownFontSize ?>px;"><?php echo $time_separator; ?></span>

					<?php } ?>	

					<?php if($hide_minutes == 0) { ?>

						<div class="flex-col-c wsize1" style="
								padding: <?php echo $innerPadding ?>px;
								border: <?php echo $innerBorderSize ?>px solid <?php echo $innerBorderColor ?>;
								border-radius: <?php echo $innerBorderRadius ?>%;
								background-color: <?php echo $innerBgColor ?>;

								">
							<span class="l1-txt2 p-b-37 minutes" style="font-size:<?php echo $countdownFontSize ?>px;
							color: <?php echo $countdownColor ?>;
							"><!-- 50 --></span>
							<span class="m1-txt2" style="font-size:<?php echo $countdownUnitFontSize ?>px;
							color: <?php echo $countdownUnitColor ?>;
							">Minutes</span>
						</div>

						<span class="l1-txt2 dis-none-sm" style="font-size:<?php echo $countdownFontSize ?>px;"><?php echo $time_separator; ?></span>

					<?php } ?>	

					<div class="flex-col-c wsize1" style="
								padding: <?php echo $innerPadding ?>px;
								border: <?php echo $innerBorderSize ?>px solid <?php echo $innerBorderColor ?>;
								border-radius: <?php echo $innerBorderRadius ?>%;
								background-color: <?php echo $innerBgColor ?>;

								">
						<span class="l1-txt2 p-b-37 seconds" style="font-size:<?php echo $countdownFontSize ?>px;
						color: <?php echo $countdownColor ?>;
						"><!-- 39 --></span>
						<span class="m1-txt2" style="font-size:<?php echo $countdownUnitFontSize ?>px;
						color: <?php echo $countdownUnitColor ?>;
						">Seconds</span>
					</div>
				</div>
		</div>
	</div><!-- col -->
</div><!-- row -->
