<?php
  if ( $_POST['name'] && $_POST['email'] ) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];
    
    if(!isset($_POST['phone'])){
      $phone = "";
    } 
    if(!isset($_POST['message'])){
      $message = "";
    }
    // recipients
    //$to  = 'The Middle Support <support@themiddleweeknights.com>';    
    $to  = 'lockenj@gmail.com';
    
    // subject
    $subject = 'The Middle Support Request';
    
    // message
    $emailMessage = '
    <html>
    <head>
      <title>Support Request:</title>
    </head>
    <body>
      <p><strong>THE MIDDLE WEEKNIGHTS</strong> SUPPORT REQUEST:</p>
      <p>&nbsp;</p>
      <p><strong>Name:</strong></p>
      <p>' . $name . '</p>
      <p><strong>E-mail Address:</strong></p>
      <p>' . $email . '</p>
      <p><strong>Phone Number:</strong></p>
      <p>' . $phone . '</p>
      <p><strong>Message:</strong></p>
      <p>' . $message . '</p>
      <p><strong>UA/IP:</strong></p>
      <p>' . $_SERVER['HTTP_USER_AGENT'] . "<br/>" . $_SERVER['REMOTE_ADDR'] . '</p>
      <p>&nbsp;</p>
    </body>
    </html>
    ';
    
    // To send HTML mail, the Content-type header must be set
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    
    // Additional headers
    $headers .= 'To: The Middle Support <'.$to.'>' . "\r\n";
    $headers .= 'Reply-to:' . $_POST['email'] . "\r\n";
    $headers .= 'From: The Middle Support <no-reply@themiddleweeknights.com>' . "\r\n";
    //$headers .= 'Cc: birthdayarchive@example.com' . "\r\n";
    //$headers .= 'Bcc: birthdaycheck@example.com' . "\r\n";
    
    // Mail it
    mail($to, $subject, $emailMessage, $headers);
        
    $success_support = 1;        
    
    //Echo The results
    echo ("<h1>Thank you for submitting this support request.</h1> ".$emailMessage);
  }
  ?>