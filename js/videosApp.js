app.controller('VideosCtrl', function($scope,$http) {
  angular.extend($scope, {
    videos: undefined,
    selectedVideo: undefined,
    getSelectedVideo: function(){
      return $scope.selectedVideo;
    },
    setSelectedVideo: function(vid){
      $scope.selectedVideo = vid;
    }
  });
  
  $http.get("/content/videos/videos.json").success(function(data) {
    $scope.videos = data;
    $scope.setSelectedVideo($scope.videos[0]);
  });
  
  
  //when the video changes
  $scope.$watch('selectedVideo', function(newValue, oldValue) {
    $scope.$broadcast('JWPLAYER_VIDEO_CHANGED', {
      newValue: newValue,
      oldValue: oldValue
    });
  },true);
});