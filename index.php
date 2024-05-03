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
<header>
    <meta charset="UTF-8" http-equiv="Content-Type" content="text/html;charset=utf-8">
    <link href="css/styles.css" rel="stylesheet" type="text/css">
    <title>VHWCM Finance: portifólio</title>
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
    <div>
        <table style="text-align: left; background-color: #575649d8; border-radius: 16px;">
            <tr><td>TAG:</td><td>QUANTIDADE: </td><td>ÚLTIMO VALOR PAGO</td><td>VALOR ATUAL:<td>VENDA DE ATIVOS:</td></tr>
            <?php for($i = 0; $i < count($shores_names); $i++) { ?>
                <tr>
                    <td><?php echo $shores_names[$i]; ?></td>
                    <td><?php echo $shores_quantity[$i]; ?></td>
                    <td><?php echo $shores_ultimos[$i]; ?></td>
                    <td><?php $a = lookup($shores_names[$i]); echo $a->price; ?></td>
                    <td>
                        <form action="vender.php" method="post">
                            <input type="hidden" name="index" value="<?php echo $i; ?>">
                            <input style="width:70px" name="quantidade" type="number" step="1">
                            <input type="submit" value="Vender">
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
    <div id="bottom">
        <input type="button" value="Clique aqui para pesquisar" onclick="window.location.href='quote.php'">
    </div>
</body>
</html>