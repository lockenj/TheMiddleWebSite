<?php include_once $_SERVER['DOCUMENT_ROOT'].'/include/_header.php'; ?>
<section id="contactUsPage">
  <door-frame>
  <?php 
    $request_method = strtolower($_SERVER['REQUEST_METHOD']);
    switch ($request_method)
    {
      case 'get':
      ?>
        <h1>Get Support.</h1>
        <hr />
        <p>Please Fill out all fields with as much information as you have available so that we can best support you.</p>
        <form method="post" action="/contact_us/">      
          <p>Full Name</p>        
          <input name="name" required/>
          </div>
          <p>E-mail Address</p>
          <input type="email" name="email" required/>
          <p>Phone Number</p>
          <input type="tel" name="phone"/>
          <p>Message</p>        
          <textarea name="message" cols="60" rows="5"></textarea>
          <input type="submit" name="submit" value="SUBMIT"> 
        </form>
      <?php
      break;  
      case 'post':
        require_once $_SERVER['DOCUMENT_ROOT'].'/contact_us/submitSupportTicket.php';
      break;
    }  
  ?>    
  </door-frame>
</section>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/include/_footer.php'; ?>