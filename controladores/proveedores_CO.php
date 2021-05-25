<?php
require_once "modelos/proveedores_MO.php";

class proveedores_CO
{
    function __construct(){}
    
    function guardar()
    {
        $nombre_proveedor=$_POST["nombre_proveedor"];
        $direccion_proveedor=$_POST["direccion_proveedor"];
        $celular_proveedor=$_POST["celular_proveedor"];
        $correo_proveedor=$_POST["correo_proveedor"];
        $red_social_proveedor=$_POST["red_social_proveedor"];


        $conexion=new conexion();

        $proveedores_MO=new proveedores_MO($conexion);

        $proveedores_MO->guardar($nombre_proveedor,$direccion_proveedor,$celular_proveedor,$correo_proveedor,$red_social_proveedor);

        echo $proveedores_MO->traerSecuencia()[0]->currval;
    }

    function actualizar()
    {
        $nombre_proveedor=$_POST["nombre_proveedor"];
        $direccion_proveedor=$_POST["direccion_proveedor"];
        $celular_proveedor=$_POST["celular_proveedor"];
        $correo_proveedor=$_POST["correo_proveedor"];
        $red_social_proveedor=$_POST["red_social_proveedor"];
        $id=$_POST["id"];

        $conexion=new conexion();

        $proveedores_MO=new proveedores_MO($conexion);

        $proveedores_MO->actualizar($nombre_proveedor,$direccion_proveedor,$celular_proveedor,$correo_proveedor,$red_social_proveedor,$id);

        echo "EXITO";
    }

    function eliminar()
    {
        $id=$_POST["id"];

        $conexion=new conexion();

        $proveedores_MO=new proveedores_MO($conexion);

        $proveedores_MO->eliminar($id);

        echo "EXITO";
    }
}
?>