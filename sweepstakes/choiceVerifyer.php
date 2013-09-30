<?php 
/*
#Description
This script will verify the users sweeps choice vs todays answer
#Returned JSON object
  - If successfull 
    - {result: CORRECT, userHasRegistered: <true if already registered false otherwise>}
  - If Failed
    - If unknown error
      {result: UNKNOWN_ERROR}
    - If configuration is not setup
      {result: CONFIGURATION_ERROR}
    - If answer is wrong
      {result: WRONG}
    - If the users current date is outside the contest window
      {result: OUT_OF_CONTEST}
*/

require_once $_SERVER['DOCUMENT_ROOT'].'/sweepstakes/include/_sweepsFunctions.php';
session_start();

$request_method = strtolower($_SERVER['REQUEST_METHOD']);
switch ($request_method)
{
  /****************************************
   * POST REQUESTS
  ****************************************/
  case 'post':
    
    $response = array();
    $response['result'] = 'UNKNOWN_ERROR';
    
    $postdata = file_get_contents("php://input");    
    $request = json_decode($postdata);
    
    
    //If the client provided the proper details
    if(isset($request->choice) && isset($request->clientEpochTime)){
      $usersChoice = $request->choice;
      $answersJson = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/content/sweepstakes/answers.json'), true);
      $dateFormat="Y-n-j";
      $currentTime= time();
      
      //JS EPOCH is in ms PHPs is in seconds
      $_SESSION['clientPlayTimeEpoch'] = ($request->clientEpochTime / 1000);
      $currentClientDate = date($dateFormat, $_SESSION['clientPlayTimeEpoch']);
            
      //if we are in test mode
      if(isset($answersJson['testAnswer'])){
        if($answersJson['testAnswer'] == $usersChoice->name){
          $response['result'] = 'CORRECT';              
        }
        else{
          $response['result'] = 'WRONG';
        }
      }
      else{       
        //For each of the answers format the date string
        foreach ($answersJson['choicesByDay'] as $date => $choice) {
          $date = date($dateFormat, strtotime($date));
          $formatedAnswersByDate[$date] = $choice;                
        } 
        
        //Are within the contest window???
        if(isset($formatedAnswersByDate[$currentClientDate])){
          //Did the user choose the correct choice            
          if($choice == $usersChoice->name){
            $response['result'] = 'CORRECT';
          }          
          else{
            $response['result'] = 'WRONG';
          }
        }
        else{
          $response['result'] = 'OUT_OF_CONTEST';
        }
      }    
    }
    else{
      $response['result'] = 'MISSING_PARAMS';
    }
    
    if($response['result'] == 'CORRECT'){
      //Let other PHP scripts know that the user selected the correct answer
      $_SESSION['CORRECT_ANSWER'] = true;
      //Get the configuration settings
      $configurationJson = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/content/sweepstakes/configuration.json'), true);
      //If user has already registered
      $response['userHasRegistered'] = sweepsUserAlreadyRegistered($configurationJson);                
    }    
    echo(json_encode($response));
  break;
}
?>