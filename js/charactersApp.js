app.factory("CharactersFctry", ['$http', function($http){
  var characters;
  var selectedCharacter;
  
  $http.get("/content/characters/characters.json").success(function(data) {
    characters = data;
    selectedCharacter = characters[0];
  });
  
  return {
    getCharacters: function(){
      return characters;
    },
    getSelectedCharacter: function(){
      return selectedCharacter;
    },
    setSelectedCharacter: function(character){
      selectedCharacter = character;
    }
  }
}]);

app.controller('CharactersCtrl', function($scope, CharactersFctry) {
  $scope.charactersFctry = CharactersFctry;  
});