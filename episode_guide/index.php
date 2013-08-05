<?php include_once $_SERVER['DOCUMENT_ROOT'].'/include/_header.php'; ?>
<section id="episode_guide_page" data-ng-controller="EpisodeGuideCtrl">
  <door-frame>
    <div id="season_selector" class="sub_menu_selector">
      <h1>Episode Guide</h1>
      <div id="season_menu" class="sub_menu">        
        <div class="season_menu_item sub_menu_item" 
          data-ng-repeat="season in episodeGuideFctry.getSeasons()" 
          data-ng-click="episodeGuideFctry.setSelectedSeason(season)">
          <h2>
            <img class="selection_indicator" src="/images/selection_indicator.png" data-ng-show="episodeGuideFctry.isActiveSeason(season)"/>
            Season {{season.number}}
          </h2>
          
        </div>
      </div>
    </div>
    <div class="season_description">
      <scrollable>
      <div class="season_episode" data-ng-repeat="episode in episodeGuideFctry.getSelectedSeason().episodes">
        <h2>Episode {{episode.number}} / <span class="episode_name">{{episode.name}}</span> </h2>
        <div class="episode_descripiton" data-ng-bind-html-unsafe="episode.description"></div>        
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