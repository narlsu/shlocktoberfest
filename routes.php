  <?php

   $page = ! isset($_GET['page']) ? "home" : $_GET['page'];


  
  switch ($page) {
    case 'home':
      if (isset($_SESSION['moviesuggest'])) {
        $moviesuggest = ($_SESSION['moviesuggest']);
      } else {
        $moviesuggest = [
          'title' => "",
          'email' => "",
          'checkbox' => "",
          'errors' => [
            'title' => "",
            'email' => "",
            'checkbox' => ""
          ]
        ];
      }
      include "templates/home.inc.php";
      break;

    case 'about':
      include "templates/about.inc.php";
      break;

    case 'moviesuggest':

     $_SESSION['moviesuggest']= null;
     // moving form information into a moviesuggest variable
     $moviesuggest = [
        'errors'=>[]
     ];
     $expectedVariables =[ 'email', 'title' , 'checkbox'];

     foreach ($expectedVariables as $variable) {

      // creating errors for error field


       $moviesuggest['errors'][$variable]="";

       // move all $_POST values into moviesuggest array

       if (isset($_POST[$variable])){
        $moviesuggest[$variable] = $_POST[$variable];
       } else {
        $moviesuggest[$variable]="";
       }
     }
     // form validation

     $errors = false;

     if(strlen($moviesuggest['title']) === 0) {
      $moviesuggest['errors']['title']="Enter a title.";
      $errors = true;
     }

     if (! filter_var($moviesuggest['email'], FILTER_VALIDATE_EMAIL)) {
      $moviesuggest['errors']['email']="Enter a valid email";
      $errors = true;
     }
     if ( $errors === true) {
      echo "form has to be validated !";
     
      $_SESSION['moviesuggestError'] = true;
      $_SESSION['moviesuggest']=$moviesuggest;
      header("location:./");
     } 
     
      echo "Successfully suggested a movie!";

     
     break;

    default:
      echo "Error 404";
      break;
  }