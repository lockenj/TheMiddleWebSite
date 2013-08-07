/* jwPlayer Directive */
angular.module('jwplayer', [])
  .directive('jwplayer', function($timeout) {
    var uniqueId = 0;
    if(window.jwplayerUniqueId){
      uniqueId = window.jwplayerUniqueId ++;
    }
    var id = 'jwplayer_content_'+uniqueId;
        
    return {
      restrict: 'E',
      template: '<div id="'+id+'" class="jwplayer_content"></div>',
      link: function(scope, element, attrs) { 
        scope.videoWidth = attrs.width;
        scope.videoHeight = attrs.height;
        /*
        var autoStart = false;
        if(attrs.autostart != undefined){
          autoStart = true;
        }
        //After content has been rendered
        $timeout(function () {
            $timeout(function () {
              // This code will run after templateUrl has been loaded, cloned and transformed by directives, and properly rendered by the browser
              var video = scope[attrs.video];
              
              var videoPlayer = jwplayer(id).setup({
                file: video.file,
                image: video.image,
                title: video.name,
                autostart: autoStart,
                width: attrs.width,
                height: attrs.height
              });
            }, 0);
        }, 0);*/
      },
      controller: function($scope){
        //Receive videoChanged Event
        $scope.$on("JWPLAYER_VIDEO_CHANGED", function(event, eventData) {
          video = eventData.newValue;
          var startNow = false;
          if (eventData.autoStart) {
            startNow = true;
          }
          jwplayer(id).setup({
            file: video.file,
            image: video.image,
            width: '100%',
            aspectratio: '16:9',
            fallback: true,
            /*primary: 'flash',*/
            autostart: startNow
          });
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
	.directive('scrollable',function($timeout){  
    return {
      restrict: 'E',
      transclude: true,
      templateUrl: '/js/partials/scrollable.html',
      link: function(scope, element, attrs){
        scope.upBtnText = attrs['upbtntext'];
        scope.downBtnText = attrs['downbtntext'];
        var scrollableWindowElement = element.find(".scrollable_window");
        scope.setbreakHeight(scrollableWindowElement.height());
        
        var currentHeight;
        
        //After content has been rendered
        $timeout(function () {
            $timeout(function () {
              // This code will run after templateUrl has been loaded, cloned and transformed by directives, and properly rendered by the browser
              var contentElement = element.find(".scrollable_content");
              currentHeight = contentElement.height();
              scope.setContentHeight(currentHeight);
            }, 0);
        }, 0);
        
        //TODO find a better way to do this in the future
        function detectHeightChange(){
          $timeout(function () {
            // This code will run after templateUrl has been loaded, cloned and transformed by directives, and properly rendered by the browser
            var contentElement = element.find(".scrollable_content");
            var latestHeight = contentElement.height();
            if(currentHeight !== latestHeight){
              console.log('Height Changed!!!');
              scope.recalculate(latestHeight);
            }
            detectHeightChange();
          }, 500);
        }
        detectHeightChange();
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
        
        //Keep the breakpoints in sync with the size
        $scope.$watch('[contentHeight, breakHeight]', function (newValue, oldValue) { 
          setBreakpoints();
        },true);
        
       //Keep the top var in sync
        $scope.$watch('[breakpoints, currentBreakpoint]', function (newValue, oldValue) { 
          $scope.top = $scope.breakpoints[$scope.currentBreakpoint];
          setContentStyle();
        }, true);
        
        //keep atTop and atBottom in sync
        $scope.$watch('[currentBreakpoint]', function (newValue, oldValue) { 
            if($scope.currentBreakpoint === 0){
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
        },true);
        
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
        };
        
        $scope.setContentHeight = function(ht){
          $scope.contentHeight = ht;
        };
        
        $scope.recalculate = function(ht){
          $scope.setContentHeight(ht);
          setBreakpoints();
          $scope.currentBreakpoint = 0;
        };
      }
    };
  });

var app = angular.module('tm-app', ['doorFrame','scrollable','jwplayer','ui.bootstrap']);

app.controller('MainCtrl', function($scope) {
	
});