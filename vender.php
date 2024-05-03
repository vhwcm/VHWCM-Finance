<?php

  require_once("includes/common.php");



  $i = $connection->real_escape_string($_POST["index"]);
  $quantidadeven = $connection->real_escape_string($_POST["quantidade"]);
  $acoes = $_SESSION["shores_names"];
  $id = $_SESSION["uid"];
  $acao = lookup($acoes[$i]);
  
  
  if ($quantidadeven == "" || $quantidadeven <= 0)   
  {                           
    apologize("Insira uma quantidade válida, por favor!");
  }
  $result = $connection->query("SELECT quantidade FROM portifolio WHERE id = '$id' AND tag = '$acao->name'");
$row = $result->fetch_assoc();
$quantidadeAtual = $row['quantidade'];

if ($quantidadeAtual - $quantidadeven < 0) {
    apologize("Você não tem tantas ações assim, amigão!");
}
  $sql = $connection->prepare("UPDATE portifolio SET quantidade = quantidade - ? WHERE id = ? AND tag = ?");
  $sql->bind_param('dds', $quantidadeven, $id, $acao->name);
  $_SESSION["registro"] = $connection->insert_id;
  $sql->execute();
  
  $valor_de_venda = $acao->price * $quantidadeven;
  $sql = $connection->prepare("UPDATE users SET cash = cash + ? WHERE uid = ?");
  $sql->bind_param('dd', $valor_de_venda, $id);
  $sql->execute();

    date_default_timezone_set('America/Sao_Paulo');
    $currentDateTime = date('Y-m-d H:i:s');

  $ll = $connection->prepare("INSERT INTO extrato (id,tag,tipo,valor,quantidade, time) VALUES (?, ?, 'venda', ?, ?,?)");
  $ll->bind_param('dsdds', $id, $acao->name, $valor_de_venda, $quantidadeven,$currentDateTime); 
  $ll->execute();
  $ll->close();
 
  $result = $connection->query("SELECT quantidade FROM portifolio WHERE id = '$id' AND tag = '$acao->name'");
  $row = $result->fetch_assoc();
  $quantidadeAtual = $row['quantidade'];

    if ($quantidadeAtual == 0) {
        $sql = $connection->prepare("DELETE FROM portifolio WHERE id = ? AND tag = ?");
        $sql->bind_param('ds', $id, $acao->name);
        $sql->execute();
    }
    
    header("Location: index.php");
    end();
?>