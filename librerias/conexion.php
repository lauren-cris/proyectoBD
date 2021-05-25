<?php
class conexion
{
    private $conexion;
    private $resultado;

    function __construct()
    {
        $ip_maquina = "localhost";
        $puerto = '5432';
        $base_de_datos = 'citygold';
        $usuario = 'rol_citygold';
        $clave = 'rol_citygold_2021';

        try
        {
            $this->conexion  = new PDO("pgsql:host=$ip_maquina;port=$puerto;dbname=$base_de_datos", $usuario, $clave);
        } 
        catch (PDOException $pe) 
        {
            exit("ERROR: ".$pe->getMessage());
        }
    }

    function consulta($sql)
    {
        $this->resultado=$this->conexion->query($sql) or exit("ERROR: Consulta mal estructurada");

        if(strtoupper(substr($sql, 0, 6))=='SELECT' && $this->resultado)
        return $this->resultado->fetchAll(PDO::FETCH_OBJ);
        else
        if(!$this->resultado->rowCount())
        exit("ERROR: Sin Cambios");
    }
}
?>