<?php
require_once "modelos/productos_MO.php";

class productos_CO
{
    function __construct(){}
    
    function guardar()
    {
        $nombre=$_POST["nombre"];
        $descripcion=$_POST["descripcion"];
        $precio=$_POST["precio"];
        $id_categorias=$_POST["id_categorias"];
        

        $conexion=new conexion();

        $productoss_MO=new productos_MO($conexion);

        $productos_MO->guardar($nombre,$descripcion,$precio,id_categorias);

        echo $productos_MO->traerSecuencia()[0]->currval;
    }

    function actualizar()
    {
        $nombre=$_POST["nombre"];
        $activo=$_POST["activo"];
        $orden=$_POST["orden"];
        $id=$_POST["id"];

        $conexion=new conexion();

        $productos_MO=new productoss_MO($conexion);

        $productos_MO->actualizar($nombre,$activo,$orden,$id);

        echo "EXITO";
    }

    function eliminar()
    {
        $id=$_POST["id"];

        $conexion=new conexion();

        $productos_MO=new productos_MO($conexion);

        $productos_MO->eliminar($id);

        echo "EXITO";
    }
}
?>