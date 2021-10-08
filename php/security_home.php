<?php 

    @session_start(); 

    if(!isset($_SESSION["usuario_nombre"]))
    {
        header("Location: index.php"); 
        exit(); 
    }
    else
        {
            $inactive = 900;
            $currentTimeinSeconds = time();
            //echo "session activa =" . date('F d, Y h:i:s A',$_SESSION['tiempo'])."<br>";
        
            if(isset($_SESSION['tiempo']) )
            {
                $life_session = $currentTimeinSeconds - $_SESSION['tiempo'];
                //echo "life_session=". $life_session."<<br>";
                if($life_session > $inactive)
                {
                    session_destroy();
                    header("Location: index.php"); 
                    exit();
                }
            }

            $_SESSION['tiempo'] = $currentTimeinSeconds;
        }

?>