var module = angular.module("lcccEventModule", []);

module.provider("MyProvider", function() {
															this.$get = function() {
																return "My Value";
															};
});

module.controller("LcccEventController", function(MyProvider) {
			console.log("MyProvider: " + MyProvider);
});