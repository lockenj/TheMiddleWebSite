<?php include_once $_SERVER['DOCUMENT_ROOT'].'/include/_header.php'; ?>
<section id="home_page" ng-init="homeVid={'name':'Sound Familiar', 'file':'/content/videos/Main_SoundFamiliar.mp4', 'image':'/images/home/home_page_no_video.jpg'}">  
  <door-frame>
    <jwplayer autostart width="100%" height="480px" video="homeVid" id="video_player"></jwplayer> 
    <!--<img src="/images/home/home_page_no_video.jpg" alt="The Middle - your Every Day family" />-->     
  </door-frame>
  <div id="links">
    <a><img src="/images/home/box_set.jpg"/></a>
    <a href="/videos"><img class="left_link_img" src="/images/home/videos.png"/></a>
    <a href="/downloads/#/wallpapers"><img class="right_link_img" src="/images/home/wallpapers.png"/></a>
    <a href="/downloads/#/avatars"><img class="left_link_img" src="/images/home/avatars.png"/></a>
    <a href="/downloads/#/photos"><img class="right_link_img" src="/images/home/pictures.png"/></a>
  </div>
</section>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/include/_footer.php'; ?>