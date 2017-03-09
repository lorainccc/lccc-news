var app = new angular.module("demo", ['ui.router', 'ngResource', 'ngRoute']);
var mylcccapi = {};
var athleticsapi = {};
var stockerapi = {};


mylcccapi.query = 'https://www.lorainccc.edu/mylccc/wp-json/wp/v2/lccc_events/?per_page=100';

athleticsapi.query = 'https://www.lorainccc.edu/athletics/wp-json/wp/v2/lccc_events/?per_page=100';

stockerapi.query = 'https://sites.lorainccc.edu/stocker/wp-json/wp/v2/lccc_events/?per_page=100';

 app.factory('eventFactory', ['$http',
    function($http) {
      var notesService = {};
      notesService.getData = function(url, method) {
        return $http({
          url: url,
          method: method
        });
						}
		
      return notesService;
    }
  ]);
/*app.factory('combinedData', ['$http', '$q','feed1', 'feed2', 'feed3',
						function(feed1, feed2, feed3){
						var combinedData = $q.all({
        					firstResponse: feed1,
        					secondResponse: feed2,
													thirdResponse: feed3,
      	});
      combinedData.then(function(response) {
							var eventdates = [];
							var combinedList = [];
							for($i = 0; $i <= response.firstResponse.data.length; $i++){
												eventdates.push(response.firstResponse.data[$i]);
							}
							for($i = 0; $i <= response.secondResponse.data.length; $i++){
													eventdates.push(response.secondResponse.data[$i]);
							}
							for($i = 0; $i <= response.thirdResponse.data.length; $i++){
											eventdates.push(response.thirdResponse.data[$i]);
										
							}
							
							eventdates = eventdates.filter(function( element ) {
   						return element !== undefined;
							});
							
								$log.log('Final ' + eventdates.length);
							
							for($i = 0; $i <= eventdates.length-1; $i++){
										//if(eventdates[$i].event_start_date != ''){
											if( combinedList.indexOf(eventdates[$i].event_start_date) == -1 ){
													combinedList.push(eventdates[$i].event_start_date);
											}	
										//}	
						}
						for($i = 0; $i <= combinedList.length-1; $i++){
								$log.log(combinedList[$i]);
						}
      }, function(error) {
        $scope.data = error;
      });																		
																													
															}														
											]);*/

app.controller('MainController', ['$scope', '$http', '$log', '$q', 'eventFactory',
    function($scope, $http, $log, $q, eventFactory) {
      $scope.data = {};
      var data1 = eventFactory.getData(mylcccapi.query, 'GET');
      var data2 = eventFactory.getData(athleticsapi.query, 'GET');
      var data3 = eventFactory.getData(stockerapi.query, 'GET');
					//	var list = combinedData(data1,data2,data3);
						$http.get(mylcccapi.query).success(function(data){
										$scope.data = data;																	
						});
						console.log('main',$scope.data);
    }																														
  ]);

app.controller( 'MyCtrl',['$scope', '$q', '$timeout', 'eventFactory',
 function($scope, $q, $timeout, eventFactory){  
   var thenFn = function(value){
       console.log('resolved ', value);
       return value;
   },
  // q1 = $scope.q1 = $q.defer(),
  // q2 = $scope.q2 = $q.defer(),
  // p1 = $scope.q1.promise,
  // p2 = $scope.q2.promise,
 //var data1 = eventFactory.getData(mylcccapi.query, 'GET');
   q3 = $scope.q3 = $q.defer(),
   p3 = $scope.q3.promise;
   
   $scope.fromThen = $q.all([
                           //p1.then(thenFn),
                           //p2.then(thenFn),
                           p3.then(thenFn),
                       ])
                       .then(function(values) {        
                           console.log('values', values);
                           return values;
   });
   
   // Must start the AngularJS digest process
   // to allow $q.resolve() to work properly
   // So use $timeOut() or $apply()
   
   setTimeout(function () {
   
       $scope.$apply( function() {            
           console.log('resolving delayed promises');
           //q1.resolve({value : 1});
           //q2.resolve({value : 2});
           q3.resolve({value : 3});
       });
   }, 100, this);
   

   
   /*
    *  Alternative approach
    *
   $timeout( function() {
       console.log('resolving delayed promises');
       q1.resolve({value : 1});
       q2.resolve({value : 2});        
   });
   */
		}
]);



app.controller("calendarDemo", function($scope) {
    $scope.day = moment();
})

app.directive("calendar", function($http) {
    return {
        restrict: "E",
        templateUrl: "/wp-content/themes/lorainccc-subsite/js/angularjs-templates/angular-calendar-temp.php",
        scope: {
            selected: "=",
        },
        link: function(scope) {
										
            scope.selected = _removeTime(scope.selected || moment());
            scope.month = scope.selected.clone();

            var start = scope.selected.clone();
            //Start of the month
												start.date(1);
            _removeTime(start.day(0));

            _buildMonth(scope, start, scope.month);

            scope.select = function(day) {
                scope.selected = day.date;
            };

            scope.next = function() {
                var next = scope.month.clone();
										_removeTime(next.month(next.month()+1).date(1).day(0));
                scope.month.month(scope.month.month()+1);
                _buildMonth(scope, next, scope.month);
            };

            scope.previous = function() {
                var previous = scope.month.clone();
  _removeTime(previous.month(previous.month()-1).date(1).day(0));
                scope.month.month(scope.month.month()-1);
                _buildMonth(scope, previous, scope.month);
            };
        }
    };
    
    function _removeTime(date) {
        //return date.day(0).hour(0).minute(0).second(0).millisecond(0);
								return date.startOf('day');
    }

    function _buildMonth(scope, start, month) {
        scope.weeks = [];
        var done = false, date = start.clone(), monthIndex = date.month(), count = 0;
        while (!done) {
            scope.weeks.push({ days: _buildWeek(date.clone(), month) });
            date.add(1, "w");
            done = count++ > 2 && monthIndex !== date.month();
            monthIndex = date.month();
        }
    }

    function _buildWeek(date, month) {
        var days = [];
					
								for (var i = 0; i < 7; i++) {

									   days.push({
                name: date.format("dd").substring(0, 1),
                number: date.date(),
																full: date.format("YYYY-MM-DD").substring(0, 10),
                isCurrentMonth: date.month() === month.month(),
                isToday: date.isSame(new Date(), "day"),
                date: date
            });
            date = date.clone();
            date.add(1, "d");
        }
        return days;
    }

	

	
});



