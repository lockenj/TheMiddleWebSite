<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/include/_dbConnection.php';
  if ($_POST['zipcode'])
  {
    $s = "SELECT ss.metrocode ,
           ss.id 
        FROM locations l 
        INNER JOIN station_schedules ss ON (ss.metrocode = l.metroCode) 
        WHERE l.postalCode = '".$_POST['zipcode']."' LIMIT 1";
        //echo $s; exit();
    $r = mysql_query($s) or die($s);
    @$c = mysql_num_rows($r);
    
    if ( $c )
    {
      $a = mysql_fetch_assoc($r);
      if ($a['metrocode'])
      {
        $s = "SELECT *
        FROM locations l 
        INNER JOIN station_schedules ss ON (ss.metrocode = l.metroCode) 
        WHERE ss.metroCode = '".$a['metrocode']."'
        AND tvshow = 'themiddle'
        GROUP BY runtime1
        ORDER BY runtime1 DESC";
        //echo $s; exit();
        $r = mysql_query($s) or die($s);
        @$c = mysql_num_rows($r);
        
        echo'<h1>Showtimes for your area are... </h1>';          
    
        if ( $c )
        {
          while ($a = mysql_fetch_assoc($r) )
          {
          ?>
          <h4><span><?php echo $a['airday1']    ? strtoupper($a['airday1']) : ' '; ?> <?php echo $a['airtime1']     ? strtoupper($a['airtime1']) : ' '; ?> <?php echo $a['station_code']  ? strtoupper($a['station_code']) : ' '; ?> <?php echo $a['channel']   ? strtoupper($a['channel']) : ' '; ?></span></h4>
          <?php
          }
        }
      
      }
    }
    else
    {
      echo "<h1>Sorry No Listings Were Found!</h1>"; 
    }
  }
  else{
      header('Location: /local_listings');
  }
?>