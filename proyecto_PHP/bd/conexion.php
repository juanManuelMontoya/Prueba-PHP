<?php
    function conexionbd(){
        $conexion=mysqli_connect("localhost","root","","bdempresa");
        if($conexion){
            mysqli_set_charset($conexion,"utf8");
            return $conexion;
        
        }else{
            echo "<script> alert('no se pudo establecer la conexion con la base de datos')</script>";
            return false;
        }
    }
?>