<?php


    require_once("includes/common.php"); 


    $username = mysqli_real_escape_string($connection,$_POST["username"]);
    $password = mysqli_real_escape_string($connection,$_POST["password"]);

 
    $sql =  $connection->prepare("SELECT uid FROM users WHERE username = ? AND password= ?");
    $sql->bind_param('ss', $username, $password);

     mysqli_stmt_execute($sql);
    $result = mysqli_stmt_get_result($sql);

    if ($result->num_rows == 1)
    {

        $row = $result->fetch_assoc();

        $_SESSION["uid"] = $row["uid"];

        redirect("quote.php");
    }

    else
        apologize("Usuário e/ou senha inválidos!");

?>
