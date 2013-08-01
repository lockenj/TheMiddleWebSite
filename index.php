<?php include_once $_SERVER['DOCUMENT_ROOT'].'/include/_header.php'; ?>
<section id="home_page" ng-init="homeVid={file: 'http://content.bitsontherun.com/videos/lWMJeVvV-364767.mp4',image: 'http://www.longtailvideo.com//content/images/jw-player/lWMJeVvV-876.jpg'}">  
  <door-frame>
    <jw-player width="100%" height="500px" video="homeVid" id="video_player"></jw-player>      
  </door-frame>
  <div id="links">
    <a href="/boxset"><img src="/images/home/box_set.png"/></a>
    <a href="/videos"><img class="left_link_img" src="/images/home/videos.png"/></a>
    <a href="/wallpapers"><img class="right_link_img" src="/images/home/wallpapers.png"/></a>
    <a href="/avatars"><img class="left_link_img" src="/images/home/avatars.png"/></a>
    <a href="/pictures"><img class="right_link_img" src="/images/home/pictures.png"/></a>
  </div>
</section>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/include/_footer.php'; ?>