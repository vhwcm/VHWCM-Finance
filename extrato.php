<?php

    require_once("includes/common.php");
    $id = $_SESSION["uid"];
    $usario = "SELECT * FROM portifolio WHERE id = ?";
    $sql = $connection->prepare($usario);
    $sql->bind_param('d', $id);
    $sql->execute();
    $result = $sql->get_result();

    $shores_names = [];
    $shores_quantity = [];
    $shores_ultimos = [];
    while ($row = $result->fetch_assoc()) {
        $shores_names[] = $row['tag'];
        $shores_quantity[] = $row['quantidade'];
        $shores_ultimos[] = $row['ultimos'];
} $_SESSION["shores_names"] = $shores_names;
    
    $mimo = "SELECT * FROM users WHERE uid = ?";
    $sql = $connection->prepare($mimo);
    $sql->bind_param('d', $id);
    $sql->execute();  
    $result = $sql->get_result();
    $row = $result->fetch_assoc();
    $usuario = $row['username'];
    $dinheiro = $row['cash'];
    $query = "SELECT * FROM extrato WHERE id = ? ORDER BY time DESC LIMIT 50";
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
<header>
    <meta charset="UTF-8" http-equiv="Content-Type" content="text/html;charset=utf-8">
    <link href="css/styles.css" rel="stylesheet" type="text/css">
    <title>VHWCM Finança: Extrato</title>
</header>
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
    <tr><td ><a href="quote.php">Pesquisar 🔍︎</td></tr>
    </table>
    </div>
    <div id="top">
    <div class="logextrato">
    <h1>Extrato[̲̅$̲̅(̲̅ιο̲̅̅)̲̅$̲̅]</h1>
    </div>
    </div>
    <table class="outer-table">
    <tr>
    <?php for($i = 0; $i < count($extrato); $i++) { ?>
        <td class="outer-cell">
            <table class="inner-table">
                <tr>
                    <td><?php echo $extrato[$i]['time']; ?></td>
                    <td><?php echo strtoupper($extrato[$i]['tipo']); ?></td>
                </tr>
                <tr>
                    <td>Tag: <?php echo $extrato[$i]['tag']; ?></td>
                    <td>Valor: <?php echo $extrato[$i]['valor']; ?></td>
                </tr>
                <tr>
                    <td>Quantidade de Ações: <?php echo $extrato[$i]['quantidade']; ?></td>
                    <td>Preço por unidade: <?php echo $extrato[$i]['valor']/$extrato[$i]['quantidade']; ?></td>
                </tr>
            </table>
        </td>
        <?php if(($i+1)%4 == 0 && $i+1 < count($extrato)) { echo '</tr><tr>'; } ?>
    <?php } ?> 
    </tr>
</table>    
</body>
</html>