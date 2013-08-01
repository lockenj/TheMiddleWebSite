app.factory("PhotosFctry", ['$http', function($http){
  var photos;
  var downloadType = 'photos';
  
  $http.get("/downloads/getAllPhotos.php").success(function(data) {
    photos = data;
  });
  
  return {
    getPhotos: function(url){
      return photos;
    },
    getDownloadType: function(){
      return downloadType;
    }
  }
}]);

app.controller('DownloadsCtrl', function($scope, PhotosFctry) {  
  $scope.photosFctry = PhotosFctry;  
});