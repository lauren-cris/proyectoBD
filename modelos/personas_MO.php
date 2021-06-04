<?php
class personas_MO
{
    private $conexion;

    function __construct($conexion)
    {
        $this->conexion=$conexion;
    }

    function guardar($nombre1,$nombre2,$apellido1,$apellido2,$id_tipos_documentos,$documento,$correo,$celular,$direccion,$fecha_nacimiento)
    {
        $sql = "INSERT INTO city.personas (nombre1,nombre2,apellido1,apellido2,id_tipos_documentos,documento,correo,celular,direccion,fecha_nacimiento) VALUES ('$nombre1','$nombre2','$apellido1','$apellido2','$id_tipos_documentos','$documento','$correo','$celular','$direccion','$fecha_nacimiento')";
        $this->conexion->consulta($sql);
    }

    function listar()
    {
        $sql = "SELECT * FROM city.personas ORDER BY id_personas DESC";
        return $this->conexion->consulta($sql);
    }

    function seleccionar($campo,$valor)
    {
        $sql = "SELECT * FROM city.tipos_documentos WHERE $campo='$valor'";
        return $this->conexion->consulta($sql);
    }

    function actualizar($nombre,$activo,$orden,$id)
    {
        $sql = "UPDATE city.tipos_documentos SET nombre='$nombre', activo='$activo', orden='$orden' WHERE id_tipos_documentos='$id'";
        $this->conexion->consulta($sql);
    }

    function eliminar($id)
    {
        $sql = "DELETE FROM city.tipos_documentos WHERE id_tipos_documentos='$id'";
        $this->conexion->consulta($sql);
    }

	function traerSecuencia()
	{
		$sql = "SELECT currval('city.personas_id_personas_seq')";
		return $this->conexion->consulta($sql);
	}
}
?>