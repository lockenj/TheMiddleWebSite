app.factory("EpisodeGuideFctry",function(){
  var seasons = [    
    {
      year: 'one',
      description: 'someUrl'
    },
    {
      year: 'two',
      description: 'someUrl'
    },
    {
      year: 'three',
      description: 'someUrl' 
    },
    {
      year: 'four',
      description: 'someUrl'
    }    
  ];
  var selectedSeason = seasons[0];
  return {
    getSeasons: function(){
      return seasons;
    },
    getSelectedSeason: function(){
      return selectedSeason;
    },
    setSelectedSeason: function(season){
      selectedSeason = season;
    }
  }
});

app.controller('EpisodeGuideCtrl', function($scope, EpisodeGuideFctry) {
  $scope.episodeGuideFctry = EpisodeGuideFctry;  
});