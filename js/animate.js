var animate = angular.module('animate',['ui.bootstrap']);

animate.controller('animateCtrl', function($scope, $http){
		
	$scope.signupState = true;
	
	$scope.signupClicked = function(){		
		$scope.signupState = !$scope.signupState;
	};	
	
	$scope.recalls = {};
	$http.get('get_recalls.php').then( function(data){
			$scope.recalls = data.data;	
			console.log($scope.recalls);
		}
	);	
	
	
	$scope.addPost = function(){
		
		
		var date = new Date();
		
		$scope.toPost.Time = date.getFullYear() + "-" + date.getMonth() + "-" + date.getDate() + " " 
		+ date.getHours() + ":" + date.getMinutes() + ":" + date.getSeconds();			
		console.log($scope.toPost);
		
		$scope.recalls.unshift(angular.copy($scope.toPost));	
		
	};
	
	
});






