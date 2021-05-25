<?php
session_start();

require_once "librerias/conexion.php";
require_once "librerias/front_controller.php";

if(isset($_SESSION["autenticado"]) && $_SESSION["autenticado"]=="SI")
{
    front_controller::main();
}
else if(isset($_POST["opcion_datos"]) && $_POST["opcion_datos"]=='enviados')
{
    require_once "controladores/personas_CO.php";
    $personas_CO=new personas_CO();
    $personas_CO->registrarse();
}
else if(isset($_GET["opcion"]) && $_GET["opcion"]=='registrarse')
{
    require_once "vistas/personas_VI.php";
    $personas_VI=new personas_VI();
    $personas_VI->registrarse();
}
else if(isset($_POST["usuario"]) && isset($_POST["clave"]))
{
    require_once "controladores/accesos_CO.php";
    $accesos_CO=new accesos_CO();
    $accesos_CO->inicioSesion();
}
else
{
    require_once "vistas/accesos_VI.php";
    $accesos_VI=new accesos_VI();
    $accesos_VI->inicioSesion();
}
?>