<?php


    class encrypting
    {
        const conts = 'mcrypt';
        var $result;


        function __construct()
        {
            $this->result="";
        }


        function encrypt($string, $key)
        {
            $this->result="";
            for($i=0; $i<strlen($string); $i++)
            {
                $char = substr($string, $i, 1);
                $keychar = substr($key, ($i % strlen($key))-1, 1);
                $char = chr(ord($char)+ord($keychar));
                $this->result.=$char;
            }
            return base64_encode($this->result);
        }
     
        function decrypt($string, $key)
        {

            $this->result="";

            $string = base64_decode($string);
            for($i=0; $i<strlen($string); $i++)
            {
                $char = substr($string, $i, 1);
                $keychar = substr($key, ($i % strlen($key))-1, 1);
                $char = chr(ord($char)-ord($keychar));
                $this->result.=$char;
            }
            return $this->result;
        }


        function showDatas()
        {
            $texto = "!#$%&'()*+,-./0123456789:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[\]^_`abcdefghijklmnopqrstuvwxyz{|}~ñÑ";
            // Encriptamos el contenido
            $texto_encriptado = $this->encrypt($texto,self::conts);
            // Desencriptamos el contenido
            $texto_original = $this->decrypt($texto_encriptado,self::conts);
            if ($texto == $texto_original) echo 'Encriptación = Desencriptación => son iguales.';     
            print_r("<br>texto encriptado = ". $texto_encriptado);
            print_r("<br>texto desencriptado = ". $texto_original);
        }

        function encriptar($param)
        {
            return $this->encrypt($param,self::conts);
        }

        function desencriptar($param)
        {
            return $this->decrypt($param,self::conts);
        }
    }

?> 