app.config(function ($routeProvider) {
  $routeProvider
  .when('/photos', {
    templateUrl:'/downloads/partials/photos.html',
    controller: 'PhotosCtrl'
  })
  .when('/wallpapers', {
    templateUrl:'/downloads/partials/wallpapers.html',
    controller: 'WallpapersCtrl'
  })
  .when('/avatars', {
    templateUrl:'/downloads/partials/avatars.html',
    controller: 'AvatarsCtrl'
  })
  .otherwise({
    redirectTo:'/photos'
  });
});

/*PHOTOS*/
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

app.controller('PhotosCtrl', function($scope, PhotosFctry) {  
  $scope.photosFctry = PhotosFctry;  
});


/*Wallpapers*/
app.factory("WallpapersFctry", ['$http', function($http){
  var wallpapers;
  var downloadType = 'photos';
  
  $http.get("/content/wallpapers/wallpapers.json").success(function(data) {
    wallpapers = data;
  });
  
  return {
    getWallpapers: function(url){
      return wallpapers;
    }
  }
}]);

app.controller('WallpapersCtrl', function($scope, WallpapersFctry, $dialog) {  
  $scope.wallpapersFctry = WallpapersFctry;  
  $scope.wallPaperSelected = function(wallpaper, sizeInfo){
    //console.log("",wallpaper,size);
    window.open(sizeInfo.imageUrl)
  }
  
  $scope.openInstructionsDialog = function(osType){
    var opts = {
      backdrop: true,
      keyboard: true,
      backdropClick: true,
      controller: 'DialogCtrl'
    };
    
    opts.templateUrl = "/downloads/partials/"+osType+"_wallpapers_instructions.html";
    var dlg = $dialog.dialog(opts);
    dlg.open();
  };
});

app.controller('DialogCtrl', function($scope, dialog) { 
  $scope.closeInstructions = function(result){
    dialog.close(result);
  };
});

/*Avatars*/
app.factory("AvatarsFctry", ['$http', function($http){
  var avatars = [
    {name:"sue", iconUrl:"/images/downloads/avatars/sue_avatar.jpg"},
    {name:"mike", iconUrl:"/images/downloads/avatars/mike_avatar.jpg"},
    {name:"frankie", iconUrl:"/images/downloads/avatars/frankie_avatar.jpg"},
    {name:"brick", iconUrl:"/images/downloads/avatars/brick_avatar.jpg"},
    {name:"axl", iconUrl:"/images/downloads/avatars/axl_avatar.jpg"}
  ];
  
  return {
    getAvatars: function(url){
      return avatars;
    }
  }
}]);

app.controller('AvatarsCtrl', function($scope, AvatarsFctry, $dialog) {  
  $scope.avatarsFctry = AvatarsFctry;
  
  $scope.openInstructions = function(messengerType){
    var opts = {
      backdrop: true,
      keyboard: true,
      backdropClick: true,
      controller: 'DialogCtrl'
    };
    
    opts.templateUrl = "/downloads/partials/"+messengerType+"_avatars_instructions.html";
    var dlg = $dialog.dialog(opts);
    dlg.open();
  };
});

/*Downloads*/
app.controller('DownloadsCtrl', function($scope, $location) {   
  angular.extend($scope, {
    menuOptions:[
      {label: "Photos", location: "/photos"},
      {label: "Wallpapers", location: "/wallpapers"},
      {label: "Avatars", location: "/avatars"},
    ],
    selectedMenuOption: undefined,
    getLocationClass: function(path) {
      var path = $location.path();
      return path.substr(1, path.length);
    },
    menuClicked: function(menuOption){      
      $location.path(menuOption.location)
    },
    setSelectedMenuOption: function(option){
      $scope.selectedMenuOption = option;
      $scope.menuClicked(option);
    } ,
    isActiveOption: function(option){
      return angular.equals($scope.selectedMenuOption, option);
    }
  });
  $scope.setSelectedMenuOption($scope.menuOptions[0]);
});
