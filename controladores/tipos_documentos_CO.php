<?php
require_once "modelos/tipos_documentos_MO.php";

class tipos_documentos_CO
{
    function __construct(){}
    
    function guardar()
    {
        $nombre=$_POST["nombre"];
        $orden=$_POST["orden"];

        $conexion=new conexion();

        $tipos_documentos_MO=new tipos_documentos_MO($conexion);

        $tipos_documentos_MO->guardar($nombre,$orden);

        echo $tipos_documentos_MO->traerSecuencia()[0]->currval;
    }

    function actualizar()
    {
        $nombre=$_POST["nombre"];
        $activo=$_POST["activo"];
        $orden=$_POST["orden"];
        $id=$_POST["id"];

        $conexion=new conexion();

        $tipos_documentos_MO=new tipos_documentos_MO($conexion);

        $tipos_documentos_MO->actualizar($nombre,$activo,$orden,$id);

        echo "EXITO";
    }

    function eliminar()
    {
        $id=$_POST["id"];

        $conexion=new conexion();

        $tipos_documentos_MO=new tipos_documentos_MO($conexion);

        $tipos_documentos_MO->eliminar($id);

        echo "EXITO";
    }
}
?>