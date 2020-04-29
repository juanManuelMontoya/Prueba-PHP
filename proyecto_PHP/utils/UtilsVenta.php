<?php
    include "utils/Utils.php";

    //inserta los datos del visitante
    function insertVisita($conexion,$ip,$fecha,$hora){
        $numTransaccion = 0;
        $consu="insert into visitas(ip_cliente,fecha,time) 
        values('$ip','$fecha','$hora')";
        insertUpdate($conexion,$consu);
     }

     //valida si hay un exceso de peticiones y lo notifica
    function excesoPeticiones($conexion,$ip,$fecha,$cardNum){
        $consu = "select numeroTransacciones from visitas where ip_cliente ='$ip'
        and numeroTarjeta =".$cardNum." 
        and fecha ='$fecha'";
        $rs = mysqli_query($conexion,$consu);
        $fila = mysqli_fetch_array($rs);

        if($fila["numeroTransacciones"] > 3){
            echo "<script>alert('Solicitud negada exceso de peticiones')</script>";
            updateTransaccion($conexion,$ip,$fecha,$cardNum,$fila);
        }else{
            updateTransaccion($conexion,$ip,$fecha,$cardNum,$fila);
        }
        
     }

     //actualiza el numero de transacciones hecha por una misma ip en el mismo dia
     function updateTransaccion($conexion,$ip,$fecha,$cardNum,$fila){
        $numTransaccion = $fila['numeroTransacciones'] + 1;
        $consu = "update visitas set numeroTransacciones =".$numTransaccion." 
        where ip_cliente ='$ip'
        and numeroTarjeta =".$cardNum." 
        and fecha ='$fecha'";
        insertUpdate($conexion,$consu);
     }

     //valida si esta registrada una ip en el dia 
     function getVisitaBycard($conexion,$ip,$fecha,$cardNum){
        $var = "numeroTransacciones";
        $consu = "select count(*) as $var from visitas where ip_cliente ='$ip'
        and numeroTarjeta =".$cardNum." 
        and fecha ='$fecha'";
        if(consulta($conexion,$consu,$var)){
            return true;
        }else{
            return false;
        }
     }

     //Actualizar Hora de ingreso a la pagina
     function updateHora($conexion,$ip,$fecha,$hora){
        $consu = "update visitas set time ='$hora' where ip_cliente ='$ip' 
        and fecha ='$fecha'";
        insertUpdate($conexion,$consu);
     }

     //Actualizar el numero de tarjeta
     function updateNumTarjeta($conexion,$numCard,$ip,$fecha){
        $numTransaccion = 1; 
        $consu = "update visitas set numeroTarjeta =".$numCard.", numeroTransacciones =".$numTransaccion."
        where ip_cliente ='$ip' 
        and fecha ='$fecha'";
        insertUpdate($conexion,$consu);
     }

     //Consulta si existe una ip el dia de ho registrada 
     function getVisita($conexion,$ip,$fecha){
        $var = "numeroTransacciones";
        $consu = "select count(*) as $var from visitas where ip_cliente ='$ip'
        and fecha ='$fecha'";
        if(consulta($conexion,$consu,$var)){
            return true;
        }else{
            return false;
        }
     }

     //metodo que ejecuta la consulta
     function consulta($conexion,$consu,$var){
        $rs = mysqli_query($conexion,$consu);
        $fila = mysqli_fetch_array($rs);
        if($fila[$var] == 0){
            return false;
        }else{
            return true;
        }
     }
?>