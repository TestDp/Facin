<?php $__env->startSection('content'); ?>

			<div class="main-page login-page ">
				<div class="widget-shadow">
					<div class="login-top">
						<h4><img class="media-object" src="<?php echo e(asset('images/Logo.png')); ?>"></img> </h4>
					</div>
					<div class="login-body">
						<form method="POST" action="<?php echo e(route('login')); ?>" aria-label="<?php echo e(__('Login')); ?>">
                        <?php echo csrf_field(); ?>

                        <div class="form-group row">
                            <label for="login”" class="col-sm-4 col-form-label text-md-right"><?php echo e(__('Usuario | Email')); ?></label>

                            <div class="col-md-6">
                                <input id="login”" type="login" class="form-control<?php echo e($errors->has('login') ? ' is-invalid' : ''); ?>" name="login" value="<?php echo e(old('login')); ?>" required autofocus>

                                <?php if($errors->has('login')): ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($errors->first('login')); ?></strong>
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
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" <?php echo e(old('remember') ? 'checked' : ''); ?>>

                                    <label class="checkbox" for="remember">
                                        <?php echo e(__('Recordarme')); ?>

                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    <?php echo e(__('Ingresar')); ?>

                                </button>

                                <a class="btn btn-link" href="<?php echo e(route('password.request')); ?>">
                                    <?php echo e(__('Olvidaste tu contraseña?')); ?>

                                </a>
                            </div>
                        </div>
                    </form>
					</div>
				</div>
				
			</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>