<?php include_once $_SERVER['DOCUMENT_ROOT'].'/include/_header.php'; ?>
<section id="characters_page" data-ng-controller="CharactersCtrl">
  <door-frame>
    <div id="characters_selector">
      <img class="selection_indicator {{charactersFctry.getSelectedCharacter().name}}" data-ng-src="/images/selection_indicator.png"/>      
      <div data-ng-repeat="char in charactersFctry.getCharacters()" data-ng-click="charactersFctry.setSelectedCharacter(char)">
        <img data-ng-src="/images/characters/{{char.name}}_head.png" alt="{{char.name}}'s head."/>
        <h4>{{char.name}}</h4>        
      </div>
    </div>
    <div id="characters_description">
      <h1>{{charactersFctry.getSelectedCharacter().description}}</h1>
      <scrollable>
        <div  data-ng-bind-html-unsafe="charactersFctry.getSelectedCharacter().bio"></div>
      </scrollable>      
    </div>
    <img class="full_length" src="/images/characters/{{charactersFctry.getSelectedCharacter().name}}.png" />
  </door-frame>
</section>
<?php
  if(!isset($scriptsToBeRendered)){
    $scriptsToBeRendered = array();
  } 
  array_push($scriptsToBeRendered,'/js/charactersApp.js');
  include_once $_SERVER['DOCUMENT_ROOT'].'/include/_footer.php'; 
?>