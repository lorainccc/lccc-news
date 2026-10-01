<?php

/**
 *
 *
 *
 *
 *
 */

//Deprecated to use MyLCCC Info Transients

/* function get_events(){

 $all_events_transient = get_transient( 'LCCC_All_Events' );

 if( ! empty( $all_events_transient ) ){
  
  return $all_events_transient;
  
 } else {

   //Grab posts (endpoints)
    //$lcccevents = '';
    //$stockerevents = '';
    //$athleticevents = '';
    //$sportevents = '';
    //$categoryevents = '';
    $domain = 'https://www.lorainccc.edu';
    //$domain = 'https://' . $_SERVER['SERVER_NAME'];
    //$lcccevents = new Endpoint( $domain . '/mylccc/wp-json/wp/v2/lccc_events?per_page=100' );
    //$athleticevents = new Endpoint( $domain . '/athletics/wp-json/wp/v2/lccc_events?per_page=100' );
    //$stockerevents = new Endpoint( $domain . '/stocker/wp-json/wp/v2/lccc_events?per_page=100' );

    //Create instance
  //$multi = new MultiBlog( 1 );
   //$multi->add_endpoint ( $lcccevents );
   //$multi->add_endpoint ( $athleticevents );
   //$multi->add_endpoint ( $stockerevents );

  //Fetch Posts(Events) from Endpoints
  //$posts = $multi->get_posts();
  if(empty($posts)){
   //echo 'No Posts Found!';
  }

  //set_transient( 'LCCC_All_Events' , $posts, 43200);
  
  return $posts;
 }
} */

//Deprecated to use MyLCCC Info Transients

/* function get_stocker_events(){
 
  $stocker_transient = get_transient( 'LCCC_Stocker_Events' );

 if( ! empty( $stocker_transient ) ){
  
  return $stocker_transient;
  
 } else {
 
		//Grab posts (endpoints)
			$stockerevents = '';
			$domain = 'https://www.lorainccc.edu';
			//$domain = 'https://' . $_SERVER['SERVER_NAME'];
			//$stockerevents = new Endpoint( $domain .'/stocker/wp-json/wp/v2/lccc_events?per_page=100' );

			//Create instance
	//$multi = new MultiBlog( 1 );
		//$multi->add_endpoint ( $stockerevents );

	//Fetch Posts(Events) from Endpoints
	//$posts = $multi->get_posts();
	if(empty($posts)){
		//echo 'No Posts Found!';
	}
  
  //set_transient( 'LCCC_Stocker_Events' , $posts, 43200);

	return $posts;
 }
} */

//Deprecated to use MyLCCC Info Transients

/* function get_athletic_events(){
 
 $athletic_transient = get_transient( 'LCCC_Athletics_Events' );

 if( ! empty( $athletic_transient ) ){
  
  return $athletic_transient;
  
 } else {
 
		//Grab posts (endpoints)
			$athleticevents = '';
			$sportevents = '';
			$categoryevents = '';
			$domain = 'https://www.lorainccc.edu';
			$domain = 'https://' . $_SERVER['SERVER_NAME'];
			$athleticevents = new Endpoint( $domain . '/athletics/wp-json/wp/v2/lccc_events?per_page=100' );

			//Create instance
	//$multi = new MultiBlog( 1 );
		//$multi->add_endpoint ( $athleticevents );

	//Fetch Posts(Events) from Endpoints
	//$posts = $multi->get_posts();
	if(empty($posts)){
		//echo 'No Posts Found!';
	}

  //set_transient( 'LCCC_Athletics_Events' , $posts, 43200);
  
	return $posts;
 }
} */


function lc_build_event_date_list(){

 $event_date_transient = get_site_transient( 'LCCC_Event_Date_List' );

 if( ! empty( $event_date_transient ) ){
  
  return $event_date_transient;
  
 } /*else { 
	
	//Create an Array for storing the dates that have events
	$dates_with_events = array();
	$posts = array();

	// Call function from LCCC MyLCCC Info Feed Plugin - Access Pre-Existing Transient
    //$posts = lc_get_all_events();

	$domain = 'https://' . $_SERVER['SERVER_NAME'];

	$lccc_response = wp_remote_get( $domain . '/mylccc/wp-json/wp/v2/lccc_events?per_page=100' );
	if ( ! is_wp_error( $lccc_response ) && 200 === wp_remote_retrieve_response_code( $lccc_response ) ) {
	$lccc_events = json_decode( wp_remote_retrieve_body( $lccc_response ), true );
	}

	$stocker_response = wp_remote_get( $domain . '/stocker/wp-json/wp/v2/lccc_events?per_page=100' );
	if ( ! is_wp_error( $stocker_response ) && 200 === wp_remote_retrieve_response_code( $stocker_response ) ) {
	$stocker_events = json_decode( wp_remote_retrieve_body( $stocker_response ), true );
	}

    if(!empty($lccc_events)){
		if(!empty($stocker_events)){
		  $posts = array_merge($lccc_events, $stocker_events);
		}else{
		  $posts = $lccc_events;
		}
	}

	//var_dump($posts);

	$posts = lc_feed_sort( $posts, 'event' );

	//establishing current date for testing
	$currentdate = date("Y-m-d");

	//Filling array with dates with events
		 foreach ( $posts as $post ){
			if( $post['event_start_date'] >= $currentdate ){
				array_push($dates_with_events, $post['event_start_date']);
				}
			}
		$dates_with_events = array_unique($dates_with_events);
		$dates_with_events = array_filter($dates_with_events);
		$dates_with_events = array_values($dates_with_events);

   //set_site_transient( 'LCCC_Event_Date_List' , $dates_with_events, 12 * HOUR_IN_SECONDS);
  
	return $dates_with_events;
 }*/
}

/*function lc_feed_sort( array $data, string $type ) {
 
  switch($type){
	case 'event':
   
	  foreach ($data as $key => $row ){      
		$event_start_date_and_time[$key] = $row['event_start_date_and_time'];
		$title[$key] = $row['title']['rendered'];
	  }

	  if(is_array($event_start_date_and_time)){
		array_multisort($event_start_date_and_time, SORT_ASC, $title, SORT_ASC, $data);
		return $data;
	  }else{
		return null;
	  }
	  
	break;
  
	case 'announcement':
	  foreach ($data as $key => $row ){      
		$date[$key] = $row->date;
		$title[$key] = $row->title->rendered;
	  }
  
	  array_multisort($date, SORT_ASC, $title, SORT_ASC, $data);
	  return $data;
	break;
  } 
	
  }*/

?>