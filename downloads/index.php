<?php include_once $_SERVER['DOCUMENT_ROOT'].'/include/_header.php'; ?>
<section id="downloadsPage" data-ng-controller="DownloadsCtrl">
  <door-frame>
    <div id="downloads_selector">
      <h1>Downloads</h1>
      <div id="downloads_menu">
        <img class="selection_indicator" src="/images/selection_indicator.png"/>
        <!--
        <img class="selection_indicator {{episodeGuideFctry.getSelectedSeason().year}}" src="/images/selection_indicator.png"/>
                <div class="season_menu_item" data-ng-repeat="season in episodeGuideFctry.getSeasons()" data-ng-click="episodeGuideFctry.setSelectedSeason(season)"></div>-->        
      </div>
    </div>
    <div id="photos">
      <h1>Photos</h1>    
      <scrollable>
        <a href="{{image.large}}" data-lightbox="photos" data-ng-repeat="image in photosFctry.getPhotos()">
          <img class="thumb" src="{{image.thumb}}"/>
        </a>
      </scrollable>
    </div>
  </door-frame>
</section>
<?php
  if(!isset($scriptsToBeRendered)){
    $scriptsToBeRendered = array();
  } 
  array_push($scriptsToBeRendered,'/js/downloadsApp.js');
  include_once $_SERVER['DOCUMENT_ROOT'].'/include/_footer.php'; 
?>