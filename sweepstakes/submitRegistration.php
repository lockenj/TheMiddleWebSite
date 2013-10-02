<?php 
/*
#Description
This script will submit a sweepstakes registration request
#Returned JSON object
  - If successfull 
    - {result: SUCCESS, userInfo: <An object with all the users info>}
  - If Failed
    - If configuration is not setup
      {result: CONFIGURATION_ERROR}
    - If never answered the question
      {result: FAILED_TO_ANSWER}
    - If request failed validation
      {result: INVALID_REQUEST, details: {detailed results here}}
    - If max daily limit has been reached
      {result: MAX_ATTEMPTS_DAILY_REACHED}
    - If insert fails
      {result: INSERT_FAILED}
*/

//Defines
define("USER_TABLE", "sweeps_users");

function sendEmail($to, $subject, $from, $replyTo, $body){
    $headers = "From: ".$from."\r\n";
    $headers .= "Reply-To: ".$replyTo."\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
   
    mail($to, $subject, $body, $headers);
}

/**
 * Validates Request
 * @return null if valid $err object if invalid
 */
function validateRequest($requestData){
  $err = array();
  if(empty($requestData->age))
  {
    $err['age'] = "Please indicate your age.";
    
  }else if($requestData->age=="0-12"){
    $err['age'] = "You must be over 13 years of age to enter.";
  }
      
  if(empty($requestData->address))
  {
    $err['address'] = "ERROR: Address field required.";    
  }
      
  if(empty($requestData->city))
  {
    $err['city'] = "ERROR: City field required.";        
  }
      
  if(empty($requestData->state))
  {
    $err['statet'] = "ERROR: State field required.";
  }
      
  if(empty($requestData->zip))
  {
    $err['zip'] = "ERROR: Zipcode field required.";
  }
      
  if(empty($requestData->phone))
  {
    $err['phone'] = "ERROR: Phone field required.";
  }
      
  if(empty($requestData->agree))
  {
    $err['agree'] = "ERROR: Must agree to the Rules and Regulations to enter."; 
  }
    
  if(empty($requestData->firstName) || strlen($requestData->firstName) < 2)
  {
    $err['firstName'] = "ERROR: Invalid first name. Please enter at least 2 or more characters for your first name";
  }
      
  if(empty($requestData->lastName) || strlen($requestData->lastName) < 2)
  {
    $err['lastName'] = "ERROR: Invalid last name. Please enter at least 2 or more characters for your last name";        
  }
    
  // Validate Email
  if(!isset($requestData->email) || !filter_var($requestData->email, FILTER_VALIDATE_EMAIL)) {
    $err['email'] = "ERROR: Invalid email.";
  }
  
  if(empty($err)){
    return null;
  }
  else{
    return $err;
  }
}

/**
 * Returns the user info found via email or null if not found
 */
function getExistingUserInfo($userEmail){
  $existq = "SELECT *
            FROM ".USER_TABLE." 
            WHERE user_email = '$userEmail'";
        
  $userEmailQueryResults = mysql_query($existq);

  $userEmailQueryResultsLength = mysql_num_rows($userEmailQueryResults);
    
  //If a user is found
  if($userEmailQueryResultsLength && $userEmailQueryResultsLength > 0)  {
    $rowData = mysql_fetch_array($userEmailQueryResults);
    
    $userInfo['email'] = $rowData['user_email'];
    $userInfo['firstName'] = $rowData['firstname'];
    $userInfo['lastName'] = $rowData['lastname'];
    $userInfo['address'] = $rowData['address1'];
    $userInfo['city'] = $rowData['city'];
    $userInfo['state'] = $rowData['state'];
    $userInfo['zip'] = $rowData['zip'];
    $userInfo['phone'] = $rowData['tel'];
    $userInfo['mobile'] = $rowData['mobile'];         
    
    $userInfo['userIp'] = $rowData['users_ip'];
    $userInfo['metroCode'] = $rowData['metroCode'];
    
    $userInfo['newsletter'] = $rowData['opt_newsletter'];
    $userInfo['age'] = $rowData['opt_age'];
    $userInfo['agree'] = $rowData['opt_rules'];
    $userInfo['optin2'] = $rowData['opt_optin2'];
    $userInfo['optin3'] = $rowData['opt_optin3'];
    return $userInfo;
  }
  else{
    return null;
  }
}

/**
 * Get the number of attempts by the user today, using the users time if timeOffset is specified in the request
 * otherwise use the server side current date.
 */
function getNumberOfAttemptsToday($request){
  $dateFormat="Y-m-d";
  $currentDate = date($dateFormat, time());
  
  $attemptsQuery = "SELECT * 
    FROM ".USER_TABLE." 
    WHERE user_email = '$request->email'
    AND DATE_FORMAT(created, '%Y-%m-%d') = '$currentClientDate'";
                  
  $todaysAttemptsResults = mysql_query($attemptsQuery);

  $totalrows = mysql_num_rows($todaysAttemptsResults);  
  return $totalrows;
}

/**
 * Submit the results to the database 
 * @return true if success false otherwise
 */
function submitResults($requestData){
  //Set create time to the clients equivelent servertime
  if(isset($_SESSION['clientPlayTimeEpoch'])){
    $createTimestamp = $_SESSION['clientPlayTimeEpoch'];
  }
  else{
    $createTimestamp = time();  
  }
  
  $serverTimestamp = date('Y-m-d H:i:s', $createTimestamp);

  $md5pass = md5($requestData->email);
  $usersIp = $_SERVER['REMOTE_ADDR'];
  // lookup the METRO_CODE
  $metroCode = -1;
  $metroByIp = findMetroByIpAddress($_SERVER['REMOTE_ADDR']);
  if($metroByIp){
    $metroCode = $metroByIp;
  }
  else{
    $metroByZip = findMetroByZip('37203');
    if($metroByZip){
      $metroCode = $metroByZip;
    }
    else{
      $metroByCityState = findMetroByCityState("BRATTLEBORO","vT");
      if($metroByCityState){
        $metroCode = $metroByCityState;
      }
    }
  }    
  
  //Insert Registration Record
  $sql_insert = "INSERT INTO ".USER_TABLE." (    
    created,
    firstname,
    lastname,
    address1,
    city,
    state,
    zip,
    tel,
    mobile,
    user_email,
    pwd,
    users_ip,
    metroCode,    
    opt_age,
    opt_rules,
    opt_optin3 )
  VALUES (
    '$serverTimestamp',
    '$requestData->firstName',
    '$requestData->lastName',
    '$requestData->address',
    '$requestData->city',
    '$requestData->state',
    '$requestData->zip',
    '$requestData->phone',
    '$requestData->mobile',
    '$requestData->email',
    '$md5pass',
    '$usersIp',
    '$metroCode',
    '$requestData->age',
    '$requestData->agree',    
    '$requestData->optin3' )";
 
  $result = mysql_query($sql_insert);
  
  if($result == false){
    return false;
  }
  else{
    $regEmailSettings = $configurationJson['registeredEmail'];
    sendEmail($requestData->email,$regEmailSettings['subject'] , $regEmailSettings[from], $regEmailSettings['replyTo'], $regEmailSettings['body']);
    return true;
  }
}

/***********************************************************************************************************************/
/***********************************************************************************************************************/
/***********************************************************************************************************************/
//HANDLE Registration Request
/***********************************************************************************************************************/
/***********************************************************************************************************************/
/***********************************************************************************************************************/
require_once $_SERVER['DOCUMENT_ROOT'].'/include/_dbConnection.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/sweepstakes/include/_sweepsFunctions.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/include/_metroFunctions.php';
session_start();

$request_method = strtolower($_SERVER['REQUEST_METHOD']);
switch ($request_method)
{
  /****************************************
   * POST REQUESTS
  ****************************************/
  case 'post':    
    $response = array();
    
    //Get Client request object
    $postdata = file_get_contents("php://input");    
    $request = json_decode($postdata);
            
    //Get the configuration settings
    $configurationJson = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/content/sweepstakes/configuration.json'), true);       
    
    if(isset($configurationJson)){
      //If the user has answered the question correctly
      if(isset($_SESSION['CORRECT_ANSWER'])){
        $cookieName = getSweepsUserAlreadyRegisteredCookieName($configurationJson);      
        //User already registered
        if(sweepsUserAlreadyRegistered($configurationJson)){
          $userEmail = $_COOKIE[$cookieName];
          $userInfo = $object = json_decode(json_encode(getExistingUserInfo($userEmail)), FALSE);
          
          //Submit Data
          if(submitResults($userInfo)){
            //Set the users cookie (for returning users) to expire in 30 days
            setcookie($cookieName,$userEmail, time()+60*60*24*30);
            //Unset the correct answer
            unset($_SESSION['CORRECT_ANSWER']);
            $response['result'] = "SUCCESS";
            $response['userInfo'] = $userInfo;
          }
          else{
            $response['result'] = "INSERT_PREVIOUS_INFO_FAILED";  
          }
        }
        else{
          //Validate Data
          $validationResults = validateRequest($request);
          
          if($validationResults == null){          
            $numberOfTodayAttempts = getNumberOfAttemptsToday($request) >= $configurationJson['numberOfAllowedAttempts'];
                      
            //daily max submissions has been reached
            if($numberOfTodayAttempts >= $configurationJson['numberOfAllowedAttempts']){
              $response['result'] = "MAX_ATTEMPTS_DAILY_REACHED";
            }
            else{
              //Submit Data
              if(submitResults($request)){
                //Set the users cookie (for returning users) to expire in 30 days
                setcookie($cookieName,$request->email, time()+60*60*24*30);
                //Unset the correct answer
                unset($_SESSION['CORRECT_ANSWER']);
                $response['result'] = "SUCCESS";
                $userInfo = getExistingUserInfo($request->email);
                $response['userInfo'] = $userInfo;
              }
              else{
                $response['result'] = "INSERT_FAILED";  
              }                            
            }
          }
          else{
            $response['result'] = "INVALID_REQUEST";
            $response['details'] = $validationResults;
          }
        }
      }
      else{
        $response['result'] = "FAILED_TO_ANSWER";
      }
    }
    else{
      $response['result']="CONFIGURATION_ERROR";
    }
   
    echo(json_encode($response));
  break;
}
?>