/* jwPlayer Directive */
angular.module('jwPlayer', [])
  .directive('jwPlayer', function() {
    return {
      restrict: 'E',      
      link: function(scope, element, attrs) { 
        var video = scope[attrs.video];
        jwplayer(attrs.id).setup({
          file: video.file,
          image: video.image,
          width: attrs.width,
          height: attrs.height
        });
      }
    };
  });

/* Door Frame Directive */
angular.module('doorFrame', [])
  .directive('doorFrame', function() {
    return {
      transclude: true,
      restrict: 'EA',
      templateUrl: '/js/partials/door_frame.html',
      link: function(scope, element, attrs) {
    	  element.addClass("door_frame");
      }
    };
  });

/* Scrollable Directive */
angular.module('scrollable',[])
	.directive('scrollable',function(){  
	  return {
	    restrict: 'E',
	    transclude: true,
	    templateUrl: '/js/partials/scrollable.html',
	    link: function(scope, element, attrs){
	      var scrollableWindowElement = element.find(".scrollable_window");
	      scope.setbreakHeight(scrollableWindowElement.height());
	      var contentElement = element.find(".scrollable_content");
	      var ht = contentElement.height();
	      scope.setContentHeight(ht);
	      scope.upBtnText = attrs['upbtntext'];
	      scope.downBtnText = attrs['downbtntext'];
	    },
	    controller: function($scope){
	      $scope.atTop;
	      $scope.atBottom;
	      $scope.top;
	      $scope.breakpoints = [];
	      $scope.currentBreakpoint = 0;
	      $scope.breakHeight;
	      $scope.contentHeight;
	      $scope.numOfBreakSegments;
	      
	      //Keep the top var in sync
	      $scope.$watch('[breakpoints, currentBreakpoint]', function () { 
	        $scope.top = $scope.breakpoints[$scope.currentBreakpoint];
	        setContentStyle();
	      }, true);
	      
	      //keep atTop and atBottom in sync
	      $scope.$watch('[currentBreakpoint]', function () { 
	          if($scope.currentBreakpoint == 0){
	            $scope.atTop = true;
	          }
	          else{
	            $scope.atTop = false;
	          }
	          
	          if($scope.currentBreakpoint === ($scope.breakpoints.length -1)){
	            $scope.atBottom = true;
	          }
	          else{
	            $scope.atBottom = false;
	          }
	      });
	      
	      function setContentStyle(){
	        $scope.contentStyle = {
	          position: 'relative',
	          top: '-'+$scope.top+'px'
	       } 
	      }
	      
	      function setBreakpoints(){
	        if($scope.breakHeight && $scope.contentHeight){
	          $scope.numOfBreakSegments = Math.floor($scope.contentHeight/$scope.breakHeight)
	          
	          var index = 0;
	          $scope.breakpoints = [];
	          while(index <= $scope.numOfBreakSegments){
	            $scope.breakpoints.push($scope.breakHeight * index);  
	            index ++;
	          }
	        }
	      }
	      
	      $scope.moveUp = function(){
	        if($scope.currentBreakpoint > 0){
	          $scope.currentBreakpoint --;
	        }
	      }
	      $scope.moveDown = function(){
	        if($scope.currentBreakpoint < ($scope.breakpoints.length -1)){
	          $scope.currentBreakpoint ++;
	        }
	      }
	      
	      $scope.setbreakHeight = function(ht){
	        $scope.breakHeight = ht;
	        setBreakpoints();
	      };
	      
	      $scope.setContentHeight = function(ht){
	        $scope.contentHeight = ht;
	        setBreakpoints();
	      }
	    }
	  };
	});

var app = angular.module('tm-app', ['doorFrame','scrollable','jwPlayer']);

app.controller('MainCtrl', function($scope) {
	
});