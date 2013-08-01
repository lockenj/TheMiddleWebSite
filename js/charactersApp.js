app.factory("CharactersFctry",function(){
  var characters = [    
    {
      name: 'frankie',
      description: 'FRANKIE / PATRICIA HEATON'
    },
    {
      name: 'mike',
      description: 'MIKE / NEIL FLYNN'
    },
    {
      name: 'axl',
      description: 'AXL / CHARLIE McDERMOTT' 
    },
    {
      name: 'sue',
      description: 'BRICK / ATICUS SHAFFER'
    },
    {
      name: 'brick',
      description: 'SUE / EDEN SHER'
    }
  ];
  var selectedCharacter = characters[0];
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
});

app.controller('CharactersCtrl', function($scope, CharactersFctry) {
  $scope.charactersFctry = CharactersFctry;  
});