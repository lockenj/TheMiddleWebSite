<?php include_once $_SERVER['DOCUMENT_ROOT'].'/include/_header.php'; ?>
<section id="home_page" data-ng-controller="VideosCtrl">  
  <door-frame>
    <jwplayer ng-if="showStartSplashScreen === undefined" width="100%" height="480px" video="video" id="video_player">
      <img ng-if="showSplashScreenWhenFinished !== undefined" ng-src="{{showSplashScreenWhenFinished.image}}" alt="{{showSplashScreenWhenFinished.alt}}" />
    </jwplayer> 
    <img ng-if="showStartSplashScreen !== undefined" ng-src="{{showStartSplashScreen.image}}" alt="{{showStartSplashScreen.alt}}" />     
  </door-frame>
  <div id="links">
    <a><img src="/images/home/box_set.jpg"/></a>
    <a href="/videos"><img class="left_link_img" src="/images/home/videos.png"/></a>
    <a href="/downloads/#/wallpapers"><img class="right_link_img" src="/images/home/wallpapers.png"/></a>
    <a href="/downloads/#/avatars"><img class="left_link_img" src="/images/home/avatars.png"/></a>
    <a href="/downloads/#/photos"><img class="right_link_img" src="/images/home/pictures.png"/></a>
  </div>
</section>
<?php
  if(!isset($scriptsToBeRendered)){
    $scriptsToBeRendered = array();
  } 
  array_push($scriptsToBeRendered,'/js/homePageApp.js');
  include_once $_SERVER['DOCUMENT_ROOT'].'/include/_footer.php'; 
?>