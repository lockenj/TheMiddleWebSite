<?php
  $host = 'localhost';
  $db = 'test';
  $user = 'root';
  $pass = '##EEwrwr';

  $connect = mysql_connect("$host", "$user", "$pass");
  if (!$connect) {
     die('Could not connect: '. mysql_error());
  }
  
  $selected = mysql_select_db("$db",$connect);
  if (!$selected) {
     die('Could not select: '. mysql_error());
  }
?>