<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/include/_dbConnection.php';
/**
 * Gets Metro by ZipCode
 * @return metroCode or null if not found
 */
function findMetroByZip($zipCode){
  $zip = mysql_real_escape_string($zipCode);
  $sel1 = "SELECT metroCode as metro, city, region FROM `locations` WHERE postalCode = '$zip' LIMIT 1";
  $res1 = mysql_query( $sel1 ) or die( mysql_error()." / ".$sel1 );
      
  if(mysql_num_rows($res1)){
    $rowData = mysql_fetch_array($res1);
    return $rowData['metro'];
  }
  else{
    return null;
  }
}

/**
 * Get the remote IP Address as its stored in the DB
 */
function ip_address_to_number($IPaddress) {
  if ($IPaddress == "") {
    return 0;
  } else {
    $ips = preg_split ("/\./", "$IPaddress");
    return ($ips[3] + $ips[2] * 256 + $ips[1] * 256 * 256 + $ips[0] * 256 * 256 * 256);
  }
}

/**
 * Gets Metro by IP Address
 * @return metroCode or null if not found
 */
function findMetroByIpAddress($ip){
  $ipNumber = ip_address_to_number($ip);  
  $query_rs_ipcheck = "SELECT * FROM blocks WHERE startIpNum <= " . $ipNumber . " AND endIpNum >= " . $ipNumber . " LIMIT 1";
  $ipCheckResult = mysql_query( $query_rs_ipcheck ) or die( mysql_error()." / ".$query_rs_ipcheck );
  
  
  if(mysql_num_rows($ipCheckResult)){
    $blockData = mysql_fetch_array($ipCheckResult);
  
    $queryForMetroByLocId = "SELECT metroCode as metro FROM `locations` WHERE locId = '".$blockData['locId']."' LIMIT 1";    
    $metroResult = mysql_query( $queryForMetroByLocId ) or die( mysql_error()." / ".$queryForMetroByLocId );
      
    if(mysql_num_rows($metroResult)){
      $rowData = mysql_fetch_array($metroResult);
      return $rowData['metro'];
    }
  }
    
  return null;  
}


/**
 * Gets Metro by City State
 * @return metroCode or null if not found
 */
function findMetroByCityState($city, $state){
  $qCity = strtolower(mysql_real_escape_string($city));
  $qState = strtolower(mysql_real_escape_string($state));
  
  $sel2 = "SELECT metroCode as metro, city, region FROM `locations` WHERE LOWER(city) = '$qCity' and LOWER(region) = '$qState' LIMIT 1";
  $res2 = mysql_query( $sel2 ) or die( mysql_error()." / ".$sel2 );
        
  if(mysql_num_rows($res2)){
    $rowData = mysql_fetch_array($res2);
    return $rowData['metro'];
  }
  else{
    return null;
  }
}

//echo findMetroByZip('37203');
//echo findMetroByIpAddress($_SERVER['REMOTE_ADDR']);
//echo findMetroByCityState("BRATTLEBORO","vT");
?>