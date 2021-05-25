<?php
class productos_MO
{
    private $conexion;

    function __construct($conexion)
    {
        $this->conexion=$conexion;
    }

    function guardar($nombre,$descripcion,$precio,id_categorias)
    {
        $sql = "INSERT INTO city.productos (nombre,descripcion,precio,id_categorias) VALUES ('$nombre','$descripcion','$precio','id_categorias')";
        $this->conexion->consulta($sql);
    }

    function listar()
    {
        $sql = "SELECT * FROM city.productos ORDER BY id_productos DESC";
        return $this->conexion->consulta($sql);
    }

    function seleccionar($campo,$valor)
    {
        $sql = "SELECT * FROM city.productos WHERE $campo='$valor'";
        return $this->conexion->consulta($sql);
    }

    function actualizar($nombre,$descripcion,$precio,id_categorias)
    {
        $sql = "UPDATE city.productos SET nombre='$nombre', descripcion='$descripcion', precio='$precio' WHERE id_productos='$id'";
        $this->conexion->consulta($sql);
    }

    function eliminar($id)
    {
        $sql = "DELETE FROM city.productos WHERE id_productos='$id'";
        $this->conexion->consulta($sql);
    }

	function traerSecuencia()
	{
		$sql = "SELECT currval('city.productos_id_productos_seq')";
		return $this->conexion->consulta($sql);
	}
}
?>