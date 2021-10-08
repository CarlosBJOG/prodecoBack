<?php

    include("db_config.php");
    include("encrypting.php");

    class database extends encrypting
    {
        var $numberRows;
        var $last_id;

        function __construct()
        {
            $this->numberRows=0;            
        }

        function showVariables()
        {            
            $rows = $this->getRows("SHOW VARIABLES;");
            echo "<table border='0' cellpadding='4' cellspacing='0' ><tr><td>Variables_name</td><td>Value</td></tr>";

            foreach($rows as $items)
            {
                //print_r($items);
                echo "<tr><td>".$items["Variable_name"]."</td><td>".$items["Value"]."</td></tr>";
            }
            echo "</table>";
        }

        function GetConnections()
        { 
            $conn = mysqli_connect(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME,3306);
            if (!$conn)
            {
                printf("Error de conexión: %s\n", mysqli_connect_error());
                exit();
            }
            $conn->set_charset("utf8");
            return ($conn);		
        }
     
        function CloseConnections($param)
         {
             mysqli_close($param);
         }
    
    
        function getRows($params)
        {
            $all = array();
            $this->numberRows;
            $oconn = $this->GetConnections();
            if ($resultado = mysqli_query($oconn, $params)) {
                $this->numberRows = $resultado->num_rows;
                while ($fila = $resultado->fetch_array()) {
                    $all[]=$fila;
                }
            }
            $this->CloseConnections($oconn);    	
            return $all;
        }
    
    
        function getSimple($params)
        {
            $oconn = $this->GetConnections();
            $rows = mysqli_query($oconn,$params);
            $records = $rows->fetch_array();
            $retorno=$records[0];
            $this->CloseConnections($oconn);
            return $retorno;
        }
    
        function ShotSimple($param)
        {
            $oconn = $this->GetConnections();
            mysqli_query($oconn,$param);
            $this->last_id = $oconn->insert_id;
            //echo "<br>idkey recuperado= ".$oconn->insert_id."<br>";            
            $this->CloseConnections($oconn);
        }

    }    
?>
