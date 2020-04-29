<?php
    //Obtiene la franquicia a la que pertence la tarjeta
    function getFranquicia($cardNum){
        $franquicia = "";
        $num = substr($cardNum,2,-13);

        switch ($num) {
            case '41':
                $franquicia = "Visa";
                break;

            case '51':
                $franquicia = "Master Card";
                break;

            case '52':
                $franquicia = "Master Card";
                break;

            case '53':
                $franquicia = "Master Card";
                break;

            case '54':
                $franquicia = "Master Card";
                break;

            case '55':
                $franquicia = "Master Card";
                break; 
            
            case '61':
                $franquicia = "Discovery";
                break;   
            
            case '30':
                $franquicia = "American Express";
                break;
            
            case '34':
                $franquicia = "Amex";
                break;

            case '37':
                $franquicia = "Amex";
                break;
            
            default:
                $franquicia = "Uknown";
                break;
        }
        return $franquicia;
    }

    //encripta el numero de la tarjeta
    function encript($cardNum){
        //$num = password_hash($cardNum,PASSWORD_DEFAULT,['cost' => 15]);
        $num = $cardNum;

        return $num;
    }

    //desencripta el numero de la tarjeta y valida si coincide con la que se ingresa
    function desencript($cardNum,$hash){
        $num = $cardNum;
        if(password_verify($cardNum,$hash)){
            $num = $cardNum;
        }else{
            echo "<script>alert('Los numero no coinciden')</script>";
        }
        return $num;
    }
    
    //genera un token aleatorio de 18 digitos
    function token($cardNumEncript){
        $num = 123456789012345678;
        return $num;
    }

?>