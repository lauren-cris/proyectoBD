<?php
require_once "modelos/personas_MO.php";

class personas_CO
{
    function __construct(){}
    
    function registrarse()
    {
        require_once "modelos/accesos_MO.php";
        
        $nombre1=$_POST["nombre1"];
        $nombre2=$_POST["nombre2"];
        $apellido1=$_POST["apellido1"];
        $apellido2=$_POST["apellido2"];
        $id_tipos_documentos=$_POST["id_tipos_documentos"];
        $documento=$_POST["documento"];
        $correo=$_POST["correo"];
        $direccion=$_POST["direccion"];
        $fecha_nacimiento=$_POST["fecha_nacimiento"];
        $usuario=$_POST["usuario"];
        $clave=$_POST["clave"];

        $conexion=new conexion();

        $personas_MO=new personas_MO($conexion);
        $accesos_MO=new accesos_MO($conexion);

        $personas_MO->guardar($nombre1,$nombre2,$apellido1,$apellido2,$id_tipos_documentos,$documento,$correo, $direccion,$fecha_nacimiento);

        $id_personas=$personas_MO->traerSecuencia()[0]->currval;

        $accesos_MO->guardar($usuario,$clave,$id_personas);

        $_SESSION["id_personas"]=$id_personas;
        $_SESSION["autenticado"]="SI";
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