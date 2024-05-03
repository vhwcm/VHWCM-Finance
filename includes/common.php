
/********************************************************
A file to be included in all other files for consistency.
********************************************************/

<?php

    // Enable the display of errors and set the error reporting level
    ini_set("display_errors", TRUE);
    error_reporting(E_ALL ^ E_NOTICE);

    // Set the session cookie path if the request URI matches a specific pattern
    if (preg_match("{^(/~[^/]+/vhfin/)}", $_SERVER["REQUEST_URI"], $matches))
        session_set_cookie_params(0, $matches[1]);
   
    // Include necessary files
    require_once("constants.php");
    require_once("helpers.php");
    require_once("stock.php");

    // Start the session
    session_start();

    // If the user is not accessing the login, logout, or register pages, check if they are logged in
    if (!preg_match("/(:?log(:?in|out)|register)\d*\.php$/", $_SERVER["PHP_SELF"]))
    {
        if (!isset($_SESSION["uid"]))
            redirect("login.php"); // If the user is not logged in, redirect to the login page
    }

    // Check if the database constants are defined
    if (DB_NAME == "") apologize("You left DB_NAME blank.");
    if (DB_USER == "") apologize("You left DB_USER blank.");
    if (DB_PASS == "") apologize("You left DB_PASS blank.");

    // Create a new connection to the database
    $connection = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

    // Check if the database connection was successful
    if ($connection->connect_error){
        apologize("Não foi possível conectar ao bancoo de dados; Cheque os valores de DB_NAME, DB_PASS, e DB_USER em constants.php");
    }

?>
