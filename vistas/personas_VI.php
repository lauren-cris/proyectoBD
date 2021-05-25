<?php
class personas_VI
{
    function __construct(){}

    function registrarse()
    {
        require_once "modelos/tipos_documentos_MO.php";
        $conexion=new conexion();
        $tipos_documentos_MO=new tipos_documentos_MO($conexion);
  
        $arreglo=$tipos_documentos_MO->listar();
        ?>
        <!doctype html>
        <html lang="es">
        <head>
        <meta charset="utf-8">
        <title>Desing Pink</title>
        <!-- CSS only -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
        
        <!-- Toastr -->
        <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
        </head>
        <body>
        <div class="card  mx-5 my-5">
            <div class="card-header bg-light">
                Registarse
            </div>
            <div class="card-body">
                <form id="formulario_agregar">
                <div class="form-group">
                    <label for="nombre1">Primer Nombre</label>
                    <input type="text" class="form-control" id="nombre1" name="nombre1">
                </div>

                <div class="form-group">
                    <label for="nombre2">Segundo Nombre</label>
                    <input type="text" class="form-control" id="nombre2" name="nombre2">
                </div>

                <div class="form-group">
                    <label for="apellido1">Primer Apellido </label>
                    <input type="text" class="form-control" id="apellido1" name="apellido1">
                </div>

                <div class="form-group">
                    <label for="apellido2">Segundo Apellido</label>
                    <input type="text" class="form-control" id="apellido2" name="apellido2">
                </div>

                <div class="form-group">
                    <label for="id_tipos_documentos">Tipos de documentos</label>
                    <select class="form-control" id="id_tipos_documentos" name="id_tipos_documentos">
                    <option value=""></option>
                    <?php
                    foreach($arreglo as $objeto)
                    {
                        ?>
                        <option value="<?php echo $objeto->id_tipos_documentos;?>"><?php echo $objeto->nombre;?></option>
                        <?php
                    }
                    ?>
                    </select>
                </div>


                <div class="form-group">
                    <label for="orden">Documento</label>
                    <input type="text" class="form-control" id="documento" name="documento">
                </div>

                <div class="form-group">
                    <label for="orden">Correo</label>
                    <input type="text" class="form-control" id="correo" name="correo">
                </div>

                <div class="form-group">
                    <label for="orden">Direccion</label>
                    <input type="text" class="form-control" id="direccion" name="direccion">
                </div>

                <div class="form-group">
                    <label for="orden">Fecha de nacimiento</label>
                    <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento">
                </div>
                <div class="mb-3">
                <label for="usuario">Usuario</label>
                <input type="text" class="form-control" id="usuario" name="usuario">
                 </div>
                <div class="mb-3">
                <label for="clave">Clave</label>
                <input type="password" class="form-control" id="clave" name="clave">
                </div>

                <input type="hidden" class="form-control" id="opcion_datos" name="opcion_datos" value="enviados">

                <button type="button" class="btn btn-primary float-right" onclick="registrarse()">Guardar</button>
                </form>
            </div>
            <!-- jQuery -->
            <script src="plugins/jquery/jquery.min.js"></script>

            <!-- Toastr -->
            <script src="plugins/toastr/toastr.min.js"></script>
            <script>
            function registrarse()
            {
                var cadena=$('#formulario_agregar').serialize();

                $.post('index.php',cadena,function(respuesta)
                {
                    var buscar=/ERROR/;
                    var resultado=buscar.test(respuesta);

                    if(resultado)
                    {
                        toastr.error(respuesta);
                    }
                    else
                    {
                        toastr.success('Registro Agregado');
                        setTimeout(function(){ location.href="index.php"; }, 1000);
                    }
                });
            }
            </script>

        </div>
        </body>
        </html>


        <?php
    }

    function listar()
    {
        require_once "modelos/tipos_documentos_MO.php";
        $conexion=new conexion();
        $tipos_documentos_MO=new tipos_documentos_MO($conexion);
  
        $arreglo=$tipos_documentos_MO->listar();

        foreach($arreglo as $objeto)
        {
            ?>
            <tr id="fila<?php echo $objeto->id_tipos_documentos;?>">
            <td><?php echo $objeto->nombre;?></td>
            <td><?php echo $objeto->activo;?></td>
            <td><?php echo $objeto->orden;?></td>
            <td> 
            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#ventana_modal" onclick="verActualizar('<?php echo $objeto->id_tipos_documentos;?>')">Actualizar</button>
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#ventana_modal" onclick="confirmarEliminar('<?php echo $objeto->id_tipos_documentos;?>')">Eliminar</button>
            </td>
            </tr>
            <?php
        }
    }

    function verActualizar()
    {
        require_once "modelos/tipos_documentos_MO.php";
        $conexion=new conexion();
        $tipos_documentos_MO=new tipos_documentos_MO($conexion);
  
        $arreglo=$tipos_documentos_MO->seleccionar('id_tipos_documentos',$_POST['id']);
        $nombre=$arreglo[0]->nombre;
        $activo=$arreglo[0]->activo;
        $orden=$arreglo[0]->orden;
        ?>
        <div class="card">
            <div class="card-body">
                <form id="formulario_actualizar">
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $nombre;?>">
                </div>

                <div class="form-group">
                    <label for="activo">Activo</label>
                    <select class="form-control" id="activo" name="activo">
                    <option value="<?php echo ($activo=='SI') ? 'SI' : 'NO';?>"><?php echo ($activo=='SI') ? 'SI' : 'NO';?></option>
                    <option value="<?php echo ($activo!='SI') ? 'SI' : 'NO';?>"><?php echo ($activo!='SI') ? 'SI' : 'NO';?></option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="orden">Orden</label>
                    <input type="number" class="form-control" id="orden" name="orden" value="<?php echo $orden;?>">
                </div>

                <input type="hidden" name="id" value="<?php echo $_POST['id'];?>">

                <button type="button" class="btn btn-primary float-right" onclick="actualizar()">Guardar</button>

                </form>
            </div>
        </div>

        <script>
        function actualizar()
        {
            var cadena=$('#formulario_actualizar').serialize();

            var nombre=$('#formulario_actualizar #nombre').val();
            var activo=$('#formulario_actualizar #activo').val();
            var orden=$('#formulario_actualizar #orden').val();

            $.post('tipos_documentos_CO/actualizar',cadena,function(respuesta)
            {
                var buscar=/EXITO/;
			    var resultado=buscar.test(respuesta);

                if(resultado)
                {
                    toastr.success(respuesta);

                    

                    $('#fila<?php echo $_POST['id'];?>').find("td").eq(0).html(nombre);
                    $('#fila<?php echo $_POST['id'];?>').find("td").eq(1).html(activo);
                    $('#fila<?php echo $_POST['id'];?>').find("td").eq(2).html(orden);
                }
                else
                {
                    toastr.error(respuesta);
                }
            });
        }
        </script>
        <?php
    }
}
?>