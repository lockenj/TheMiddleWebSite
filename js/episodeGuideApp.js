app.factory("EpisodeGuideFctry",['$http', function($http){
  var seasons;
  var selectedSeason;
  
  $http.get("/content/seasons/seasons.json").success(function(data) {    
    seasons = data;
    selectedSeason = seasons[0];
  });
  
  return {
    getSeasons: function(){
      return seasons;
    },
    getSelectedSeason: function(){
      return selectedSeason;
    },
    setSelectedSeason: function(season){
      selectedSeason = season;
    },
    isActiveSeason: function(season){
      return angular.equals(selectedSeason, season);
    }
  }
}]);

app.controller('EpisodeGuideCtrl', function($scope, EpisodeGuideFctry) {
  $scope.episodeGuideFctry = EpisodeGuideFctry;  
});