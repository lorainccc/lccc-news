jQuery(document).ready(function(){ 
			//inital load	
			jQuery('#prev-month').hide();
	  jQuery('#header-placeholder').show();
	
			jQuery('#calendar-content').load(wpDirectory.pluginsUrl+'/lccc-news/php/ajax-calendar-template.php');
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
				console.log(nextmonth+', '+nextyear);
		
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
				jQuery('#calendar-content').load(wpDirectory.pluginsUrl+'/lccc-news/php/ajax-calendar-template.php', {"disp_m":nextmonth,"disp_y":nextyear});
				 return false;
			}
});