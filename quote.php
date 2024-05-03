<?php

    require_once("includes/common.php");
    $id = $_SESSION["uid"];
    
    $mimo = "SELECT * FROM users WHERE uid = ?";
    $sql = $connection->prepare($mimo);
    $sql->bind_param('d', $id);
    $sql->execute();  
    $id = $_SESSION["uid"];
    $result = $sql->get_result();
    $row = $result->fetch_assoc();
    $usuario = $row['username'];
    $dinheiro = $row['cash'];
    $query = "SELECT * FROM extrato WHERE id = ? ORDER BY time DESC LIMIT 3";
    $stmt = $connection->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $extrato = [];
while ($row = $result->fetch_assoc()) {
    $extrato[] = $row;
}
    $_SESSION["extrato"] = $extrato;
    $stmt->close();
    $sql->close();
    $connection->close();
?>

<!DOCTYPE html>

<html>

  <head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    <link href="css/styles.css" rel="stylesheet" type="text/css">
    <title>VHWCM Finances: search</title>
  </head>

  <body>
  <div class="dados"> 
    <table style="text-align: left;">
        <tr><td>ID: <?php echo $id; ?></td></tr>
        <tr><td>Usuário: <?php echo $usuario; ?></td></tr>  
        <tr><td>Vikcoins: <?php echo $dinheiro; ?></td></tr>  
    </table>

    <table>
    <tr><td ><a href="index.php">Ver meu portfólio</td></tr>
    <tr><td ><a href="logout.php">Log Out ⬅▢</td></tr>
    </table>
    <table>
    <tr><td><h3><a href="extrato.php">Extrato[̲̅$̲̅(̲̅ιο̲̅̅)̲̅$̲̅]</a></h3><br>
    <?php for($i = 0; $i < count($extrato); $i++) { ?>
        <?php echo strtoupper($extrato[$i]['tipo'])."<br>"; ?>
        <?php echo "Tag:".$extrato[$i]['tag']."<br>"; ?>
        <?php echo "Valor:".$extrato[$i]['valor']."<br><br><br><br>"; ?>
    <?php } ?>
    </td>
    </tr> 
    </table>
    </div>
    <div id="top">
      <img alt="VHWCM Finanças" src="images/vhwcminvestimentos.png" style="height: 200px;">
    </div>

    <div style="font-size: 1.7em;" id="middle">
      <form action="quote2.php" method="post">
          <tr >
            <td >Procure uma ação:</td>
            <td><input style="font-size:0.7em; width:30%;"name="nome_acao" type="text"></td>
            <td><input style="font-size:0.7em; width:8%;" type="submit" value="Procurar"></td>
          </tr>
      </form>
    </div>
  </body>

</html>
