<?php
  error_reporting( E_ALL & ~E_DEPRECATED & ~E_NOTICE & ~E_STRICT );
  //Start and Stop the session
  ob_start();
  session_start();

  //define the database attributes
  define('DB_DRIVER', 'mysql');
  define('DB_SERVER', 'localhost');
  define('DB_SERVER_USERNAME', 'root');
  define('DB_SERVER_PASSWORD', '');
  define('DB_DATABASE', 'address_book');
  //define the Project Name, displayed in the tab
  define('PROJECT_NAME', 'Phone Book');

  //DB options with their flags
  $dboptions = array(
                PDO::ATTR_PERSISTENT => FALSE,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
              );

  try {
    $DB = new PDO(DB_DRIVER.':host='.DB_SERVER.';dbname='.DB_DATABASE, DB_SERVER_USERNAME, DB_SERVER_PASSWORD , $dboptions);
  } catch (Exception $ex) {
    echo $ex->getMessage();
    die;
  }

  //Error messages for form validation
  if ($_SESSION["errorType"] != "" && $_SESSION["errorMsg"] != "" ) {
      $ERROR_TYPE = $_SESSION["errorType"];
      $ERROR_MSG = $_SESSION["errorMsg"];
      $_SESSION["errorType"] = "";
      $_SESSION["errorMsg"] = "";
  }
?>
