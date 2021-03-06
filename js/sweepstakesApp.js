app.config(function ($routeProvider) {  
  $routeProvider
    .when('/splash', {
      templateUrl:'/sweepstakes/partials/splash.html',    
    })
    .when('/landing', {
      templateUrl:'/sweepstakes/partials/landing.html',
      controller: 'LandingCtrl'
    })
    .when('/register', {
      templateUrl:'/sweepstakes/partials/register.html',
      controller: 'RegisterCtrl'
    })
    .when('/thank_you', {
      templateUrl:'/sweepstakes/partials/thank_you.html',
      controller: 'ThankYouCtrl'
    })
    .otherwise({
      redirectTo:'/landing'
    });
});

app.factory("UserInfo",function(){
  var userInfo = {};
  return {
    set: function(ui){
      userInfo = ui;
    },
    get: function(){
      return userInfo;
    }
  };
});

//ThankYouCtrl
app.controller('ThankYouCtrl', function($scope,$http,$location,UserInfo) {
  var configObject = undefined;
  angular.extend($scope, {
    userInfo: UserInfo.get(),
    configuration: {}
  });
  $http.get("/content/sweepstakes/configuration.json").success(function(data) {
    $scope.configuration = data;
  });
});

//RegisterCtrl
app.controller('RegisterCtrl', function($scope,$http,$location,UserInfo) {
  angular.extend($scope, {
    //Object to be passed to the server
    registration: {},
    submitRegistration: function(registration){
      $http.post("/sweepstakes/submitRegistration.php",registration).success(function(data) {
        UserInfo.set(data.userInfo); 
        $location.path("thank_you");
      });
    }
  });
});

//LandingCtrl
app.controller('LandingCtrl', function($scope,$http,$location,$timeout,UserInfo) {
  var configObject = undefined;
  var chosen = undefined;
  angular.extend($scope, {
    getChosen: function(){
      return chosen;
    },
    setChosen: function(choice){
      chosen = choice;
    },
    choiceSelected: function(){
      if(chosen){
        var config = {
            choice: chosen,
            clientEpochTime: (new Date()).getTime()
        }
        $http.post("/sweepstakes/choiceVerifyer.php",config).success(function(data) {
          if(data && data.result){
            chosen.result = data.result;
            switch(data.result){            
              case "CORRECT":
                if(data.userHasRegistered){
                  //Submit the results
                  $http.post("/sweepstakes/submitRegistration.php").success(function(data) {
                    UserInfo.set(data.userInfo); 
                    $location.path("thank_you");
                  }); 
                }
                else{
                  $timeout(function(){
                    $location.path("register");
                  },500);
                }
              break;
              case "OUT_OF_CONTEST":
                window.location = "/";
              break;
            }
          }
          else{
            chosen.result = "CLIENT_FOUND_ERROR";
          }            
        });
      }
    },
    sweepstakesConfiguration: {
      getCorrectChoiceUrl: function(){
        var correctChoiceUrl = "";
        if(configObject){
          correctChoiceUrl = configObject.correctChoiceUrl;
        }
        return correctChoiceUrl;
      },
      getWrongChoiceUrl: function(){
        var wrongChoiceUrl = "";
        if(configObject){
          wrongChoiceUrl = configObject.wrongChoiceUrl;
        }
        return wrongChoiceUrl;
      },      
      getChoices: function(){
        var choices = [];
        if(configObject){
          choices = configObject.choices;
        }
        return choices;
      }      
    }
  });
  
  $http.get("/content/sweepstakes/configuration.json").success(function(data) {
    configObject = data;
    if(configObject && configObject.showSplashScreen){
      $location.path("splash");
    }
  });
});