<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/include/_dbConnection.php';
  $listings = array();
  $tvShowName = 'themiddle';

  function ip_address_to_number($IPaddress) {
    if ($IPaddress == "") {
      return 0;
    } else {
      $ips = preg_split ("/\./", "$IPaddress");
      return ($ips[3] + $ips[2] * 256 + $ips[1] * 256 * 256 + $ips[0] * 256 * 256 * 256);
    }
  }

  if ($_POST['zipcode'])
  {
    $s = "SELECT ss.metrocode ,
           ss.id 
        FROM locations l 
        INNER JOIN station_schedules ss ON (ss.metrocode = l.metroCode) 
        WHERE l.postalCode = '".$_POST['zipcode']."' LIMIT 1";
    
    $r = mysql_query($s) or die("Failed Executing DB Query(ErrorCode => 00001)");
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
        AND tvshow = '".$tvShowName."'
        GROUP BY runtime1
        ORDER BY runtime1 DESC";
        //echo $s; exit();
        $r = mysql_query($s) or die("Failed Executing DB Query(ErrorCode => 00002");
        @$c = mysql_num_rows($r);
    
        if ( $c )
        {
          while ($a = mysql_fetch_assoc($r) )
          {
            array_push($listings, $a);
          }
          if(isset($_GET['json'])){
            echo json_encode($listings);
          }
          else{
            echo'<h1>Showtimes for your area are... </h1>';
            foreach ($listings as $listing) {
            ?>
              <h4><span><?php echo $listing['airday1']    ? strtoupper($listing['airday1']) : ' '; ?> <?php echo $listing['airtime1']     ? strtoupper($listing['airtime1']) : ' '; ?> <?php echo $listing['station_code']  ? strtoupper($listing['station_code']) : ' '; ?> <?php echo $listing['channel']   ? strtoupper($listing['channel']) : ' '; ?></span></h4>
            <?php   
            }           
          }
        }      
      }
    }
    else
    {
      if(isset($_GET['json'])){
        echo json_encode($listings);
      }
      else{
        echo "<h1>Sorry No Listings Were Found!</h1>";
      } 
    }
  }
  else{
    if(isset($_GET['json'])){
      //Grab the Remote IP
      $rip = $_SERVER['REMOTE_ADDR'];
      $ip = ip_address_to_number($rip);

      //TEST
      //$ip = "33996345";

      $query_rs_ipcheck = "SELECT * FROM blocks WHERE startIpNum <= " . $ip . " AND endIpNum >= " . $ip . " LIMIT 1";
    
      $rs_ipcheck = mysql_query($query_rs_ipcheck);
      $row_rs_ipcheck = mysql_fetch_assoc($rs_ipcheck);
      @$totalRows_rs_ipcheck = mysql_num_rows($rs_ipcheck);

      //print_r($row_rs_ipcheck);exit();

      //Found the locId
      if( $totalRows_rs_ipcheck ){      
        $sShowtimes = "SELECT l.locId AS locId, ls1.locId AS supported_loc, l.metroCode FROM locations l LEFT JOIN locations ls1 ON (l.locId = ls1.locId) WHERE l.locId = " . $row_rs_ipcheck["locId"] . " LIMIT 1";
        
        $rShowtimes = mysql_query($sShowtimes);
        @$cShowtimes = mysql_num_rows($rShowtimes);
        if(@$cShowtimes){
          $aShowtimes = mysql_fetch_assoc($rShowtimes);
        }
        
        //print_r($aShowtimes);
              
        if ($aShowtimes['metroCode'])
        {
          $sStation = "SELECT * FROM station_schedules WHERE metrocode = '".$aShowtimes['metroCode']."' AND tvshow = '".$tvShowName."'";
          $rStation = mysql_query($sStation);                   
          
          while ( $aStation = mysql_fetch_assoc($rStation) )
          {
            //print_r($aStation);
            array_push($listings, $aStation);
          }         
        }                      
      }
      echo json_encode($listings);
    }
    else{
      header('Location: /local_listings');
    }
  }
?>
