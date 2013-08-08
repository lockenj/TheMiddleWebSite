<?php
  function echoSelectedPageClass($menuItem){
    if(isset($_SERVER["REQUEST_URI"])){
      $parentFolderName = ltrim(basename($_SERVER["REQUEST_URI"]),'/');      
      
      if($parentFolderName == $menuItem){
        echo("active");
      }  
    }   
  }
?>
<!DOCTYPE html>
<html lang="en-US" data-ng-app="tm-app">
  <head>
    <!-- Force Google Chrome Frame if its installed -->
		<meta http-equiv="X-UA-Compatible" content="chrome=1"/>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="description" content="The Middle Weeknights." />
		<meta name="keywords" content="The Middle Weeknights" />
		<meta name="robots" content="archive, index, follow" />
		<meta name="viewport" content="width=1280px">
		<!-- Render custom META tags -->
		<?php if(function_exists('renderMeta')){renderMeta();} ?>				
		<link href="/css/screen.css" media="screen, projection" rel="stylesheet" type="text/css" />
		<link href="/js/libs/lightbox/css/lightbox.css" rel="stylesheet" />
		<!-- Render the CSS <link> tags -->
		<?php if(function_exists('renderCSSLinks')){renderCSSLinks();} ?>					
		<title>The Middle</title>
	</head>
	<body>
    <section id="page">
      <header>        
        <a href="/"><img src="/images/the_middle_logo.png" alt="The Middle - your Every Day family"/></a>        
        <img id="times" src="/images/tune_in_time.png" />
        <nav id="main_menu">          
          <ul class="nav navbar-nav">
            <li><a href="/" class='home_nav_item <?php echoSelectedPageClass(''); ?>'></a></li>
            <li><a href="/videos" class='videos_nav_item <?php echoSelectedPageClass('videos'); ?>'></a></li>
            <li><a href="/characters" class='characters_nav_item <?php echoSelectedPageClass('characters'); ?>'></a></li>
            <li><a href="/episode_guide" class='episode_guide_nav_item <?php echoSelectedPageClass('episode_guide'); ?>'></a></li>
            <li><a href="/downloads" class='downloads_nav_item <?php echoSelectedPageClass('downloads'); ?>'></a></li>
          </ul>
        </nav>
      </header>
      <section id="page_main_content">
      
