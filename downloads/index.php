<?php include_once $_SERVER['DOCUMENT_ROOT'].'/include/_header.php'; ?>
<section id="downloadsPage" data-ng-controller="DownloadsCtrl">
  <door-frame>
    <ng-view ng-animate="{enter: 'page-transition-enter', leave: 'page-transition-leave'}"></ng-view>
    
    
    <div class="sub_menu_selector">
      <h1>Downloads</h1>            
      <div class="sub_menu">
        <div class="sub_menu_item" 
          data-ng-repeat="option in menuOptions" 
          data-ng-click="setSelectedMenuOption(option)">
          <h2>
            <img class="selection_indicator" src="/images/selection_indicator.png" data-ng-show="isActiveOption(option)"/>
            {{option.label}}
          </h2>          
        </div>
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