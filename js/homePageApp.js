app.controller('VideosCtrl', function($scope,$http) {
  angular.extend($scope, {
    video: undefined    
  });
  
  $http.get("/content/homePage.json").success(function(data) {
    $scope.video = data.video;
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