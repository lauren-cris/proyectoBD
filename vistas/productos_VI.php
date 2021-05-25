<?php
class productos_VI
{
    function __construct(){}

    function crud()
    {
        ?>
        <div class="card">
            <div class="card-header bg-light">
                Agregar productos
            </div>
            <div class="card-body">
                <form id="formulario_agregar">
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre">
                </div>

                <div class="form-group">
                    <label for="orden">Descripcion</label>
                    <input type="text" class="form-control" id="descripcion" name="descripcion">
                </div>

                <div class="form-group">
                    <label for="orden">Precio</label>
                    <input type="number" class="form-control" id="precio" name="precio">
                </div>

                <div class="form-group">
                    <label for="id_categorias">Categorias</label>
                    <select class="form-control" id="id_categorias" name="id_categorias">
                    <option value=""></option>
                    <?php
                    foreach($arreglo as $objeto)
                    {
                        ?>
                        <option value="<?php echo $objeto->id_categorias;?>"><?php echo $objeto->nombre;?></option>
                        <?php
                    }
                    ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="id_proveedores">Proveedores</label>
                    <select class="form-control" id="id_proveedores" name="id_proveedores">
                    <option value=""></option>
                    <?php
                    foreach($arreglo as $objeto)
                    {
                        ?>
                        <option value="<?php echo $objeto->id_proveedores;?>"><?php echo $objeto->nombre;?></option>
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
                    <th>Categoria</th>
                    <th>Nombre</th>
                    <th>Descripcion</th>
                    <th>Precio</th>
                    <th>Proveedor</th>
                    <th>Acci&oacute;n</th>
                    </tr>
                </thead>
                <tbody id="listar_productos">
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

            
            

            $.post('productos_CO/guardar',cadena,function(id_productos)
            {
                var buscar=/ERROR/;
			    var resultado=buscar.test(id_productos);

                if(resultado)
                {
                    toastr.error(id_productos);
                }
                else
                {
                    toastr.success('Registro Agregado');


                    $("#formulario_agregar")[0].reset();

                    let boton='<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#ventana_modal" onclick="verActualizar('+id_productos+')">Actualizar</button>';
                        boton+=' <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#ventana_modal" onclick="confirmarEliminar('+id_productoss+')">Eliminar</button>';

                    let fila='<tr id="fila'+id_productos+'">';
                    fila+='<td>'+categoria+'</td>';
                    fila+='<td>'+nombre+'</td>';
                    fila+='<td>'+descripcion+'</td>';
                    fila+='<td>'+precio+'</td>';
                    fila+='<td>'+proveedor+'</td>';
                    fila+='</tr>';

                    $('#listar_productos').prepend(fila);
                }
            });
        }

        function verActualizar(id)
        {
            $.post('productos_VI/verActualizar',{id:id},function(respuesta)
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
            $.post('productos_CO/eliminar',{id:id},function(respuesta)
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
        require_once "modelos/productos_MO.php";
        $conexion=new conexion();
        $productos_MO=new productos_MO($conexion);
  
        $arreglo=$productos_MO->listar();

        foreach($arreglo as $objeto)
        {
            ?>
            <tr id="fila<?php echo $objeto->id_productos;?>">
            <td><?php echo $objeto->categoria;?></td>
            <td><?php echo $objeto->nombre;?></td>
            <td><?php echo $objeto->precio;?></td>
            <td><?php echo $objeto->descripcion;?></td>
            <td><?php echo $objeto->proveedor;?></td>
            <td> 
            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#ventana_modal" onclick="verActualizar('<?php echo $objeto->id_productos;?>')">Actualizar</button>
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#ventana_modal" onclick="confirmarEliminar('<?php echo $objeto->id_productos;?>')">Eliminar</button>
            </td>
            </tr>
            <?php
        }
    }

    function verActualizar()
    {
        require_once "modelos/productos_MO.php";
        $conexion=new conexion();
        $productos_MO=new productos_MO($conexion);
  
        $arreglo=$productos_MO->seleccionar('id_productos',$_POST['id']);
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