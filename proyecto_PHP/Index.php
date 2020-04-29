<?php
  include "bd/conexion.php";
  $conexion=conexionbd();
  $fecha = date("Y-m-d");
  $ip = getenv('REMOTE_ADDR');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Credit Card</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" 
  integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" href="css/styles.css">
</head>
<body>
<div class="navigation">
  <ul class="nav justify-content-center">
    <li class="nav-item">
      <a class="nav-link active" href="index.php">Home</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="Venta.php">Venta</a>
    </li>
  </ul>
</div>
<form action="#" method="POST">
  <div class="checkout_form">
      <div class="title" id="card-container" >
        <h1>Credit Card</h1>
      </div>
      <div class="card_number" id="card-container">
          <input type="text" name="numero" class="input" minlength="16" maxlength="16" id="card" placeholder="0000 0000 0000 0000" required> 
      </div>
      <div class="card_number" id="card-container">
        <input type="text" name="nombre" class="input" id="card" placeholder="Nombre">
      </div>
      <div class="card_grp">   
        <div class="expiry_date">
          <input type="text" name="mes" class="expiry_input"  placeholder="00">
          <input type="text" name="año" class="expiry_input"  placeholder="00">
        </div>
        <div class="cvc">
          <input type="text" name="cvv" class="cvc_input" placeholder="CVV">
          <div class="cvc_img">
              ?
            <div class="img">
              <img src="https://i.imgur.com/2ameC0C.png" alt="">
            </div>
          </div>
        </div>
      </div>
      <div class="btn">
        <input type="submit" class="btn btn-primary" name="registrar" value="Pay">
      </div>
    </div>
</form>
</body>
</html>

<?php 
if(isset($_POST['registrar'])){
  include "utils/Utils.php";

  $numero = $_POST["numero"];
  $nombre = $_POST["nombre"];
  $mes = $_POST["mes"];
  $año = $_POST["año"];
  $cvv = $_POST["cvv"];


  $luhn = luhn($numero);
  if($luhn == false){
    echo "<script> alert('Tarjeta invalida')</script>"; 
    exit();
  }
  echo "<script> alert('Tarjeta Valida')</script>";
  $encriptNum = encript($numero);
  $encriptNum = desencript($numero,$encriptNum);

  
  $getCard = getCard($encriptNum,$conexion);
  if ($getCard == true) {
    echo "<script> alert('Tarjeta registrada')</script>";
  }else{
    $token = token($encriptNum);
    $franquicia = getFranquicia($numero);
    insertCard($conexion,$encriptNum,$franquicia,$token,$fecha);
  }
}
?>