<?php
include "Encript.php";
    //Valida si la tarjeta ya fue registrada en la base de datos
    function getCard($cardNum,$conexion){
         //$consu="select numeroTarjeta from tarjeta";
         $consu="select count(*) as tarjetas from tarjeta where numeroTarjeta='".$cardNum."'";
        $rs = mysqli_query($conexion,$consu);
        $fila = mysqli_fetch_array($rs);

       /* foreach ($fila as $key) {
            if(!desencript($cardNum,$key)){
                return false;
            }
        }*/
        if ($fila['tarjetas'>0]) {
            return true;
        }else{
            return false;
        }   
     }

     //Inserta la tarjeta en la base de datos
     function insertCard($conexion,$cardNum,$franquicia,$token,$fecha){
        $consu="insert into tarjeta(numeroTarjeta,franquicia,token,fechaCreacion) 
        values(".$cardNum.",'$franquicia',".$token.",'$fecha')";
        insertUpdate($conexion,$consu);
     }

     //realiza la operacion de insercion
     function insertUpdate($conexion,$consu){
        $rs=mysqli_query($conexion,$consu);   
          if (!$rs) {
            echo "<script>alert('Ocurrio un problema')</script>";
          }
     }

    //Determina segun las reglas de luhn si un N° de tarjeta es valido 
    function luhn($numero){
        $num1 = substr($numero,0,-15);
        $num2 = substr($numero,2,-13);
        $num3 = substr($numero,4,-11);
        $num4 = substr($numero,6,-9);
        $num5 = substr($numero,8,-7);
        $num6 = substr($numero,10,-5);
        $num7 = substr($numero,12,-3);
        $num8 = substr($numero,-2,1);
        
        $sec1 = numImpares($numero);
        
        $total = mayorLimit($num1);
        $total = $total + mayorLimit($num2);
        $total = $total + mayorLimit($num3);
        $total = $total + mayorLimit($num4);
        $total = $total + mayorLimit($num5);
        $total = $total + mayorLimit($num6);
        $total = $total + mayorLimit($num7);
        $total = $total + mayorLimit($num8); 
        
        $total = $total + $sec1;
        
        $definitivo = substr($total,1);
        if($definitivo == 0){
            return true;
        }else{
            return false;
        }
    }

    //si el numero es mayor a 9 sumara cada digito dando un resultado de un solo dijito
    function mayorLimit($num){
        $total = $num * 2;
        if($total>10){
            $number1 = substr($total,0,-1);
            $number2 = substr($total,1);
        
            $total = $number1 + $number2;
        
            return $total;
        }else{
            return $total;
        }
    }
  
    //realiza el resultado de los numeros multiplicados por 1 segun las reglas de luhn
    function numImpares($numeros){
        $num1 = substr($numeros,1,-14);
        $num2 = substr($numeros,3,-12);
        $num3 = substr($numeros,5,-10);
        $num4 = substr($numeros,7,-8);
        $num5 = substr($numeros,9,-6);
        $num6 = substr($numeros,11,-4);
        $num7 = substr($numeros,13,-2);
        $num8 = substr($numeros,-1);
    
        $total = $num1 + $num2 + $num3 + $num4 + $num5 + $num6 + $num7 + $num8;
        return $total;
    }
?>