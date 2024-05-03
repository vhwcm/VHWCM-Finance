<?php

    // require common code
    require_once("includes/common.php");

?>

<!DOCTYPE html>

<html>

  <head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    <link href="css/styles.css" rel="stylesheet" type="text/css">
    <title>VHWCM Finance: register</title>
  </head>

  <body>

    <div id="top">
      <a href="index.php"><img alt="VHWCM Finanças" src="images/vhwcminvestimentos.png" style="height: 200px;"></a>
    </div>

    <div id="middle">
      <form action="register2.php" method="post">
        <table>
          <tr>
            <td>Usuário:</td>
            <td><input name="username" type="text"></td>
          </tr>
          <tr>
            <td>Senha:</td>
            <td><input name="password" type="password"></td>
          </tr>
	  <tr>
             <td>Repita a senha:</td>
            <td><input name="password2" type="password"></td>	
          </tr>
          <tr>
            <td></td>
            <td><input type="submit"  value="registrar-se"></td>
          </tr>
        </table>
      </form>
    </div>

    <div id="bottom">
      ou faca  <a href="login.php">login</a> no site
    </div>

  </body>

</html>
