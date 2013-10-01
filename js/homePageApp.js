app.controller('VideosCtrl', function($scope,$http) {
  angular.extend($scope, {
    video: undefined,
    useSplashScreen: undefined
  });
  
  $http.get("/content/homePage.json").success(function(data) {
    angular.extend($scope,data);
  });
  
  
  //when the video changes
  $scope.$watch('video', function(newValue, oldValue) {
    $scope.$broadcast('JWPLAYER_VIDEO_CHANGED', {
      newValue: newValue,
      oldValue: oldValue,
      autoStart: true
    });
  },true);
});