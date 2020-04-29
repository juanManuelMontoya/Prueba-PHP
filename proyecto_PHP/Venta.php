<?php
  include "utils/UtilsVenta.php";
  include "bd/conexion.php";

  $conexion=conexionbd();
  $fecha = date("Y-m-d");
  $hora = date("h:m");
  $ip = getenv('REMOTE_ADDR');
  //$ip = ":18:2";

  if(getVisita($conexion,$ip,$fecha)){
      updateHora($conexion,$ip,$fecha,$hora);
  }else{
      insertVisita($conexion,$ip,$fecha,$hora);
  }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" 
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" href="css/venta.css">
    <title>Credit card</title>
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

<div class="contenedor">
    <div class="cont">
        <img class="img" src="https://images.unsplash.com/photo-1532877590696-69a157b92b78?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=334&q=80" alt="">
    </div>
    <div class="cont2" >
      <div class="info">
        <h1>Gopro HERO 7</h1>
        <p style="font-size: 12px">Esta es la HERO7 Black. La cámara HERO más versátil y estable detodas. 
          Su diseño optimizado la hace más compacta que nunca. Además, los soportes se pueden 
          cambiar en apenas segundos gracias a los adaptadores plegables incorporados. 
          Y con el módulo multimedia opcional, obtienes una impresionante capacidad de 
          ampliación para agregar más luz, una calidad de audio profesional e, incluso, 
          otra pantalla. También cuenta con una innovadora estabilización HyperSmooth 2.0 y 
          una impresionante función de cámara lenta.</p>
        <h3>$1.499.900</h3>  
      </div>
      <form action="#" method="POST">
      <div class="card_number" id="card-container">
          <input type="text" name="numero" class="input" minlength="16" maxlength="16" id="card" placeholder="0000 0000 0000 0000"> 
          <div class="btn">
              <input type="submit" class="btn btn-primary" name="pay" value="Pay">
          </div>
      </div>
      </form>
    </div>
    <div>
      <img style="width: 36px; height: 30px; margin-top: 10px;" src="https://upload.wikimedia.org/wikipedia/commons/1/16/Former_Visa_%28company%29_logo.svg" alt="">
      <img style="width: 46px; height: 40px; margin-top: 10px;" src="https://www.mastercard.com.co/content/dam/mccom/global/logos/logo-mastercard-mobile.svg" alt="">
      <img style="width: 40px; height: 34px; margin-top: 10px;" src="https://www.mouseinteractivo.com/wp-content/uploads/portada-american-express-copia.jpg" alt="">
      <img style="width: 55px; height: 34px; margin-top: 10px;" src="https://gestion.pe/resizer/wmpkSU6S-XPUM4XzEARy-nmS14E=/1200x675/smart/arc-anglerfish-arc2-prod-elcomercio.s3.amazonaws.com/public/UZ3CVIIHTFF5LG35D4MHPNCFRA.jpg" alt="">
    </div>
</div>
</body>
</html>

<?php 
  if(isset($_POST['pay'])){    

    $numero = $_POST["numero"];

    $luhn = luhn($numero);
    if($luhn == false){
      echo "<script> alert('Tarjeta invalida')</script>"; 
      exit();
    }
    $encriptNum = encript($numero);
    $getCard = getCard($encriptNum,$conexion);

    if ($getCard == true) {
        echo "<script> alert('Tarjeta registrada')</script>";
        $res = getVisitaBycard($conexion,$ip,$fecha,$encriptNum);
        if($res){
            excesoPeticiones($conexion,$ip,$fecha,$encriptNum);
        }else{
            updateNumTarjeta($conexion,$encriptNum,$ip,$fecha);
        }
    }else{
      $token = token($encriptNum);
      $franquicia = getFranquicia($numero);
      insertCard($conexion,$encriptNum,$franquicia,$token,$fecha);
    }
  }
?>