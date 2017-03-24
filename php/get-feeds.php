<?php

/**
 *
 *
 *
 *
 *
 */

function get_events(){

 $all_events_transient = get_transient( 'LCCC_All_Events' );

 if( ! empty( $all_events_transient ) ){
  
  return $all_events_transient;
  
 } else {

   //Grab posts (endpoints)
    $lcccevents = '';
    $stockerevents = '';
    $athleticevents = '';
    $sportevents = '';
    $categoryevents = '';
    //$domain = 'http://www.lorainccc.edu';
    $domain = 'http://' . $_SERVER['SERVER_NAME'];
    $lcccevents = new Endpoint( $domain . '/mylccc/wp-json/wp/v2/lccc_events/?per_page=100' );
    $athleticevents = new Endpoint( $domain . '/athletics/wp-json/wp/v2/lccc_events/?per_page=100' );
    $stockerevents = new Endpoint( 'http://sites.lorainccc.edu/stocker/wp-json/wp/v2/lccc_events/?per_page=100' );

    //Create instance
  $multi = new MultiBlog( 1 );
   $multi->add_endpoint ( $lcccevents );
   $multi->add_endpoint ( $athleticevents );
   $multi->add_endpoint ( $stockerevents );

  //Fetch Posts(Events) from Endpoints
  $posts = $multi->get_posts();
  if(empty($posts)){
   echo 'No Posts Found!';
  }

  set_transient( 'LCCC_All_Events' , $posts, 43200);
  
  return $posts;
 }
}
function get_stocker_events(){
 
  $stocker_transient = get_transient( 'LCCC_Stocker_Events' );

 if( ! empty( $stocker_transient ) ){
  
  return $stocker_transient;
  
 } else {
 
		//Grab posts (endpoints)
			$stockerevents = '';
			//$domain = 'http://www.lorainccc.edu';
			$domain = 'http://' . $_SERVER['SERVER_NAME'];
			$stockerevents = new Endpoint( 'http://sites.lorainccc.edu/stocker/wp-json/wp/v2/lccc_events/?per_page=100' );

			//Create instance
	$multi = new MultiBlog( 1 );
		$multi->add_endpoint ( $stockerevents );

	//Fetch Posts(Events) from Endpoints
	$posts = $multi->get_posts();
	if(empty($posts)){
		echo 'No Posts Found!';
	}
  
  set_transient( 'LCCC_Stocker_Events' , $posts, 43200);

	return $posts;
 }
}

function get_athletic_events(){
 
 $athletic_transient = get_transient( 'LCCC_Athletics_Events' );

 if( ! empty( $athletic_transient ) ){
  
  return $athletic_transient;
  
 } else {
 
		//Grab posts (endpoints)
			$athleticevents = '';
			$sportevents = '';
			$categoryevents = '';
			//$domain = 'http://www.lorainccc.edu';
			$domain = 'http://' . $_SERVER['SERVER_NAME'];
			$athleticevents = new Endpoint( $domain . '/athletics/wp-json/wp/v2/lccc_events/?per_page=100' );

			//Create instance
	$multi = new MultiBlog( 1 );
		$multi->add_endpoint ( $athleticevents );

	//Fetch Posts(Events) from Endpoints
	$posts = $multi->get_posts();
	if(empty($posts)){
		echo 'No Posts Found!';
	}

  set_transient( 'LCCC_Athletics_Events' , $posts, 43200);
  
	return $posts;
 }
}


function build_event_date_list(){

 $event_date_transient = get_transient( 'LCCC_Event_Date_List' );

 if( ! empty( $event_date_transient ) ){
  
  return $event_date_transient;
  
 } else { 
 
		//Create an Array for storing the dates that have events
			$dates_with_events = array();
   $posts = array();
		 $posts = get_events();

	//establishing current date for testing
		 $currentdate = date("Y-m-d");

 //Filling array with dates with events
		 foreach ( $posts as $post ){
					if( $post->event_start_date >= $currentdate ){
									array_push($dates_with_events, $post->event_start_date);
					}
			}
		$dates_with_events = array_unique($dates_with_events);
		$dates_with_events = array_filter($dates_with_events);
		$dates_with_events = array_values($dates_with_events);

   set_transient( 'LCCC_Event_Date_List' , $dates_with_events, 43200);
  
	return $dates_with_events;
 }
}

?>