<?php

  require_once("includes/common.php");

  $tagname = $connection->real_escape_string($_POST["nome_acao"]);

  if ($tagname == "")                             
    apologize("Você deixou em branco.");

  if(!lookup($tagname))
  apologize("Não foi possivel encontrar.");
  session_start();
    
  $s = lookup($tagname);
  $_SESSION['s'] = $s;

  $id = $_SESSION["uid"];
    
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
    <title>VHWCM Finance: quote</title>
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
    <img  alt="VHWCM Finanças" src="images/vhwcminvestimentos.png" style="height: 200px;">
    </div>
    <div>
        <table style="text-aline: right; font-size: 20px;">
            <tr>
                <td>Tag:<?php print_r($s->name); ?> </td>
            </tr>
            <tr>
                <td>Preço:<?php print_r($s->price);                                                                                                                                                                                                                                                                                                            ?> </td>
            </tr>
            <tr>
                <td>Abertura:<?php print_r($s->open);                                                                                                                                                                                                                                                                                                            ?> </td>
            </tr>
            <tr>
                <td>Dia:<?php print_r($s->day);                                                                                                                                                                                                                                                                                                            ?> </td>
            </tr>
            <tr>
                <td>Miníma diaria:<?php print_r($s->low);                                                                                                                                                                                                                                                                                                            ?> </td>
            </tr>
            <tr>
                <td>Máxima diaria:<?php print_r($s->high);                                                                                                                                                                                                                                                                                                            ?> </td>
            </tr>
            <form action="quote3.php" method="post">
            <td>quantidade:
            <input style="width:70px" name="quantidade" type="number" step="1">
            <input type="submit" value="compar"> </td>
        </table>
    </div>
    <div id="bottom">
        <a href="quote.php">Clique aqui para voltar</a><br>
        <a href="index.php">Ver meu portifólio</a>
    </div>
</body>
</html>