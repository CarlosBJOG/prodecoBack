<?php

//modelo de la tabla categoria
require_once "db.php";



class EmpleadosModelo {
   
    public $mysql;
    //constructor de clase 
    public function __construct(){
        $this->mysql = new database();
    }

    public function sexo(){
        $query = "SELECT * FROM sexo";

        return $this->mysql->getRows($query);
    }

    public function estados(){
        $query = "SELECT * FROM estados";

        return $this->mysql->getRows($query);
    }

    public function delegacion($valor){
        $query = "SELECT * FROM municipios WHERE idkey_estados = '".$valor."' ORDER BY nombre ASC";

        return $this->mysql->getRows($query);
    }

    public function localidad($valor){
        $query = "SELECT * FROM localidad WHERE idkey_municipios = '".$valor."' ORDER BY nombre ASC";

        return $this->mysql->getRows($query);

    }

    public function cp($valor){
        $query = "SELECT * FROM codigo_postal WHERE idkey_localidad = '".$valor."' ORDER BY nombre ASC";

        return $this->mysql->getRows($query);
    }

    public function guardar_empleado($array){
        date_default_timezone_set("America/Mexico_City");
        $time = time();
        $fecha_actual = date('Y-m-d');
        $hora = date('H:i:s', $time);

        $fecha = $fecha_actual.' '.$hora;

        $query = "INSERT INTO datos_empleados (nombre, apellido_p, apellido_m, edad, sexo, domicilio, estado, ciudad, localidad, cp, ine, rfc, celular, tel_casa, tel_oficina, email, fecha_registro)
        values ('".$array[0]."', '".$array[1]."', '".$array[2]."', '".$array[3]."', '".$array[4]."', '".$array[5]."', '".$array[6]."', '".$array[7]."', '".$array[8]."', '".$array[9]."', '".$array[10]."',
         '".$array[11]."', '".$array[12]."', '".$array[13]."', '".$array[14]."', '".$array[15]."', '".$fecha."')";

        return $this->mysql->ShotSimple($query);
    }

    public function cargar_rfc(){
        $query = "SELECT rfc FROM datos_empleados";

        return $this->mysql->getRows($query);

    }

    public function cargar_empleados(){
        $query = "SELECT de.idkey, de.nombre, de.apellido_p, de.apellido_m, de.edad, de.sexo, de.rfc, de.email, u.idkey_tipo_usuario, ut.nombre as tipo_usuario, u.usuario_nombre as nom_usuario, de.fecha_registro FROM usuarios u INNER JOIN datos_empleados de on u.idkey_empleados = de.idkey INNER JOIN usuarios_tipo ut ON u.idkey_tipo_usuario = ut.idkey WHERE u.activo = '1' ";
        
        return $this->mysql->getRows($query);

    }

    public function cargar_permisos(){
        $query = "SELECT idkey, nombre FROM usuarios_tipo";

        return $this->mysql->getRows($query);

    }

    public function guardar_usuario($nombre, $pass, $idkey_empleado, $idkey_usuario){

        $query = "INSERT INTO usuarios (usuario_nombre, usuario_contra, idkey_empleados, idkey_tipo_usuario) VALUES 
        ('".$nombre."', '".$this->mysql->encriptar($pass)."', '".$idkey_empleado."', '".$idkey_usuario."')";

        return $this->mysql->ShotSimple($query);

    }

    public function cargar_info_usuario($idkey){
        $query = "SELECT de.nombre as nombre, u.usuario_nombre as usuario, ut.nombre as nombre_usuario FROM usuarios u INNER JOIN datos_empleados de ON u.idkey_empleados = de.idkey INNER JOIN usuarios_tipo ut on u.idkey_tipo_usuario = ut.idkey WHERE u.idkey_empleados = '".$idkey."' ";

        return $this->mysql->getRows($query);
    }

    public function update_user($idkey, $perfil, $usuario ){
        $query ="UPDATE usuarios SET usuario_nombre = '$usuario', idkey_tipo_usuario = '$perfil'WHERE idkey_empleados = '".$idkey."' ";

        return $this->mysql->shotSimple($query);
    }
    

    public function delete_user($idkey){
        $query =  "UPDATE usuarios SET activo = '0' WHERE idkey_empleados = '".$idkey."' ";
       

        return $this->mysql->shotSimple($query);
    }

    public function cargar_empleado($idkey){
        $query = "SELECT * FROM datos_empleados WHERE idkey = '".$idkey."' ";

        return $this->mysql->getRows($query);

    }

    public function ulti_registro(){
        $query = "SELECT idkey FROM datos_empleados ORDER BY idkey DESC LIMIT 1 ";

        return $this->mysql->getRows($query);
    }

    public function guardar_edit_empleado($array){
        $query = "UPDATE datos_empleados SET nombre ='".$array[0]."',   apellido_p ='".$array[1]."' , apellido_m = '".$array[2]."',  edad= '".$array[3]."', 
         sexo= '".$array[4]."', domicilio='".$array[5]."',  estado='".$array[6]."',  ciudad='".$array[7]."',  localidad='".$array[8]."', cp='".$array[9]."',  
         ine='".$array[10]."', rfc='".$array[11]."',  celular='".$array[12]."', tel_casa='".$array[13]."',  tel_oficina='".$array[14]."',  email='".$array[15]."' WHERE idkey = '".$array[16]."' ";

        return $this->mysql->ShotSimple($query);
    }

    public function cargar_parentesco(){
        $query = "SELECT idkey, nombre, maximo FROM parentesco";

        return $this->mysql->getRows($query);

    }

    public function guardar_familiar($array) {
        date_default_timezone_set("America/Mexico_City");
        $time = time();
        $fecha_actual = date('Y-m-d');
        $hora = date('H:i:s', $time);

        $fecha = $fecha_actual.' '.$hora;

        $query = "INSERT INTO datos_familiares (nombre, apellido_p, apellido_m, edad, domicilio, estado, ciudad, localidad, cp, ine, parentesco, num_cel, num_casa, email, sexo, fecha_registro, idkey_empleado)
        values ('".$array[0]."', '".$array[1]."', '".$array[2]."', '".$array[3]."', '".$array[4]."', '".$array[5]."', '".$array[6]."', '".$array[7]."', '".$array[8]."', '".$array[9]."', '".$array[10]."',
         '".$array[11]."', '".$array[12]."', '".$array[13]."', '".$array[14]."',  '".$fecha."', '".$array[15]."')";

        return $this->mysql->shotSimple($query);

    }


    public function contar_familiar($idkey){

        $query = "SELECT count(idkey_empleado) as num_familiar from datos_familiares where idkey_empleado = '$idkey' ";

        return $this->mysql->getRows($query);

    }

    public function cargar_familiares($idkey){
        $query = "SELECT df.idkey, concat(df.nombre,' ', df.apellido_p,' ',df.apellido_m)as nombre, df.fecha_registro, df.ine, df.num_cel, de.nombre as empleado, p.nombre as familiar, df.domicilio from datos_familiares df INNER JOIN usuarios u ON df.idkey_empleado = u.idkey_empleados INNER JOIN datos_empleados de ON de.idkey = u.idkey_empleados INNER JOIN parentesco p ON df.parentesco = p.idkey where df.idkey_empleado = '$idkey'" ;
        return $this->mysql->getRows($query);
    }

    public function eliminar_familiar($idkey){
        $query = "DELETE FROM datos_familiares WHERE idkey = '".$idkey."'";
        return $this->mysql->shotSimple($query);
    }

    public function cargar_familiar($idkey){
        $query = "SELECT * FROM datos_familiares WHERE idkey = '".$idkey."' ";

        return $this->mysql->getRows($query);
    }

    public function update_fam($array){
        $query = "UPDATE datos_familiares SET nombre ='".$array[0]."',   apellido_p ='".$array[1]."' , apellido_m = '".$array[2]."',  edad= '".$array[3]."', 
        domicilio= '".$array[4]."', estado='".$array[5]."',  ciudad='".$array[6]."',  localidad='".$array[7]."',  cp='".$array[8]."', ine='".$array[9]."',  
        parentesco='".$array[10]."', num_cel='".$array[11]."',  num_casa='".$array[12]."', email='".$array[13]."',  sexo='".$array[14]."' WHERE idkey = '".$array[15]."' ";

       return $this->mysql->ShotSimple($query);
    }


    
}

?>