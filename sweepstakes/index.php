<?php include_once $_SERVER['DOCUMENT_ROOT'].'/include/_header.php'; ?>
<section id="sweepstakes_page">
  <ng-view ng-animate="{enter: 'page-transition-enter', leave: 'page-transition-leave'}"></ng-view>  
</section>
<?php
  if(!isset($scriptsToBeRendered)){
    $scriptsToBeRendered = array();
  } 
  array_push($scriptsToBeRendered,'/js/sweepstakesApp.js');
  include_once $_SERVER['DOCUMENT_ROOT'].'/include/_footer.php'; 
?>