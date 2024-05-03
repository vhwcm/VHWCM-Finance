/********************************************************
A file about the error message that will be displayed
when an error occurs. Spawn from the apologize function.
********************************************************/
<!DOCTYPE html>

<html>

  <head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    <link href="css/styles.css" rel="stylesheet" type="text/css">
    <title>VHWCM Finance: Ops!</title>
  </head>

  <body>

    <div id="top">
      <a href="index.php"><img alt="CC50 Finanças" src="images/vhwcminvestimentos.png" style="height: 200px;"></a>
    </div>

    <div id="middle">
      <h1>Ops!</h1>
      <h2><?= $message ?></h2>
    </div>

    <div id="bottom">
      <input type="button" value="Voltar ao portfólio" onclick="window.location.href='index.php'">
    </div>

  </body>

</html>
