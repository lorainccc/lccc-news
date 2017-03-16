<?php 	

//Create an Array for storing the dates that have events
			$dates_with_events = array();
		$dates_with_events = $_POST['lccc_date_array'];
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
 
 if(isset($_POST['disp_m'])){
  $display_month = $_POST['disp_m']; 
  $display_year = $_POST['disp_y'];
		
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
 

$calendar = '<div id="calendar">';

$headings = array('Sun','Mon','Tues','Wed','Thurs','Fri','Sat');

$calendar .= '<div class="week heading"><div class="day heading"><div class="heading-text">'.implode('</div></div><div class="day heading"><div class="heading-text">', $headings).'</div></div></div>';

$running_day = date('w',mktime(0,0,0,$display_month,1,$display_year));
$days_in_month = date('t',mktime(0,0,0,$display_month,1,$display_year));

$days_in_this_week = 1;

$day_counter = 0;

$dates_array = array();

$calendar.= '<div class="week">';

for($x = 0; $x < $running_day; $x++):
	$calendar.= '<div class="day-np">&nbsp;</div>';
	$days_in_this_week++;
endfor;

for($list_day = 1; $list_day <= $days_in_month; $list_day++):
 // determine if day is single digit or two, and transform to two digits
 if (strlen($list_day) == 1){
  $day_of_week = '0' . $list_day;
 }else{
  $day_of_week = $list_day;
 }
 // determine if month is single digit or two, and transform to two digits
 if (strlen($display_month) == 1){
   $full_month = '0' . $display_month;
 }else{
  $full_month = $display_month;
 }
 
 // fully formed date to match WordPress date variable
 $full_date = $display_year . '-' . $full_month . '-' . $day_of_week;
 
 
	if($full_date == $current_date){
		$bol_valid = false;	
		for($y=0;$y < count($dates_with_events); $y++){
							if( $full_date == $dates_with_events[$y]){
									$bol_valid = true;
							}
				}

		if($bol_valid == true){
			   $calendar.= '<a href="/mylccc/day?d='.$full_date.'">';
			$calendar.= '<div class="day current-day">';
   			$calendar.= '<div class="day-number">'.$list_day.'</div>';
						$calendar.= '<a class="calendar-event-listing" href="/mylccc/day?d='.$full_date.'"></a>';
   $calendar.= '</div></a>';
			
		} else{

			$calendar.= '<div class="day current-day">';
   			$calendar.= '<div class="day-number">'.$list_day.'</div>';
			$calendar.= '</div>';
		}		
		
	}else{
		$bol_valid = false;	
    for($y=0;$y < count($dates_with_events); $y++){
								if( $full_date == $dates_with_events[$y]){
										$bol_valid = true;
								}
				}
		if($bol_valid == true){
			$calendar.= '<a style="display:block;" href="/mylccc/day?d='.$full_date.'">';
									$calendar.= '<div class="day">';
   $calendar.= '<div class="day-number">'.$list_day.'</div>';
								$calendar.= '<a class="calendar-event-listing" href="/mylccc/day?d='.$full_date.'"></a>';
			$calendar.= '</div></a>';
							} else{
									$calendar.= '<div class="day">';
   $calendar.= '<div class="day-number">'.$list_day.'</div>';
			$calendar.= '</div>';
		}
	}
	if($running_day == 6):
		$calendar.= '</div>';
		if(($day_counter+1) != $days_in_month):
			$calendar.= '<div class="week">';
		endif;
		$running_day = -1;
		$days_in_this_week = 0;
	endif;
	$days_in_this_week++; $running_day++; $day_counter++;
endfor;

if($days_in_this_week < 8):
	for($x = 1; $x <= (8 - $days_in_this_week); $x++):
		$calendar.= '<div class="day-np">&nbsp;</div>';
	endfor;
endif;
 
echo $calendar;


?>