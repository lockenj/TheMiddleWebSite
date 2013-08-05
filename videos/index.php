<?php include_once $_SERVER['DOCUMENT_ROOT'].'/include/_header.php'; ?>

<section id="videos_page" data-ng-controller="VideosCtrl">
  <door-frame>
    <div id="video_viewer">
      <h1>Videos</h1>  
      <jwplayer video="selectedVideo" width="650px" height="375px"></jwplayer>
      <h2>{{selectedVideo.name}}</h2>
    </div>
    <div id="video_selector">
      <h1>Videos</h1>
      <scrollable id="videos">    
        <ul>
          <li data-ng-click="setSelectedVideo(video)" data-ng-repeat="video in videos">          
            <img ng-src="{{ video.image }}" alt="{{ video.name }} video."/>
          </li>
        </ul>  
      </scrollable>
    </div>
  </door-frame>  
</section>
<?php
  if(!isset($scriptsToBeRendered)){
    $scriptsToBeRendered = array();
  } 
  array_push($scriptsToBeRendered,'/js/videosApp.js');
  include_once $_SERVER['DOCUMENT_ROOT'].'/include/_footer.php'; 
?>