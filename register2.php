<?php

  require_once("includes/common.php");

  $username = $connection->real_escape_string($_POST["username"]);
  $password = $connection->real_escape_string($_POST["password"]);
  $password2 = $connection->real_escape_string($_POST["password2"]);

  if ($username == "" || $password == "" || $password2 != $password)   
  {                           
    apologize("Você deixou algum campo em branco ou as senhas não conferem.");
  }

  $stmt = $connection->prepare("INSERT INTO users (username, password, cash) VALUES (?, ?, 10000)");
  $stmt->bind_param('ss', $username, $password);
  
  try {
    $result = $stmt->execute();
  } catch (mysqli_sql_exception) {
    apologize("Usuario já existe, lembre-se de tomar água.");
    exit();
  }

  if ($result)
  {

    session_start();
    $_SESSION["uid"] = $connection->insert_id;


    header("Location: quote.php");
  }

  else
  {
    apologize("Erro!");
    exit();
  }

?>