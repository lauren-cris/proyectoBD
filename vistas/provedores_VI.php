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
                    <input type="text" class="form-control" id="nombre" name="nombre">
                </div>

                <div class="form-group">
                    <label for="orden">Orden</label>
                    <input type="number" class="form-control" id="orden" name="orden">
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
                    <th>Activo</th>
                    <th>Orden</th>
                    <th>Acci&oacute;n</th>
                    </tr>
                </thead>
                <tbody id="listar_tipos_documentos">
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

            var nombre=$('#nombre').val();
            var orden=$('#orden').val();

            $.post('proveedores_CO/guardar',cadena,function(id_tipos_documentos)
            {
                var buscar=/ERROR/;
			    var resultado=buscar.test(id_tipos_documentos);

                if(resultado)
                {
                    toastr.error(id_tipos_documentos);
                }
                else
                {
                    toastr.success('Registro Agregado');


                    $("#formulario_agregar")[0].reset();

                    let boton='<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#ventana_modal" onclick="verActualizar('+id_proveedores+')">Actualizar</button>';
                        boton+=' <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#ventana_modal" onclick="confirmarEliminar('+id_proveedores+')">Eliminar</button>';

                    let fila='<tr id="fila'+id_proveedores+'">';
                    fila+='<td>'+nombre+'</td>';
                    fila+='<td>SI</td>';
                    fila+='<td>'+orden+'</td>';
                    fila+='<td>'+boton+'</td>';
                    fila+='</tr>';

                    $('#listar_tipos_documentos').prepend(fila);
                }
            });
        }

        function verActualizar(id)
        {
            $.post('proveedores_VI/verActualizar',{id:id},function(respuesta)
            {
                $('#titulo_modal').html('Actualizar Tipos de Documento');
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
            <tr id="fila<?php echo $objeto->id_proveedores;?>">
            <td><?php echo $objeto->nombre;?></td>
            <td><?php echo $objeto->activo;?></td>
            <td><?php echo $objeto->orden;?></td>
            <td> 
            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#ventana_modal" onclick="verActualizar('<?php echo $objeto->id_proveedores;?>')">Actualizar</button>
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#ventana_modal" onclick="confirmarEliminar('<?php echo $objeto->id_proveedores;?>')">Eliminar</button>
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
  
        $arreglo=$proveedores_MO->seleccionar('id_proveedores',$_POST['id']);
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

            $.post('proveedores_CO/actualizar',cadena,function(respuesta)
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