<?php include_once $_SERVER['DOCUMENT_ROOT'].'/include/_header.php'; ?>
<section id="contactUsPage">
  <door-frame>
  <?php 
    $request_method = strtolower($_SERVER['REQUEST_METHOD']);
    switch ($request_method)
    {
      case 'get':
      ?>
        <h1>Check For Local Listings.</h1>
        <hr />
        <p>Enter your zip code below.</p>
        <form method="post" action="/local_listings/">      
          <p>Zipcode</p>        
          <input name="zipcode" required/>          
          <input type="submit" name="submit" value="SUBMIT"> 
        </form>
      <?php
      break;  
      case 'post':
        require_once $_SERVER['DOCUMENT_ROOT'].'/local_listings/submitLocalListings.php';      
      break;
    }  
  ?>    
  </door-frame>
</section>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/include/_footer.php'; ?>