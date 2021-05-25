<?php
class proveedores_MO
{
    private $conexion;

    function __construct($conexion)
    {
        $this->conexion=$conexion;
    }

    function guardar($nombre_proveedor,$direccion_proveedor,$celular_proveedor,$correo_proveedor,$red_social_proveedor)
    {
        $sql = "INSERT INTO city.proveedor (nombre_proveedor,direccion_proveedor,celular_proveedor,correo_proveedor,red_social_proveedor) VALUES ('$nombre_proveedor','$direccion_proveedor','$celular_proveedor','$correo_proveedor','$red_social_proveedor')";
        $this->conexion->consulta($sql);
    }

    function listar()
    {
        $sql = "SELECT * FROM city.proveedor ORDER BY id_proveedor DESC";
        return $this->conexion->consulta($sql);
    }

    function seleccionar($campo,$valor)
    {
        $sql = "SELECT * FROM city.proveedor WHERE $campo='$valor'";
        return $this->conexion->consulta($sql);
    }

    function actualizar($nombre_proveedor,$direccion_proveedor,$celular_proveedor,$correo_proveedor,$red_social_proveedor,$id)
    {
        $sql = "UPDATE city.proveedor SET nombre_proveedor='$nombre_proveedor', direccion_proveedor='$direccion_proveedor', celular_proveedor='$celular_proveedor', correo_proveedor='$correo_proveedor', red_social_proveedor='$red_social_proveedor' WHERE id_proveedor='$id'";
        $this->conexion->consulta($sql);
    }

    function eliminar($id)
    {
        $sql = "DELETE FROM city.proveedor WHERE id_proveedor='$id'";
        $this->conexion->consulta($sql);
    }

	function traerSecuencia()
	{
		$sql = "SELECT currval('city.proveedor_id_proveedor_seq')";
		return $this->conexion->consulta($sql);
	}
}
?>