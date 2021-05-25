<?php
class proveedores_VI
{
    function __construct(){}

    function crud()
    {
        ?>
        <div class="card">
            <div class="card-header bg-light">
                Agregar proveedores
            </div>
            <div class="card-body">
                <form id="formulario_agregar">
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" class="form-control" id="nombre_proveedor" name="nombre_proveedor">
                </div>

                <div class="form-group">
                    <label for="direccion">Direccion</label>
                    <input type="text" class="form-control" id="direccion_proveedor" name="direccion_proveedor">
                </div>
                <div class="form-group">
                    <label for="celular">Celular</label>
                    <input type="text" class="form-control" id="celular_proveedor" name="celular_proveedor">
                </div>
                <div class="form-group">
                    <label for="correo">Correo</label>
                    <input type="text" class="form-control" id="correo_proveedor" name="correo_proveedor">
                </div>
                <div class="form-group">
                    <label for="red_social_proveedor">Red social</label>
                    <input type="text" class="form-control" id="red_social_proveedor" name="red_social_proveedor">
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
                    <th>Nombre</th>
                    <th>Direccion</th>
                    <th>Celular</th>
                    <th>Correo</th>
                    <th>Red social</th>
                    <th>Acci&oacute;n</th>
                    </tr>
                </thead>
                <tbody id="listar_proveedores">
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

            var nombre_proveedor=$('#nombre').val();
            var direccion_proveedor=$('#direccion').val();

            $.post('proveedores_CO/guardar',cadena,function(id_proveedor)
            {
                var buscar=/ERROR/;
			    var resultado=buscar.test(id_proveedor);

                if(resultado)
                {
                    toastr.error(id_proveedor);
                }
                else
                {
                    toastr.success('Registro Agregado');


                    $("#formulario_agregar")[0].reset();

                    let boton='<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#ventana_modal" onclick="verActualizar('+id_proveedor+')">Actualizar</button>';
                        boton+=' <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#ventana_modal" onclick="confirmarEliminar('+id_proveedor+')">Eliminar</button>';

                    let fila='<tr id="fila'+id_proveedor+'">';
                    fila+='<td>'+nombre_proveedor+'</td>';
                    fila+='<td>'+direccion_proveedor+'</td>';
                    fila+='<td>'+celular_proveedor+'</td>';
                    fila+='<td>'+correo_proveedor+'</td>';
                    fila+='<td>'+red_social_proveedor+'</td>';
                    fila+='<td>'+boton+'</td>';
                    fila+='</tr>';

                    $('#listar_proveedores').prepend(fila);
                }
            });
        }

        function verActualizar(id)
        {
            $.post('proveedores_VI/verActualizar',{id:id},function(respuesta)
            {
                $('#titulo_modal').html('Actualizar Proveedores');
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
            $.post('proveedores_CO/eliminar',{id:id},function(respuesta)
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
        require_once "modelos/proveedores_MO.php";
        $conexion=new conexion();
        $proveedores_MO=new proveedores_MO($conexion);
  
        $arreglo=$proveedores_MO->listar();

        foreach($arreglo as $objeto)
        {
            ?>
            <tr id="fila<?php echo $objeto->id_proveedor;?>">
            <td><?php echo $objeto->nombre_proveedor;?></td>
            <td><?php echo $objeto->direccion_proveedor;?></td>
            <td><?php echo $objeto->celular_proveedor;?></td>
            <td><?php echo $objeto->correo_proveedor;?></td>
            <td><?php echo $objeto->red_social_proveedor;?></td>
            <td> 
            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#ventana_modal" onclick="verActualizar('<?php echo $objeto->id_proveedor;?>')">Actualizar</button>
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#ventana_modal" onclick="confirmarEliminar('<?php echo $objeto->id_proveedor;?>')">Eliminar</button>
            </td>
            </tr>
            <?php
        }
    }

    function verActualizar()
    {
        require_once "modelos/proveedores_MO.php";
        $conexion=new conexion();
        $proveedores_MO=new proveedores_MO($conexion);
  
        $arreglo=$proveedores_MO->seleccionar('id_proveedor',$_POST['id']);
        $nombre_proveedor=$arreglo[0]->nombre_proveedor;
        $direccion_proveedor=$arreglo[0]->direccion_proveedor;
        $celular_proveedor=$arreglo[0]->celular_proveedor;
        $correo_proveedor=$arreglo[0]->correo_proveedor;
        $red_social_proveedor=$arreglo[0]->red_social_proveedor;
        ?>
        <div class="card">
            <div class="card-body">
                <form id="formulario_actualizar">
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" class="form-control" id="nombre_proveedor" name="nombre_proveedor" value="<?php echo $nombre_proveedor;?>">
                </div>


                <div class="form-group">
                    <label for="direccion">Direccion</label>
                    <input type="text" class="form-control" id="direccion_proveedor" name="direccion_proveedor" value="<?php echo $direccion_proveedor;?>">
                </div>

                <div class="form-group">
                    <label for="celular">Celular</label>
                    <input type="text" class="form-control" id="celular_proveedor" name="celular_proveedor" value="<?php echo $celular_proveedor;?>">
                </div>
                <div class="form-group">
                    <label for="correo">Correo</label>
                    <input type="text" class="form-control" id="correo_proveedor" name="correo_proveedor" value="<?php echo $correo_proveedor;?>">
                </div>
                <div class="form-group">
                    <label for="red">Red social</label>
                    <input type="text" class="form-control" id="orden" name="red_social_proveedor" value="<?php echo $red_social_proveedor;?>">
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

            var nombre_proveedor=$('#formulario_actualizar #nombre_proveedor').val();
            var direccion_proveedor=$('#formulario_actualizar #direccion_proveedor').val();
            var celular_proveedor=$('#formulario_actualizar #celular_proveedor').val();
            var correo_proveedor=$('#formulario_actualizar #correo_proveedor').val();
            var red_social_proveedor=$('#formulario_actualizar #red_social_proveedor').val();

            $.post('proveedores_CO/actualizar',cadena,function(respuesta)
            {
                var buscar=/EXITO/;
			    var resultado=buscar.test(respuesta);

                if(resultado)
                {
                    toastr.success(respuesta);

                    

                    $('#fila<?php echo $_POST['id'];?>').find("td").eq(0).html(nombre_proveedor);
                    $('#fila<?php echo $_POST['id'];?>').find("td").eq(0).html(direccion_proveedor);
                    $('#fila<?php echo $_POST['id'];?>').find("td").eq(0).html(celular_proveedor);
                    $('#fila<?php echo $_POST['id'];?>').find("td").eq(0).html(correo_proveedor);
                    $('#fila<?php echo $_POST['id'];?>').find("td").eq(0).html(red_social_proveedor);
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