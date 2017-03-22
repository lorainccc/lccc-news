jQuery(document).ready(function(){ 
//	console.log(wpDirectory.arrayOfDates);
	//console.log(wpDirectory.eventList);
	jQuery('#all-lccc-event-listings').show();
				var $posts = [];
					$posts = wpDirectory.eventList;
					var $Currentdate =  moment().format("YYYY-MM-DD");
					//console.log($Currentdate);
					var $events = "";	
					var $newDate = moment($Currentdate).format('MM/DD/YYYY');
					var $titleDate =		moment($Currentdate).format('MMMM DD, YYYY');
					$events += '<h2 style="font-size: 1.5rem;">LCCC Events for ' + $titleDate +'</h2>';
					var $eventcounter = 0;			
					var $eventbool = false;
			//		console.log('Before' + $eventbool);
					for($i=0; $i < $posts.length; $i++){
									if($posts[$i].event_start_date == $Currentdate){
												var $featured = $posts[$i].featured_media;
													if($featured != 0){
														$events += '<div class="small-12 medium-12 large-12 columns mylccc-event-listing">';
																	$events += '<div class="small-12 medium-3 large-3 columns nopadding">';
																			$events += '<img src="'+$posts[$i].better_featured_image.media_details.sizes.medium.source_url+'" alt="'+$posts[$i].better_featured_image.alt_text+'">';	
																	$events += '</div>';
																	$events += '<div class="small-12 medium-9 large-9 columns">';
																			$events += '<a href="'+$posts[$i].link+'"><h2 class="event-title">'+$posts[$i].title.rendered+'</h2></a>';
																			$events += '<p style="margin-bottom: 0;">Date: '+$newDate+'</p>';
																			if($posts[$i].event_start_time !=''){
																						$events += '<p style="margin-bottom: 0;">'+'Time: '+$posts[$i].event_start_time+'</p>';	
																			}
																			var $location = $posts[$i].event_location;
																			if ( $location != ''){
																							$events += '<p style="margin-bottom: 0;">Location: '+$location+'</p>';
																			}	
																			if( $posts[$i].excerpt.rendered != ''){
																						$events +='<p>'+	$posts[$i].excerpt.rendered+'</p>';
																						$events +='<a class="button" href="'+$posts[$i].link+'">Learn More</a>';	
																			}else{
																						$events +='<p>'+	$posts[$i].content.rendered+'</p>';
																						$events +='<a  style="margin-top: 1rem;" class="button" href="'+$posts[$i].link+'">Learn More</a>';	
																			}
																	$events +='</div>';
														$events +='</div>';
														
														$events +='<div class="column row event-list-row">';
																$events +='<hr>';
														$events +='</div>';
													}else{
														$events += '<div class="small-12 medium-12 large-12 columns mylccc-event-listing">';
														$events += '<a href="'+$posts[$i].link+'"><h2 class="event-title">'+$posts[$i].title.rendered+'</h2></a>';
														var $newDate = moment($Currentdate).format('MM/DD/YYYY');
														$events += '<p style="margin-bottom: 0;">Date: '+$newDate+'</p>';
														if($posts[$i].event_start_time !=''){
																		 $events += '<p style="margin-bottom: 0;">'+'Time: '+$posts[$i].event_start_time+'</p>';	
														}
														var $location = $posts[$i].event_location;
														if ($location != ''){
																		$events += '<p style="margin-bottom: 0;">Location: '+$location+'</p>';
														}	
														if( $posts[$i].excerpt.rendered != ''){
																		$events +='<p>'+	$posts[$i].excerpt.rendered+'</p>';
																		$events +='<a class="button" href="'+$posts[$i].link+'">Learn More</a>';	
														}else{
																		$events +='<a style="margin-top: 1rem;" class="button" href="'+$posts[$i].link+'">Learn More</a>';	
														}
													$events +='</div>';
													$events +='<div class="column row event-list-row">';
            			$events +='<hr>';
           		$events +='</div>';
										 }
										$eventbool = true;
									}
						 }
	
							if($eventbool == false){
									$events += '<div style="margin-bottom:2rem;" class="small-12 medium-12 large-12 columns">';
																	$events +='</h3>There are no scedule events for this date. </h3>';
									$events +='</div>';		
							}
			document.getElementById("mobile-lccc-event-listings").innerHTML = $events;
	
			//inital load	
			jQuery('#prev-month').hide();
	  jQuery('#header-placeholder').show();
	
			jQuery('#calendar-content').load(wpDirectory.pluginsUrl+'/lccc-news/php/ajax-calendar-template.php', {"lccc_date_array":wpDirectory.arrayOfDates});
	
			jQuery('div.calendar-nav-next a').click(function(){
						jQuery('#header-placeholder').hide();
						jQuery('#prev-month').show();
						var $this = jQuery(this);
						var displaymonth = $this.data('nxtmonth');
						var displayyear = $this.data('nxtyear');
						displayMonth(displaymonth, displayyear);
			});
	
				jQuery('div.calendar-nav-prev a').click(function(){
					var d = new Date();
					var curmonth = d.getMonth();
				 var curyear = d.getFullYear();
					
						var $this = jQuery(this);
						var displaymonth = $this.data('prvmonth');
						var displayyear = $this.data('prvyear');
					
					if(curmonth == displaymonth && curyear == displayyear){
					  jQuery('#prev-month').hide();
						 jQuery('#header-placeholder').show();
						} else {
							jQuery('#header-placeholder').hide();
							jQuery('#prev-month').show();
						}
					
								displayMonth(displaymonth, displayyear);
			});
			

	
			function displayMonth(month, year){
				var d = new Date();
				var curmonth = d.getMonth();
				var $this = jQuery(this);
				var nextmonth = month;
				var displaymonth = month;
				var nextyear = year;
			 var monthNames = ["January", "February", "March", "April", "May", "June",
  "July", "August", "September", "October", "November", "December"
];
				var currentDate = moment().format("DD-MM-YYYY");
				//console.log(nextmonth+', '+nextyear);
		
				var prevmonth = month;
				var prevyear = year;
				
				if(nextmonth > 12){
						nextmonth = 1;	
						jQuery('#next-month').data('nxtmonth',nextmonth);
						displaymonth = 1;
						jQuery('#prev-month').data('prvmonth',12);
						jQuery('#prev-year').data('prvmonth',prevyear-1);
				}
				
				if( nextmonth < 12 ){
						jQuery('#next-month').data('nxtmonth',nextmonth+1);
						jQuery('#prev-month').data('prvmonth',prevmonth-1);
						displaymonth = nextmonth;
					if( prevmonth-1 == curmonth){
									jQuery('#prev-month').hide();
						 jQuery('#header-placeholder').show();
						}
				} else if( nextmonth == 12 ){
						jQuery('#next-month').data('nxtmonth',nextmonth+1);
						jQuery('#next-month').data('nxtyear',nextyear+1);
						jQuery('#prev-month').data('prvmonth',prevmonth-1);
				}
				
				document.getElementsByClassName("cur-month")[0].innerHTML = monthNames[displaymonth-1] + ' '+ nextyear; 
				
				//jQuery('#next-month').data('nxtyear',nextyear);
				jQuery('#calendar-content').load(wpDirectory.pluginsUrl+'/lccc-news/php/ajax-calendar-template.php', {"disp_m":nextmonth,"disp_y":nextyear,"lccc_date_array":wpDirectory.arrayOfDates});
				 return false;
			}
	
});

jQuery(document).on('click', 'div.week a', function(){
								var $this = jQuery(this);
								var $posts = [];
								$posts = wpDirectory.eventList;
								var $dateSelected = $this.data("selected");
								//console.log($dateSelected);
								var $titles = "";	
								var $newDate = moment($dateSelected).format('MM/DD/YYYY');
								var $titleDate =		moment($dateSelected).format('MMMM DD, YYYY');
								$titles += '<h2 style="font-size: 1.5rem;">LCCC Events for ' + $titleDate +'</h2>';
								
					for($i=0; $i < $posts.length; $i++){
									if($posts[$i].event_start_date == $dateSelected){
												var $featured = $posts[$i].featured_media;
													if($featured != 0){
														$titles += '<div class="small-12 medium-12 large-12 columns mylccc-event-listing">';
																	$titles += '<div class="small-12 medium-3 large-3 columns nopadding">';
																			$titles += '<img src="'+$posts[$i].better_featured_image.media_details.sizes.medium.source_url+'" alt="'+$posts[$i].better_featured_image.alt_text+'">';	
																	$titles += '</div>';
																	$titles += '<div class="small-12 medium-9 large-9 columns">';
																			$titles += '<a href="'+$posts[$i].link+'"><h2 class="event-title">'+$posts[$i].title.rendered+'</h2></a>';
																			$titles += '<p style="margin-bottom: 0;">Date: '+$newDate+'</p>';
																			if($posts[$i].event_start_time !=''){
																						$titles += '<p style="margin-bottom: 0;">'+'Time: '+$posts[$i].event_start_time+'</p>';	
																			}
																			var $location = $posts[$i].event_location;
																			if ( $location != ''){
																							$titles += '<p style="margin-bottom: 0;">Location: '+$location+'</p>';
																			}	
																			if( $posts[$i].excerpt.rendered != ''){
																						$titles +='<p>'+	$posts[$i].excerpt.rendered+'</p>';
																						$titles +='<a class="button" href="'+$posts[$i].link+'">Learn More</a>';	
																			}else{
																						$titles +='<p>'+	$posts[$i].content.rendered+'</p>';
																						$titles +='<a  style="margin-top: 1rem;" class="button" href="'+$posts[$i].link+'">Learn More</a>';	
																			}
																	$titles +='</div>';
														$titles +='</div>';
														
														$titles +='<div class="column row event-list-row">';
																$titles +='<hr>';
														$titles +='</div>';
													}else{
														$titles += '<div class="small-12 medium-12 large-12 columns mylccc-event-listing">';
														$titles += '<a href="'+$posts[$i].link+'"><h2 class="event-title">'+$posts[$i].title.rendered+'</h2></a>';
														var $newDate = moment($dateSelected).format('MM/DD/YYYY');
														$titles += '<p style="margin-bottom: 0;">Date: '+$newDate+'</p>';
														if($posts[$i].event_start_time !=''){
																		 $titles += '<p style="margin-bottom: 0;">'+'Time: '+$posts[$i].event_start_time+'</p>';	
														}
														var $location = $posts[$i].event_location;
														if ($location != ''){
																		$titles += '<p style="margin-bottom: 0;">Location: '+$location+'</p>';
														}	
														if( $posts[$i].excerpt.rendered != ''){
																		$titles +='<p>'+	$posts[$i].excerpt.rendered+'</p>';
																		$titles +='<a class="button" href="'+$posts[$i].link+'">Learn More</a>';	
														}else{
																		$titles +='<a style="margin-top: 1rem;" class="button" href="'+$posts[$i].link+'">Learn More</a>';	
														}
													$titles +='</div>';
													$titles +='<div class="column row event-list-row">';
            			$titles +='<hr>';
           		$titles +='</div>';
										 }
									}	
						 }
												
								document.getElementById("lccc-event-listings").innerHTML = $titles; 
								document.getElementById("mobile-lccc-event-listings").innerHTML = $titles;
});
jQuery(document).on('change', '#event_type', function(){
	 var $posts = [];
		var $value = jQuery(this).val();
		switch($value) {
				case 'Athletics':
        $posts = wpDirectory.athelticEvents;
								jQuery('#all-lccc-event-listings').hide();
	  				 break;
    case 'Stocker':
        $posts = wpDirectory.stockerEvents;		
        jQuery('#all-lccc-event-listings').hide();
								break;
    default:
        $posts = wpDirectory.eventList;
								jQuery('#all-lccc-event-listings').show();
       
		}
					var $Currentdate =  moment().format("YYYY-MM-DD");
					//console.log($Currentdate);
					var $events = "";	
					var $newDate = moment($Currentdate).format('MM/DD/YYYY');
					var $titleDate =		moment($Currentdate).format('MMMM DD, YYYY');
					$events += '<h2 style="font-size: 2.0rem;">' + $value +' Events</h2>';
					var $eventcounter = 0;			
					var $eventbool = false;
			//		console.log('Before' + $eventbool);
					for($i=0; $i < $posts.length; $i++){
									if($posts[$i].event_start_date >= $Currentdate){
												var $featured = $posts[$i].featured_media;
													if($featured != 0){
														$events += '<div class="small-12 medium-12 large-12 columns mylccc-event-listing">';
																	$events += '<div class="small-12 medium-3 large-3 columns nopadding">';
																			$events += '<img src="'+$posts[$i].better_featured_image.media_details.sizes.medium.source_url+'" alt="'+$posts[$i].better_featured_image.alt_text+'">';	
																	$events += '</div>';
																	$events += '<div class="small-12 medium-9 large-9 columns">';
																			$events += '<a href="'+$posts[$i].link+'"><h2 class="event-title">'+$posts[$i].title.rendered+'</h2></a>';
																			$events += '<p style="margin-bottom: 0;">Date: '+$newDate+'</p>';
																			if($posts[$i].event_start_time !=''){
																						$events += '<p style="margin-bottom: 0;">'+'Time: '+$posts[$i].event_start_time+'</p>';	
																			}
																			var $location = $posts[$i].event_location;
																			if ( $location != ''){
																							$events += '<p style="margin-bottom: 0;">Location: '+$location+'</p>';
																			}	
																			if( $posts[$i].excerpt.rendered != ''){
																						$events +='<p>'+	$posts[$i].excerpt.rendered+'</p>';
																						$events +='<a class="button" href="'+$posts[$i].link+'">Learn More</a>';	
																			}else{
																						$events +='<p>'+	$posts[$i].content.rendered+'</p>';
																						$events +='<a  style="margin-top: 1rem;" class="button" href="'+$posts[$i].link+'">Learn More</a>';	
																			}
																	$events +='</div>';
														$events +='</div>';
														
														$events +='<div class="column row event-list-row">';
																$events +='<hr>';
														$events +='</div>';
													}else{
														$events += '<div class="small-12 medium-12 large-12 columns mylccc-event-listing">';
														$events += '<a href="'+$posts[$i].link+'"><h2 class="event-title">'+$posts[$i].title.rendered+'</h2></a>';
														var $newDate = moment($Currentdate).format('MM/DD/YYYY');
														$events += '<p style="margin-bottom: 0;">Date: '+$newDate+'</p>';
														if($posts[$i].event_start_time !=''){
																		 $events += '<p style="margin-bottom: 0;">'+'Time: '+$posts[$i].event_start_time+'</p>';	
														}
														var $location = $posts[$i].event_location;
														if ($location != ''){
																		$events += '<p style="margin-bottom: 0;">Location: '+$location+'</p>';
														}	
														if( $posts[$i].excerpt.rendered != ''){
																		$events +='<p>'+	$posts[$i].excerpt.rendered+'</p>';
																		$events +='<a class="button" href="'+$posts[$i].link+'">Learn More</a>';	
														}else{
																		$events +='<a style="margin-top: 1rem;" class="button" href="'+$posts[$i].link+'">Learn More</a>';	
														}
													$events +='</div>';
													$events +='<div class="column row event-list-row">';
            			$events +='<hr>';
           		$events +='</div>';
										 }
										$eventbool = true;
									}
						 }
	
							if($eventbool == false){
									$events += '<div style="margin-bottom:2rem;" class="small-12 medium-12 large-12 columns">';
																	$events +='</h3>There are no scedule events for this date. </h3>';
									$events +='</div>';		
							}
			document.getElementById("lccc-event-listings").innerHTML = $events; 
		 document.getElementById("mobile-lccc-event-listings").innerHTML = $events;
							
});