<?php $__env->startSection('content'); ?>
    <style>
        tr:hover {
            background-color: #dff0d8;
        }
    </style>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <button  type="button" class="btn btn-success" data-toggle="modal" data-target="#modalCrearCliente">Nuevo Cliente</button>
            </div>
            <!-- inicio modal crear cliente-->
            <form id="formCliente">
                <input type="hidden" id="_token" name="_token" value="<?php echo e(csrf_token()); ?>" />
                <input type="hidden" id="Empresa_id" name="Empresa_id" />
                <div id="modalCrearCliente" name="modalCrearCliente"   class="modal fade">
                    <div class="modal-dialog modal-lg" >
                        <!-- Modal content-->
                        <div class="modal-content" >
                            <div class="modal-header">
                                <h3 class="modal-title">Crear Cliente </h3>
                            </div>
                            <div class="modal-body" >
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Nombre</label>
                                        <input id="Nombre" name="Nombre" type="text" class="form-control">
                                        <span class="invalid-feedback" role="alert" id="errorNombre"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Apellidos</label>
                                        <input id="Apellidos" name="Apellidos" type="text" class="form-control">
                                        <span class="invalid-feedback" role="alert" id="errorApellidos"></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>Identificación</label>
                                        <input id="Identificacion" name="Identificacion" type="text" class="form-control">
                                        <span class="invalid-feedback" role="alert" id="errorIdentificacion"></span>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Teléfono</label>
                                        <input id="Telefono" name="Telefono" type="text" class="form-control">
                                        <span class="invalid-feedback" role="alert" id="errorTelefono"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Correo Electrónico</label>
                                        <input id="CorreoElectronico" name="CorreoElectronico" type="text" class="form-control">
                                        <span class="invalid-feedback" role="alert" id="errorCorreoElectronico"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button id="cerrarModal" type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button onclick="GuardarCliente()" type="button" class="btn btn-success" data-dismiss="modal">Guardar</button>
                            </div>

                        </div>
                    </div>
                </div>
            </form>
            <!-- fin modal crear cliente-->
        </div>
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="panel panel-success">
                    <div class="panel-heading"><h3>Pedidos</h3></div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-3">
                                <button onclick="validarEdicionDePedidoBtnCrear()" type="button" class="btn btn-success">Nuevo Pedido</button>
                            </div>
                        </div>
                        <div class="row" id="tablaPedidosCompleta">
                            <table style="border-collapse: collapse !important; border-spacing: 0 !important; width: 100% !important;" class="table table-bordered" >
                                <thead>
                                <tr>
                                    <th scope="col">Id</th>
                                    <th scope="col">Hora Pedido</th>
                                    <th scope="col">Estado</th>
                                    <th scope="col">Cliente</th>
                                    <th scope="col">Total</th>
                                </tr>
                                </thead>
                                <tbody id="tablaPedidos">
                                <?php $__currentLoopData = $listPedidos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pedido): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr onclick="validarEdicionDePedido(this,<?php echo e($pedido->id); ?>)" id="trPedido<?php echo e($pedido->id); ?>">
                                        <td><?php echo e($pedido->id); ?></td>
                                        <td><?php echo e($pedido->created_at); ?></td>
                                        <td id="tdEstadoPedido<?php echo e($pedido->id); ?>" name="tdEstadoPedido<?php echo e($pedido->id); ?>"><?php echo e($pedido->nombreEstado); ?></td>
                                        <td><?php echo e($pedido->Nombre); ?> <?php echo e($pedido->Apellidos); ?></td>
                                        <td id="tdTotalPedido<?php echo e($pedido->id); ?>">$<?php echo e($pedido->VentaTotal); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                            <?php echo $listPedidos->links(); ?>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5" id="panelPedido">
                <?php echo $__env->yieldContent('contentFormPedido'); ?>
            </div>
        </div>
    </div>
    <script type="text/javascript">

        $(document).ready(function() {
            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();

                $('#tablaPedidosCompleta a').css('color', '#dfecf6');
                //  $('#tablaPedidosCompleta').append('<img style="position: absolute; left: 0; top: 0; z-index: 100000;" src="../images/loader.gif" />');

                var url = $(this).attr('href');
                getArticles(url);
                window.history.pushState("", "", url);
            });

            function getArticles(url) {
                $.ajax({
                    url : url
                }).done(function (data) {
                    $('#tablaPedidosCompleta').html(data);
                }).fail(function () {
                    alert('Articles could not be loaded.');
                });
            }
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.principal', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>