<?php
class tipos_documentos_MO
{
    private $conexion;

    function __construct($conexion)
    {
        $this->conexion=$conexion;
    }

    function guardar($nombre,$orden)
    {
        $sql = "INSERT INTO city.tipos_documentos (nombre,orden) VALUES ('$nombre','$orden')";
        $this->conexion->consulta($sql);
    }

    function listar()
    {
        $sql = "SELECT * FROM city.tipos_documentos ORDER BY id_tipos_documentos DESC";
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
		$sql = "SELECT currval('city.tipos_documentos_id_tipos_documentos_seq')";
		return $this->conexion->consulta($sql);
	}
}
?>