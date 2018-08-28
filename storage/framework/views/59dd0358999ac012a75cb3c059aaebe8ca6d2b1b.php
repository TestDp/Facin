<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="widget-shadow">
                <div class="login-top"><img class="media-object" src="<?php echo e(asset('images/Logo.png')); ?>"></img></div>

                <div class="card-body">
                    <form method="POST" action="<?php echo e(route('register')); ?>" aria-label="<?php echo e(__('Register')); ?>">
                        <?php echo csrf_field(); ?>

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right"><?php echo e(__('Nombre')); ?></label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control<?php echo e($errors->has('name') ? ' is-invalid' : ''); ?>" name="name" value="<?php echo e(old('name')); ?>" required autofocus>

                                <?php if($errors->has('name')): ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($errors->first('name')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right"><?php echo e(__('Apellido')); ?></label>

                            <div class="col-md-6">
                                <input id="last_name" type="text" class="form-control<?php echo e($errors->has('last_name') ? ' is-invalid' : ''); ?>" name="last_name" value="<?php echo e(old('last_name')); ?>" required autofocus>

                                <?php if($errors->has('last_name')): ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($errors->first('last_name')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right"><?php echo e(__('Usuario')); ?></label>

                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control<?php echo e($errors->has('username') ? ' is-invalid' : ''); ?>" name="username" value="<?php echo e(old('username')); ?>" required autofocus>

                                <?php if($errors->has('username')): ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($errors->first('username')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right"><?php echo e(__('Correo Electrónico')); ?></label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control<?php echo e($errors->has('email') ? ' is-invalid' : ''); ?>" name="email" value="<?php echo e(old('email')); ?>" required>

                                <?php if($errors->has('email')): ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($errors->first('email')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right"><?php echo e(__('Contraseña')); ?></label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control<?php echo e($errors->has('password') ? ' is-invalid' : ''); ?>" name="password" required>

                                <?php if($errors->has('password')): ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($errors->first('password')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right"><?php echo e(__('Confirmar Contraseña')); ?></label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="RazonSocial" class="col-md-4 col-form-label text-md-right"><?php echo e(__('Razón Social')); ?></label>

                            <div class="col-md-6">
                                <input id="RazonSocial" type="text" class="form-control<?php echo e($errors->has('RazonSocial') ? ' is-invalid' : ''); ?>" name="RazonSocial" value="<?php echo e(old('RazonSocial')); ?>" required autofocus>

                                <?php if($errors->has('RazonSocial')): ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($errors->first('RazonSocial')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="NitEmpresa" class="col-md-4 col-form-label text-md-right"><?php echo e(__('Nit Empresa')); ?></label>

                            <div class="col-md-6">
                                <input id="NitEmpresa" type="text" class="form-control<?php echo e($errors->has('NitEmpresa') ? ' is-invalid' : ''); ?>" name="NitEmpresa" value="<?php echo e(old('NitEmpresa')); ?>" required autofocus>

                                <?php if($errors->has('NitEmpresa')): ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($errors->first('NitEmpresa')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="IdentificacionRepresentante" class="col-md-4 col-form-label text-md-right"><?php echo e(__('Identificación Representante')); ?></label>

                            <div class="col-md-6">
                                <input id="IdentificacionRepresentante" type="text" class="form-control<?php echo e($errors->has('IdentificacionRepresentante') ? ' is-invalid' : ''); ?>" name="IdentificacionRepresentante" value="<?php echo e(old('IdentificacionRepresentante')); ?>" required autofocus>

                                <?php if($errors->has('IdentificacionRepresentante')): ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($errors->first('IdentificacionRepresentante')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Direccion" class="col-md-4 col-form-label text-md-right"><?php echo e(__('Dirección')); ?></label>

                            <div class="col-md-6">
                                <input id="Direccion" type="text" class="form-control<?php echo e($errors->has('Direccion') ? ' is-invalid' : ''); ?>" name="Direccion" value="<?php echo e(old('Direccion')); ?>" required autofocus>

                                <?php if($errors->has('Direccion')): ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($errors->first('Direccion')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Telefono" class="col-md-4 col-form-label text-md-right"><?php echo e(__('Teléfono')); ?></label>

                            <div class="col-md-6">
                                <input id="Telefono" type="text" class="form-control<?php echo e($errors->has('Telefono') ? ' is-invalid' : ''); ?>" name="Telefono" value="<?php echo e(old('Telefono')); ?>" required autofocus>

                                <?php if($errors->has('Telefono')): ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($errors->first('Telefono')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="CorreoElectronico" class="col-md-4 col-form-label text-md-right"><?php echo e(__('Correo Corporativo')); ?></label>

                            <div class="col-md-6">
                                <input id="CorreoElectronico" type="text" class="form-control<?php echo e($errors->has('CorreoElectronico') ? ' is-invalid' : ''); ?>" name="CorreoElectronico" value="<?php echo e(old('CorreoElectronico')); ?>" required autofocus>

                                <?php if($errors->has('CorreoElectronico')): ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($errors->first('CorreoElectronico')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="SitioWeb" class="col-md-4 col-form-label text-md-right"><?php echo e(__('Sitio Web')); ?></label>

                            <div class="col-md-6">
                                <input id="SitioWeb" type="text" class="form-control<?php echo e($errors->has('SitioWeb') ? ' is-invalid' : ''); ?>" name="SitioWeb" value="<?php echo e(old('SitioWeb')); ?>" required autofocus>

                                <?php if($errors->has('SitioWeb')): ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($errors->first('SitioWeb')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    <?php echo e(__('Registrar')); ?>

                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>