<?php
require_once "modelos/accesos_MO.php";

class accesos_CO
{
    function __construct(){}
    
    function inicioSesion()
    {
        $usuario=$_POST["usuario"];
        $clave=$_POST["clave"];

        $conexion=new conexion();

        $accesos_MO=new accesos_MO($conexion);

        $arreglo_accesos=$accesos_MO->inicioSesion($usuario,$clave);

        if($arreglo_accesos)
        {
            $_SESSION["id_personas"]=$arreglo_accesos[0]->id_personas;
            $_SESSION["autenticado"]="SI";
        }

        header("Location: index.php");
    }

    function cerrarSesion()
    {
        session_unset();
        // Destruir todas las variables de sesi&oacute;n.	
        $_SESSION = array();
        
        // Si se desea destruir la sesi&oacute;n completamente, borre tambi&eacute;n la cookie de sesi&oacute;n.
        // Nota: !Esto destruir&aacute; la sesi&oacute;n, y no la informaci&oacute;n de la sesi&oacute;n!
        if (ini_get("session.use_cookies")) 
        {
          $params = session_get_cookie_params();
          setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
        }
        // Finalmente, destruir la sesiÃ³n.	
        session_destroy();

        echo "EXITO";
    }

    function guardar()
    {
        $usuario=$_POST["usuario"];
        $clave=$_POST["clave"];
        $id_personas=$_POST["id_personas"];

        $conexion=new conexion();

        $accesos_MO=new accesos_MO($conexion);

        $accesos_MO->guardar($usuario,$clave,$id_personas);

        echo $accesos_MO->traerSecuencia()[0]->currval;
    }

    function actualizar()
    {
        $usuario=$_POST["usuario"];
        $activo=$_POST["activo"];
        $clave=$_POST["clave"];
        $id=$_POST["id"];

        $conexion=new conexion();

        $accesos_MO=new accesos_MO($conexion);

        $accesos_MO->actualizar($usuario,$activo,$clave,$id);

        echo "EXITO";
    }

    function eliminar()
    {
        $id=$_POST["id"];

        $conexion=new conexion();

        $accesos_MO=new accesos_MO($conexion);

        $accesos_MO->eliminar($id);

        echo "EXITO";
    }
}
?>