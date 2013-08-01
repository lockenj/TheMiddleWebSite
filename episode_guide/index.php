<?php include_once $_SERVER['DOCUMENT_ROOT'].'/include/_header.php'; ?>
<section id="episode_guide_page" data-ng-controller="EpisodeGuideCtrl">
  <door-frame>
    <div id="season_selector">
      <h1>Episode Guide</h1>
      <div id="season_menu">
        <img class="selection_indicator {{episodeGuideFctry.getSelectedSeason().year}}" src="/images/selection_indicator.png"/>
        <div class="season_menu_item" data-ng-repeat="season in episodeGuideFctry.getSeasons()" data-ng-click="episodeGuideFctry.setSelectedSeason(season)"></div>
      </div>
    </div>
    <div id="season_description">
      <h2>Season {{episodeGuideFctry.getSelectedSeason().year}}</h2>
      <scrollable>
        <div id="lipsum">
          <p>
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas mollis malesuada blandit. Donec mollis quam in tempus eleifend. Donec cursus nunc mauris, nec fringilla justo eleifend vel. Cras sed mauris quam. In neque orci, placerat vel dignissim sit amet, aliquet et arcu. Sed nec urna feugiat, pulvinar magna sit amet, tincidunt dolor. Pellentesque ac nulla scelerisque, interdum nisl quis, pharetra lorem. Proin iaculis tempus eros, nec varius justo elementum vitae. Aenean rhoncus posuere ipsum, posuere placerat nulla aliquet vel. Quisque consectetur pharetra tristique. Cras facilisis nunc et ipsum sollicitudin, convallis euismod odio fringilla. Donec lectus mauris, tempus sed tempus at, tincidunt vitae turpis. Nulla et congue tortor. Sed tristique eget diam dignissim mollis. Proin pretium feugiat ipsum, et semper sem egestas dignissim.
          </p>
          <p>
          Cras viverra dui sit amet mattis gravida. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Sed bibendum pellentesque dui nec blandit. Donec imperdiet pulvinar odio ut ullamcorper. Nam varius a odio eu facilisis. Sed vel diam id dui sollicitudin egestas non id sem. Nam imperdiet orci sapien, id malesuada urna luctus eget. Cras ante nisl, tempus non enim sit amet, condimentum facilisis massa. Nulla facilisi.
          </p>
          <p>
          Curabitur at faucibus nibh. Suspendisse hendrerit luctus consectetur. Donec lobortis mauris non tellus fermentum, eu ullamcorper dui adipiscing. Duis sodales leo sed feugiat eleifend. Ut tempor fringilla lorem, commodo faucibus nibh tristique et. Nam sed ante varius, dapibus justo vitae, adipiscing augue. Aliquam erat orci, volutpat a tincidunt eu, laoreet in dolor. Curabitur vehicula non massa vitae pellentesque.
          </p>
          <p>
          Nunc fermentum augue eu nunc faucibus, nec fringilla metus volutpat. Morbi tristique tortor purus. Fusce bibendum, quam vitae convallis feugiat, dolor metus lacinia dui, non aliquam massa libero eget risus. Curabitur vel libero posuere, pharetra diam eget, commodo arcu. Phasellus nec erat cursus, tempor velit sit amet, consectetur elit. Phasellus sed odio non mi aliquam feugiat. Donec tincidunt purus id est sollicitudin, tincidunt ultricies lacus lacinia. Ut mattis consectetur velit a porta. Quisque non ipsum quis ipsum vulputate dictum eget vitae nunc. Pellentesque sem ipsum, varius sed nisi ac, viverra auctor massa. Curabitur tristique lacus faucibus consequat tempus.
          </p>
          <p>
          Mauris pulvinar ultricies turpis, eget vehicula libero bibendum a. Sed commodo tincidunt tortor ut placerat. Nulla ac mollis magna. Phasellus felis massa, posuere nec mattis eu, tempus quis magna. Vestibulum luctus sapien nec neque vestibulum lacinia. Aliquam vehicula mi ligula, vel mollis nisl tempor vitae. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Etiam eget mi ante. Aenean volutpat massa eget accumsan venenatis. Quisque non augue felis.
          </p>
         </div>
      </scrollable>      
    </div>
    <img id="family_photo" src="/images/episode_guide/family.png"/>
  </door-frame> 
</section>
<?php
  if(!isset($scriptsToBeRendered)){
    $scriptsToBeRendered = array();
  } 
  array_push($scriptsToBeRendered,'/js/episodeGuideApp.js');
  include_once $_SERVER['DOCUMENT_ROOT'].'/include/_footer.php'; 
?>