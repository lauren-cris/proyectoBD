<?php
class accesos_VI
{
    function __construct(){}

    function inicioSesion()
    {
        ?>
        <!doctype html>
        <html lang="es">
        <head>
        <meta charset="utf-8">
        <title>Desing Pink</title>
        <!-- CSS only -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
        </head>
        <body>

        <div class="card mx-5 my-5">
        <div class="card-header">
            Inicio de Sesi&oacute;n 
        </div>
        <div class="card-body">
            <form method="post" action="index.php">
            <div class="mb-3">
                <label for="usuario">Usuario</label>
                <input type="text" class="form-control" id="usuario" name="usuario">
            </div>
            <div class="mb-3">
                <label for="clave">Clave</label>
                <input type="password" class="form-control" id="clave" name="clave">
            </div>
            <button type="submit" class="btn btn-primary float-end" >Entrar</button>   
            <a href="index.php?opcion=registrarse" class="btn btn-success float-end" style="margin-right:10px;">Registrarse</a>
            </form>
        </div>
        </div>
        
        </body>
        </html>
        <?php
    }

    function crud()
    {
        require_once "modelos/personas_MO.php";
        $conexion=new conexion();
        $personas_MO=new personas_MO($conexion);
  
        $arreglo=$personas_MO->listar();
        ?>
        <div class="card">
            <div class="card-header bg-light">
                Accesos
            </div>
            <div class="card-body">
                <form id="formulario_agregar">
                <div class="form-group">
                    <label for="usuario">Usuario</label>
                    <input type="text" class="form-control" id="usuario" name="usuario">
                </div>

                <div class="form-group">
                    <label for="clave">clave</label>
                    <input type="password" class="form-control" id="clave" name="clave">
                </div>

                <div class="form-group">
                    <label for="id_personas">Personas</label>
                    <select class="form-control" id="id_personas" name="id_personas">
                    <option value=""></option>
                    <?php
                    foreach($arreglo as $objeto)
                    {
                        ?>
                        <option value="<?php echo $objeto->id_personas;?>"><?php echo $objeto->nombre1." ".$objeto->apellido1;?></option>
                        <?php
                    }
                    ?>
                    </select>
                </div>

                <button type="button" class="btn btn-primary float-right" onclick="guardar()">Guardar</button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-light">
                Listar
            </div>
            <div class="card-body">

                <table class="table">
                <thead>
                    <tr>
                    <th>Usuario</th>
                    <th>Activo</th>
                    <th>Acci&oacute;n</th>
                    </tr>
                </thead>
                <tbody id="listar_accesos">
                    <?php
                    $this->listar();
                    ?>
                </tbody>
                </table>

            </div>
        </div>

        <script>
        function guardar()
        {
            var cadena=$('#formulario_agregar').serialize();

            var usuario=$('#usuario').val();

            $.post('accesos_CO/guardar',cadena,function(id_accesos)
            {
                var buscar=/ERROR/;
			    var resultado=buscar.test(id_accesos);

                if(resultado)
                {
                    toastr.error(id_accesos);
                }
                else
                {
                    toastr.success('Registro Agregado');


                    $("#formulario_agregar")[0].reset();

                    let boton='<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#ventana_modal" onclick="verActualizar('+id_accesos+')">Actualizar</button>';
                        boton+=' <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#ventana_modal" onclick="confirmarEliminar('+id_accesos+')">Eliminar</button>';

                    let fila='<tr id="fila'+id_accesos+'">';
                    fila+='<td>'+usuario+'</td>';
                    fila+='<td>SI</td>';
                    fila+='<td>'+boton+'</td>';
                    fila+='</tr>';

                    $('#listar_accesos').prepend(fila);
                }
            });
        }

        function verActualizar(id)
        {
            $.post('accesos_VI/verActualizar',{id:id},function(respuesta)
            {
                $('#titulo_modal').html('Actualizar accesos');
                $('#contenido_modal').html(respuesta);
            });
        }

        function confirmarEliminar(id)
        {
            $('#titulo_modal').html('Confirmar la eliminaci&oacute;n');
            var contenido='¿Desea eliminar el registro?';
            contenido+='<br><br><button type="button" class="btn btn-danger" onclick="eliminar('+id+')">Eliminar</button>';
            $('#contenido_modal').html(contenido);
        }

        function eliminar(id)
        {
            $.post('accesos_CO/eliminar',{id:id},function(respuesta)
            {
                var buscar=/EXITO/;
			    var resultado=buscar.test(respuesta);

                if(resultado)
                {
                    toastr.success(respuesta);

                    $('#fila'+id).remove();
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

    function listar()
    {
        require_once "modelos/accesos_MO.php";
        $conexion=new conexion();
        $accesos_MO=new accesos_MO($conexion);
  
        $arreglo=$accesos_MO->listar();

        foreach($arreglo as $objeto)
        {
            ?>
            <tr id="fila<?php echo $objeto->id_accesos;?>">
            <td><?php echo $objeto->usuario;?></td>
            <td><?php echo $objeto->activo;?></td>
            
            <td> 
            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#ventana_modal" onclick="verActualizar('<?php echo $objeto->id_accesos;?>')">Actualizar</button>
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#ventana_modal" onclick="confirmarEliminar('<?php echo $objeto->id_accesos;?>')">Eliminar</button>
            </td>
            </tr>
            <?php
        }
    }

    function verActualizar()
    {
        require_once "modelos/accesos_MO.php";
        $conexion=new conexion();
        $accesos_MO=new accesos_MO($conexion);
  
        $arreglo=$accesos_MO->seleccionar('id_accesos',$_POST['id']);
        $usuario=$arreglo[0]->usuario;
        $activo=$arreglo[0]->activo;

        ?>
        <div class="card">
            <div class="card-body">
                <form id="formulario_actualizar">
                <div class="form-group">
                    <label for="usuario">Usuario</label>
                    <input type="text" class="form-control" id="usuario" name="usuario" value="<?php echo $usuario;?>">
                </div>

                <div class="form-group">
                    <label for="activo">Activo</label>
                    <select class="form-control" id="activo" name="activo">
                    <option value="<?php echo ($activo=='SI') ? 'SI' : 'NO';?>"><?php echo ($activo=='SI') ? 'SI' : 'NO';?></option>
                    <option value="<?php echo ($activo!='SI') ? 'SI' : 'NO';?>"><?php echo ($activo!='SI') ? 'SI' : 'NO';?></option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="clave">Clave</label>
                    <input type="password" class="form-control" id="clave" name="clave">
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

            var usuario=$('#formulario_actualizar #usuario').val();
            var activo=$('#formulario_actualizar #activo').val();
            

            $.post('accesos_CO/actualizar',cadena,function(respuesta)
            {
                var buscar=/EXITO/;
			    var resultado=buscar.test(respuesta);

                if(resultado)
                {
                    toastr.success(respuesta);


                    $('#fila<?php echo $_POST['id'];?>').find("td").eq(0).html(usuario);
                    $('#fila<?php echo $_POST['id'];?>').find("td").eq(1).html(activo);
                    
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