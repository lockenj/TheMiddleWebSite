<?php
function calculateTimeOffsetInHours($currentTime, $otherTime){
  $currentTime_hrs = $currentTime/3600;
  $otherTime_hrs = $otherTime/3600;
  $otherTimeOff = abs($currentTime_hrs - $otherTime_hrs);
  if($currentTime_hrs > $otherTime_hrs){
    $otherTimeOff = $otherTimeOff * -1;
  }
  return $otherTimeOff;
}  

function getSweepsUserAlreadyRegisteredCookieName($configurationJson){
  //Create the cookie name from the configuration settings
  $cookieName = preg_replace( '/\s+/', '_', $configurationJson['sweepstakesName'] );
  $cookieName = strtolower($cookieName)."_sue";                  
  return $cookieName;
}

function sweepsUserAlreadyRegistered($configurationJson){
  $cookieName = getSweepsUserAlreadyRegisteredCookieName($configurationJson);
   
  //User already registered
  if(isset($_COOKIE[$cookieName])){
    return true;
  }
  else{
    return false;
  }
}
?>