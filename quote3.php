<?php
  // require common code
  require_once("includes/common.php");


  // escape username and password for safety
  $quantidade = $connection->real_escape_string($_POST["quantidade"]);

  if ($quantidade == "" || $quantidade == 0)   
  {                           
    apologize("Você deixou algum campo em branco");
  }

  $s = $_SESSION['s'];
  $idsassao = $_SESSION["uid"];
  $totalprice = $s->price * $quantidade;
  
 
    $bb = $connection->prepare("UPDATE users SET cash = cash - ? WHERE uid = ?");
    $bb->bind_param('dd',$totalprice, $idsassao);
    $bb->execute();
    
    $result = $connection->query("SELECT cash FROM users WHERE uid = '$idsassao'");
    $row = $result->fetch_assoc();
    $currentCash = $row['cash'];

    if ($currentCash - $totalprice < 0) {
      apologize("Saldo insuficiente :(");
  }
 

    $sql = "SELECT * FROM portifolio WHERE id = ? AND tag = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param('ds', $idsassao, $s->name);
    $stmt->execute();

    $result = $stmt->get_result();
    
    date_default_timezone_set('America/Sao_Paulo');
    $currentDateTime = date('Y-m-d H:i:s');

  if($result->num_rows == 0)
  {
    $cc = $connection->prepare("INSERT INTO portifolio (id,tag, quantidade, ultimos) VALUES (?, ?, ?, ?)");
    $cc->bind_param('dsdd',$idsassao, $s->name, $quantidade, $s->price);
    $cc->execute();
    $cc->close();

    $ll = $connection->prepare("INSERT INTO extrato (id,tag,tipo,valor,quantidade, time) VALUES (?, ?, 'compra', ?, ?, ?)");
    $ll->bind_param('dsdds',$idsassao, $s->name, $totalprice, $quantidade,$currentDateTime);
    $ll->execute();
    $ll->close();
    header("Location: index.php");
    end();
  }   
  else if ($result->num_rows == 1)
  {
    $cc = $connection->prepare("UPDATE portifolio SET quantidade = quantidade + ? , ultimos = ? WHERE id = ? AND tag = ?");
    $cc->bind_param('ddds',$quantidade,$s->price, $idsassao, $s->name);
    $cc->execute();
    $cc->close();
    $ll = $connection->prepare("INSERT INTO extrato (id,tag,tipo,valor,quantidade, time) VALUES (?, ?, 'compra', ?, ?, ?)");
    $ll->bind_param('dsdds',$idsassao, $s->name, $totalprice, $quantidade,$currentDateTime);
    $ll->execute();
    $ll->close();
    header("Location: index.php");
    end();  
  }
  else
  {
    apoligize("Erro ao comprar ações!");
  }
        
?>