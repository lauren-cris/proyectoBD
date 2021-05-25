<?php
class accesos_MO
{
    private $conexion;

    function __construct($conexion)
    {
        $this->conexion=$conexion;
    }

    function inicioSesion($usuario,$clave)
    {
        $sql = "SELECT id_personas FROM city.accesos WHERE usuario='$usuario' AND clave='$clave'";
        return $this->conexion->consulta($sql);
    }

    function guardar($usuario,$clave,$id_personas)
    {
        $sql = "INSERT INTO city.accesos (usuario,clave,id_personas) VALUES ('$usuario','$clave','$id_personas')";
        $this->conexion->consulta($sql);
    }


    function listar()
    {
        $sql = "SELECT * FROM city.accesos ORDER BY id_accesos DESC";
        return $this->conexion->consulta($sql);
    }

    function seleccionar($campo,$valor)
    {
        $sql = "SELECT * FROM city.accesos WHERE $campo='$valor'";
        return $this->conexion->consulta($sql);
    }

    function actualizar($usuario,$activo,$clave,$id)
    {
        $sql = "UPDATE city.accesos SET usuario='$usuario', activo='$activo', clave='$clave' WHERE id_accesos='$id'";
        $this->conexion->consulta($sql);
    }

    function eliminar($id)
    {
        $sql = "DELETE FROM city.accesos WHERE id_accesos='$id'";
        $this->conexion->consulta($sql);
    }

	function traerSecuencia()
	{
		$sql = "SELECT currval('city.accesos_id_accesos_seq')";
		return $this->conexion->consulta($sql);
	}
}
?>