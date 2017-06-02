<?php
/** Widget Code */
class LCCC_Calendar_Event_Widget extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		$widget_ops = array( 
				'classname' => 'LCCC_Calendar_Event_Widget',
			'description' => 'LCCC Event Calendar widget is designed to allow users to navigate through the current and upcoming LCCC Events on MyLCCC',
		);
		parent::__construct( 'LCCC_Calendar_Event_Widget', 'LCCC Calendar Event Widget', $widget_ops );
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		// outputs the content of the widget
  extract( $args );
   echo $before_widget;
		
				//Create an Array for storing the dates that have events
			$dates_with_events = array();
		
		//Grab posts (endpoints)
			$lcccevents = '';
			$stockerevents = '';
			$athleticevents = '';
			$sportevents = '';
			$categoryevents = '';
			//$domain = 'https://www.lorainccc.edu';
			$domain = 'https://' . $_SERVER['SERVER_NAME'];
			$lcccevents = new Endpoint( $domain . '/mylccc/wp-json/wp/v2/lccc_events' );
			$athleticevents = new Endpoint( $domain . '/athletics/wp-json/wp/v2/lccc_events' );
			$stockerevents = new Endpoint( $domain . '/stocker/wp-json/wp/v2/lccc_events' );
		
			//Create instance
	$multi = new MultiBlog( 1 );
  
  if ( $lcccevents != ''){
		$multi->add_endpoint ( $lcccevents );
  };
  
  if ( $athleticevents != ''){
		$multi->add_endpoint ( $athleticevents );
  };
  
  if ( $stockerevents != ''){
		$multi->add_endpoint ( $stockerevents );
  };
  
	//Fetch Posts(Events) from Endpoints
	$posts = $multi->get_posts();
	if(empty($posts)){
		echo 'No Posts Found!';
	}
		
	//establishing current date for testing
		 $currentdate = date("Y-m-d");
		
 //Filling array with dates with events
		 foreach ( $posts as $post ){
					if( $post->event_end_date > $currentdate ){
									array_push($dates_with_events, $post->event_end_date);
					}
			}
		$dates_with_events = array_unique($dates_with_events);
		$dates_with_events = array_filter($dates_with_events);
		$dates_with_events = array_values($dates_with_events);
		//echo '<br />';
		//echo '<br />';
		//echo 'Count: '.count($dates_with_events).'<br />';
		
		//echo 'Without Empty: '.count($dates_with_events).'<br />';
		//echo 'Events:'.'<br />';
/*		for($y=0;$y < count($dates_with_events); $y++){
				echo $y.':  '.$dates_with_events[$y].'<br />';
	  }
		*/
 $current_month = date("n");
 $current_year = date("Y");
 $current_date = date("Y") . '-' . date("m") . '-' . date("d");
 
 if(isset($_GET['disp_m'])){
  $display_month = $_GET['disp_m']; 
  $display_year = $_GET['disp_y'];
 } else {
  $display_month = $current_month; 
  $display_year = $current_year;
 }

 $next_month = $display_month;
 $next_year = $display_year;
  
 $prev_month = $display_month;
 $prev_year = $display_year;

 if ($display_month == '12'){
   $next_month = 1;
   $next_year = date("Y")+1;
  
   $prev_month -=1;
  
 } elseif($display_month > '12'){
  $next_month = 1;
  $next_year = date("Y")+1;

  $prev_month = 12;
 } elseif($display_month < '12'){
  $next_month +=1;
  $prev_month -=1;
  if ($prev_month == 0){
   $prev_month = 12;
   $prev_year -=1;
  }
 }
 
 //echo 'Current Month: ' . $current_month . ' - ' . $current_year . '<br /><br />';
 
 //echo 'Display Month: ' . $display_month . ' - ' . $display_year . '<br /><br />';

 //echo 'Next Month: ' . $next_month . ' - ' . $next_year . '<br/><br />';
 
 //echo 'Prev Month: ' . $prev_month . ' - ' . $prev_year . '<br/><br />';

	//Grab posts (endpoints)
  $domain = 'https://' . $_SERVER['SERVER_NAME'];
  //$domain = 'https://www.lorainccc.edu';
		$plugin_image_dir = $domain.'/mylccc/wp-content/plugins/lccc-news/images/';
/*if ($prev_month < $current_month && $prev_year == $current_year){
echo '<div class="calendar-header">';
				echo '<div class="header-placeholder">&nbsp;</div>';
				echo '<div class="cur-month">' . date('F', mktime(0, 0, 0, $display_month, 10)) . ' ' . $display_year . '</div>';
				echo '<div class="calendar-nav-next"><a id="next-month" href="#" data-nxtmonth="'.$next_month.'"data-nxtyear="'.$next_year.'"><img style="max-width:40%;" src="'.$plugin_image_dir.'Next-arrow.svg"></a></div></div><div style="clear:both;">';
echo '</div>';

}elseif($prev_month == $current_month && $prev_year == $current_year){
echo '<div class="calendar-header">';
				echo '<div class="calendar-nav-prev"><a href="?disp_m=' . $prev_month . '&disp_y=' . $prev_year . '"><img style="max-width:40%;" src="'.$plugin_image_dir.'Prev-arrow.svg"></a></div>';
				echo '<div class="cur-month">' . date('F', mktime(0, 0, 0, $display_month, 10)) . ' ' . $display_year . '</div>';
				echo '<div class="calendar-nav-next"><a id="next-month" href="#" data-nxtmonth="'.$next_month.'"data-nxtyear="'.$next_year.'"><img style="max-width:40%;" src="'.$plugin_image_dir.'Next-arrow.svg"></a></div>';
echo '</div>';
echo '<div style="clear:both;"></div>';

}else{
 echo '<div class="calendar-header">';
				echo '<div class="calendar-nav-prev"><a href="?disp_m=' . $prev_month . '&disp_y=' . $prev_year . '"><img style="max-width:40%;" src="'.$plugin_image_dir.'Prev-arrow.svg"></a></div>';
				echo '<div class="cur-month">' . date('F', mktime(0, 0, 0, $display_month, 10)) . ' ' . $display_year . '</div>';
				echo '<div class="calendar-nav-next"><a id="next-month" href="#" data-nxtmonth="'.$next_month.'"data-nxtyear="'.$next_year.'"><img style="max-width:40%;" src="'.$plugin_image_dir.'Next-arrow.svg"></a></div>';
	echo '</div>';
	echo '<div style="clear:both;"></div>';
}*/
		
				echo '<div class="calendar-header">';
			 echo '<div id="header-placeholder" class="header-placeholder">&nbsp;</div>';
				echo '<div class="calendar-nav-prev"><a id="prev-month" href="#" data-prvmonth="'.$prev_month.'"data-prvyear="'.$prev_year.'"><img style="max-width:40%;" src="'.$plugin_image_dir.'Prev-arrow.svg"></a></div>';
				echo '<div class="cur-month">' . date('F', mktime(0, 0, 0, $display_month, 10)) . ' ' . $display_year . '</div>';
				echo '<div class="calendar-nav-next"><a id="next-month" href="#" data-nxtmonth="'.$next_month.'"data-nxtyear="'.$next_year.'"><img style="max-width:40%;" src="'.$plugin_image_dir.'Next-arrow.svg"></a></div>';
				echo '</div>';
				echo '<div style="clear:both;"></div>';
		
echo '<div id="calendar-content"></div>';
  echo $after_widget;
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		// outputs the options form on admin

	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 */
	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
		    $instance = $old_instance;
 
					return $instance;
	}
}
add_action( 'widgets_init', function(){
	register_widget( 'LCCC_Calendar_Event_Widget' );
});
?>