<?php $__env->startSection('title', 'Nueva Persona'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/cesodo-theme.css')); ?>">
<style>
    .fecha-nacimiento-enhanced {
        transition: all 0.3s ease;
    }

    .fecha-nacimiento-enhanced:focus {
        border-color: var(--cesodo-red);
        box-shadow: 0 0 0 0.2rem rgba(220, 38, 38, 0.25);
    }

    .edad-feedback {
        background: linear-gradient(90deg, var(--cesodo-red-lighter), transparent);
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        border-left: 3px solid var(--cesodo-red);
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">
                    <i class="fas fa-user-plus text-cesodo-red me-2"></i>
                    Nueva Persona
                </h2>
                <a href="<?php echo e(route('personas.index')); ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i>
                    Volver
                </a>
            </div>

            <form action="<?php echo e(route('personas.store')); ?>" method="POST" id="createPersonaForm">
                <?php echo csrf_field(); ?>

                <div class="row">
                    <!-- Información Personal -->
                    <div class="col-lg-6 mb-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-header bg-cesodo-red text-white">
                                <h5 class="mb-0">
                                    <i class="fas fa-user me-2"></i>
                                    Información Personal
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="nombres" class="form-label">Nombres <span class="text-danger">*</span></label>
                                        <input type="text"
                                               class="form-control <?php $__errorArgs = ['nombres'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               id="nombres"
                                               name="nombres"
                                               value="<?php echo e(old('nombres')); ?>"
                                               required>
                                        <?php $__errorArgs = ['nombres'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="apellidos" class="form-label">Apellidos <span class="text-danger">*</span></label>
                                        <input type="text"
                                               class="form-control <?php $__errorArgs = ['apellidos'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               id="apellidos"
                                               name="apellidos"
                                               value="<?php echo e(old('apellidos')); ?>"
                                               required>
                                        <?php $__errorArgs = ['apellidos'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="fecha_nacimiento" class="form-label">
                                            <i class="fas fa-calendar-alt text-cesodo-red me-1"></i>
                                            Fecha de Nacimiento
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-cesodo-red text-white">
                                                <i class="fas fa-birthday-cake"></i>
                                            </span>
                                            <input type="date"
                                                   class="form-control fecha-nacimiento-enhanced <?php $__errorArgs = ['fecha_nacimiento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                   id="fecha_nacimiento"
                                                   name="fecha_nacimiento"
                                                   value="<?php echo e(old('fecha_nacimiento')); ?>"
                                                   max="<?php echo e(date('Y-m-d', strtotime('-18 years'))); ?>"
                                                   min="<?php echo e(date('Y-m-d', strtotime('-120 years'))); ?>"
                                                   onchange="calcularEdad()"
                                                   title="Selecciona la fecha de nacimiento (debe ser mayor de 18 años)">
                                        </div>
                                        <div id="edad_display" class="form-text text-cesodo-black mt-1" style="display: none;">
                                            <i class="fas fa-info-circle me-1"></i>
                                            <span id="edad_texto"></span>
                                        </div>
                                        <?php $__errorArgs = ['fecha_nacimiento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="sexo" class="form-label">Sexo</label>
                                        <select class="form-select <?php $__errorArgs = ['sexo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                id="sexo"
                                                name="sexo">
                                            <option value="">Seleccionar</option>
                                            <option value="M" <?php echo e(old('sexo') == 'M' ? 'selected' : ''); ?>>Masculino</option>
                                            <option value="F" <?php echo e(old('sexo') == 'F' ? 'selected' : ''); ?>>Femenino</option>
                                            <option value="O" <?php echo e(old('sexo') == 'O' ? 'selected' : ''); ?>>Otro</option>
                                        </select>
                                        <?php $__errorArgs = ['sexo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="pais" class="form-label">
                                            <i class="fas fa-globe text-cesodo-red me-1"></i>
                                            País
                                        </label>
                                        <select class="form-select <?php $__errorArgs = ['pais'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                id="pais"
                                                name="pais">
                                            <option value="">Seleccionar país</option>
                                            <option value="Afganistán" <?php echo e(old('pais') == 'Afganistán' ? 'selected' : ''); ?>>Afganistán</option>
                                            <option value="Albania" <?php echo e(old('pais') == 'Albania' ? 'selected' : ''); ?>>Albania</option>
                                            <option value="Alemania" <?php echo e(old('pais') == 'Alemania' ? 'selected' : ''); ?>>Alemania</option>
                                            <option value="Andorra" <?php echo e(old('pais') == 'Andorra' ? 'selected' : ''); ?>>Andorra</option>
                                            <option value="Angola" <?php echo e(old('pais') == 'Angola' ? 'selected' : ''); ?>>Angola</option>
                                            <option value="Antigua y Barbuda" <?php echo e(old('pais') == 'Antigua y Barbuda' ? 'selected' : ''); ?>>Antigua y Barbuda</option>
                                            <option value="Arabia Saudita" <?php echo e(old('pais') == 'Arabia Saudita' ? 'selected' : ''); ?>>Arabia Saudita</option>
                                            <option value="Argelia" <?php echo e(old('pais') == 'Argelia' ? 'selected' : ''); ?>>Argelia</option>
                                            <option value="Argentina" <?php echo e(old('pais') == 'Argentina' ? 'selected' : ''); ?>>Argentina</option>
                                            <option value="Armenia" <?php echo e(old('pais') == 'Armenia' ? 'selected' : ''); ?>>Armenia</option>
                                            <option value="Australia" <?php echo e(old('pais') == 'Australia' ? 'selected' : ''); ?>>Australia</option>
                                            <option value="Austria" <?php echo e(old('pais') == 'Austria' ? 'selected' : ''); ?>>Austria</option>
                                            <option value="Azerbaiyán" <?php echo e(old('pais') == 'Azerbaiyán' ? 'selected' : ''); ?>>Azerbaiyán</option>
                                            <option value="Bahamas" <?php echo e(old('pais') == 'Bahamas' ? 'selected' : ''); ?>>Bahamas</option>
                                            <option value="Bangladés" <?php echo e(old('pais') == 'Bangladés' ? 'selected' : ''); ?>>Bangladés</option>
                                            <option value="Barbados" <?php echo e(old('pais') == 'Barbados' ? 'selected' : ''); ?>>Barbados</option>
                                            <option value="Baréin" <?php echo e(old('pais') == 'Baréin' ? 'selected' : ''); ?>>Baréin</option>
                                            <option value="Bélgica" <?php echo e(old('pais') == 'Bélgica' ? 'selected' : ''); ?>>Bélgica</option>
                                            <option value="Belice" <?php echo e(old('pais') == 'Belice' ? 'selected' : ''); ?>>Belice</option>
                                            <option value="Benín" <?php echo e(old('pais') == 'Benín' ? 'selected' : ''); ?>>Benín</option>
                                            <option value="Bielorrusia" <?php echo e(old('pais') == 'Bielorrusia' ? 'selected' : ''); ?>>Bielorrusia</option>
                                            <option value="Birmania" <?php echo e(old('pais') == 'Birmania' ? 'selected' : ''); ?>>Birmania</option>
                                            <option value="Bolivia" <?php echo e(old('pais') == 'Bolivia' ? 'selected' : ''); ?>>Bolivia</option>
                                            <option value="Bosnia y Herzegovina" <?php echo e(old('pais') == 'Bosnia y Herzegovina' ? 'selected' : ''); ?>>Bosnia y Herzegovina</option>
                                            <option value="Botsuana" <?php echo e(old('pais') == 'Botsuana' ? 'selected' : ''); ?>>Botsuana</option>
                                            <option value="Brasil" <?php echo e(old('pais') == 'Brasil' ? 'selected' : ''); ?>>Brasil</option>
                                            <option value="Brunéi" <?php echo e(old('pais') == 'Brunéi' ? 'selected' : ''); ?>>Brunéi</option>
                                            <option value="Bulgaria" <?php echo e(old('pais') == 'Bulgaria' ? 'selected' : ''); ?>>Bulgaria</option>
                                            <option value="Burkina Faso" <?php echo e(old('pais') == 'Burkina Faso' ? 'selected' : ''); ?>>Burkina Faso</option>
                                            <option value="Burundi" <?php echo e(old('pais') == 'Burundi' ? 'selected' : ''); ?>>Burundi</option>
                                            <option value="Bután" <?php echo e(old('pais') == 'Bután' ? 'selected' : ''); ?>>Bután</option>
                                            <option value="Cabo Verde" <?php echo e(old('pais') == 'Cabo Verde' ? 'selected' : ''); ?>>Cabo Verde</option>
                                            <option value="Camboya" <?php echo e(old('pais') == 'Camboya' ? 'selected' : ''); ?>>Camboya</option>
                                            <option value="Camerún" <?php echo e(old('pais') == 'Camerún' ? 'selected' : ''); ?>>Camerún</option>
                                            <option value="Canadá" <?php echo e(old('pais') == 'Canadá' ? 'selected' : ''); ?>>Canadá</option>
                                            <option value="Catar" <?php echo e(old('pais') == 'Catar' ? 'selected' : ''); ?>>Catar</option>
                                            <option value="Chad" <?php echo e(old('pais') == 'Chad' ? 'selected' : ''); ?>>Chad</option>
                                            <option value="Chile" <?php echo e(old('pais') == 'Chile' ? 'selected' : ''); ?>>Chile</option>
                                            <option value="China" <?php echo e(old('pais') == 'China' ? 'selected' : ''); ?>>China</option>
                                            <option value="Chipre" <?php echo e(old('pais') == 'Chipre' ? 'selected' : ''); ?>>Chipre</option>
                                            <option value="Colombia" <?php echo e(old('pais') == 'Colombia' ? 'selected' : ''); ?>>Colombia</option>
                                            <option value="Comoras" <?php echo e(old('pais') == 'Comoras' ? 'selected' : ''); ?>>Comoras</option>
                                            <option value="Corea del Norte" <?php echo e(old('pais') == 'Corea del Norte' ? 'selected' : ''); ?>>Corea del Norte</option>
                                            <option value="Corea del Sur" <?php echo e(old('pais') == 'Corea del Sur' ? 'selected' : ''); ?>>Corea del Sur</option>
                                            <option value="Costa de Marfil" <?php echo e(old('pais') == 'Costa de Marfil' ? 'selected' : ''); ?>>Costa de Marfil</option>
                                            <option value="Costa Rica" <?php echo e(old('pais') == 'Costa Rica' ? 'selected' : ''); ?>>Costa Rica</option>
                                            <option value="Croacia" <?php echo e(old('pais') == 'Croacia' ? 'selected' : ''); ?>>Croacia</option>
                                            <option value="Cuba" <?php echo e(old('pais') == 'Cuba' ? 'selected' : ''); ?>>Cuba</option>
                                            <option value="Dinamarca" <?php echo e(old('pais') == 'Dinamarca' ? 'selected' : ''); ?>>Dinamarca</option>
                                            <option value="Dominica" <?php echo e(old('pais') == 'Dominica' ? 'selected' : ''); ?>>Dominica</option>
                                            <option value="Ecuador" <?php echo e(old('pais') == 'Ecuador' ? 'selected' : ''); ?>>Ecuador</option>
                                            <option value="Egipto" <?php echo e(old('pais') == 'Egipto' ? 'selected' : ''); ?>>Egipto</option>
                                            <option value="El Salvador" <?php echo e(old('pais') == 'El Salvador' ? 'selected' : ''); ?>>El Salvador</option>
                                            <option value="Emiratos Árabes Unidos" <?php echo e(old('pais') == 'Emiratos Árabes Unidos' ? 'selected' : ''); ?>>Emiratos Árabes Unidos</option>
                                            <option value="Eritrea" <?php echo e(old('pais') == 'Eritrea' ? 'selected' : ''); ?>>Eritrea</option>
                                            <option value="Eslovaquia" <?php echo e(old('pais') == 'Eslovaquia' ? 'selected' : ''); ?>>Eslovaquia</option>
                                            <option value="Eslovenia" <?php echo e(old('pais') == 'Eslovenia' ? 'selected' : ''); ?>>Eslovenia</option>
                                            <option value="España" <?php echo e(old('pais') == 'España' ? 'selected' : ''); ?>>España</option>
                                            <option value="Estados Unidos" <?php echo e(old('pais') == 'Estados Unidos' ? 'selected' : ''); ?>>Estados Unidos</option>
                                            <option value="Estonia" <?php echo e(old('pais') == 'Estonia' ? 'selected' : ''); ?>>Estonia</option>
                                            <option value="Etiopía" <?php echo e(old('pais') == 'Etiopía' ? 'selected' : ''); ?>>Etiopía</option>
                                            <option value="Filipinas" <?php echo e(old('pais') == 'Filipinas' ? 'selected' : ''); ?>>Filipinas</option>
                                            <option value="Finlandia" <?php echo e(old('pais') == 'Finlandia' ? 'selected' : ''); ?>>Finlandia</option>
                                            <option value="Fiyi" <?php echo e(old('pais') == 'Fiyi' ? 'selected' : ''); ?>>Fiyi</option>
                                            <option value="Francia" <?php echo e(old('pais') == 'Francia' ? 'selected' : ''); ?>>Francia</option>
                                            <option value="Gabón" <?php echo e(old('pais') == 'Gabón' ? 'selected' : ''); ?>>Gabón</option>
                                            <option value="Gambia" <?php echo e(old('pais') == 'Gambia' ? 'selected' : ''); ?>>Gambia</option>
                                            <option value="Georgia" <?php echo e(old('pais') == 'Georgia' ? 'selected' : ''); ?>>Georgia</option>
                                            <option value="Ghana" <?php echo e(old('pais') == 'Ghana' ? 'selected' : ''); ?>>Ghana</option>
                                            <option value="Granada" <?php echo e(old('pais') == 'Granada' ? 'selected' : ''); ?>>Granada</option>
                                            <option value="Grecia" <?php echo e(old('pais') == 'Grecia' ? 'selected' : ''); ?>>Grecia</option>
                                            <option value="Guatemala" <?php echo e(old('pais') == 'Guatemala' ? 'selected' : ''); ?>>Guatemala</option>
                                            <option value="Guinea" <?php echo e(old('pais') == 'Guinea' ? 'selected' : ''); ?>>Guinea</option>
                                            <option value="Guinea Ecuatorial" <?php echo e(old('pais') == 'Guinea Ecuatorial' ? 'selected' : ''); ?>>Guinea Ecuatorial</option>
                                            <option value="Guinea-Bisáu" <?php echo e(old('pais') == 'Guinea-Bisáu' ? 'selected' : ''); ?>>Guinea-Bisáu</option>
                                            <option value="Guyana" <?php echo e(old('pais') == 'Guyana' ? 'selected' : ''); ?>>Guyana</option>
                                            <option value="Haití" <?php echo e(old('pais') == 'Haití' ? 'selected' : ''); ?>>Haití</option>
                                            <option value="Honduras" <?php echo e(old('pais') == 'Honduras' ? 'selected' : ''); ?>>Honduras</option>
                                            <option value="Hungría" <?php echo e(old('pais') == 'Hungría' ? 'selected' : ''); ?>>Hungría</option>
                                            <option value="India" <?php echo e(old('pais') == 'India' ? 'selected' : ''); ?>>India</option>
                                            <option value="Indonesia" <?php echo e(old('pais') == 'Indonesia' ? 'selected' : ''); ?>>Indonesia</option>
                                            <option value="Irak" <?php echo e(old('pais') == 'Irak' ? 'selected' : ''); ?>>Irak</option>
                                            <option value="Irán" <?php echo e(old('pais') == 'Irán' ? 'selected' : ''); ?>>Irán</option>
                                            <option value="Irlanda" <?php echo e(old('pais') == 'Irlanda' ? 'selected' : ''); ?>>Irlanda</option>
                                            <option value="Islandia" <?php echo e(old('pais') == 'Islandia' ? 'selected' : ''); ?>>Islandia</option>
                                            <option value="Islas Marshall" <?php echo e(old('pais') == 'Islas Marshall' ? 'selected' : ''); ?>>Islas Marshall</option>
                                            <option value="Islas Salomón" <?php echo e(old('pais') == 'Islas Salomón' ? 'selected' : ''); ?>>Islas Salomón</option>
                                            <option value="Israel" <?php echo e(old('pais') == 'Israel' ? 'selected' : ''); ?>>Israel</option>
                                            <option value="Italia" <?php echo e(old('pais') == 'Italia' ? 'selected' : ''); ?>>Italia</option>
                                            <option value="Jamaica" <?php echo e(old('pais') == 'Jamaica' ? 'selected' : ''); ?>>Jamaica</option>
                                            <option value="Japón" <?php echo e(old('pais') == 'Japón' ? 'selected' : ''); ?>>Japón</option>
                                            <option value="Jordania" <?php echo e(old('pais') == 'Jordania' ? 'selected' : ''); ?>>Jordania</option>
                                            <option value="Kazajistán" <?php echo e(old('pais') == 'Kazajistán' ? 'selected' : ''); ?>>Kazajistán</option>
                                            <option value="Kenia" <?php echo e(old('pais') == 'Kenia' ? 'selected' : ''); ?>>Kenia</option>
                                            <option value="Kirguistán" <?php echo e(old('pais') == 'Kirguistán' ? 'selected' : ''); ?>>Kirguistán</option>
                                            <option value="Kiribati" <?php echo e(old('pais') == 'Kiribati' ? 'selected' : ''); ?>>Kiribati</option>
                                            <option value="Kuwait" <?php echo e(old('pais') == 'Kuwait' ? 'selected' : ''); ?>>Kuwait</option>
                                            <option value="Laos" <?php echo e(old('pais') == 'Laos' ? 'selected' : ''); ?>>Laos</option>
                                            <option value="Lesoto" <?php echo e(old('pais') == 'Lesoto' ? 'selected' : ''); ?>>Lesoto</option>
                                            <option value="Letonia" <?php echo e(old('pais') == 'Letonia' ? 'selected' : ''); ?>>Letonia</option>
                                            <option value="Líbano" <?php echo e(old('pais') == 'Líbano' ? 'selected' : ''); ?>>Líbano</option>
                                            <option value="Liberia" <?php echo e(old('pais') == 'Liberia' ? 'selected' : ''); ?>>Liberia</option>
                                            <option value="Libia" <?php echo e(old('pais') == 'Libia' ? 'selected' : ''); ?>>Libia</option>
                                            <option value="Liechtenstein" <?php echo e(old('pais') == 'Liechtenstein' ? 'selected' : ''); ?>>Liechtenstein</option>
                                            <option value="Lituania" <?php echo e(old('pais') == 'Lituania' ? 'selected' : ''); ?>>Lituania</option>
                                            <option value="Luxemburgo" <?php echo e(old('pais') == 'Luxemburgo' ? 'selected' : ''); ?>>Luxemburgo</option>
                                            <option value="Macedonia del Norte" <?php echo e(old('pais') == 'Macedonia del Norte' ? 'selected' : ''); ?>>Macedonia del Norte</option>
                                            <option value="Madagascar" <?php echo e(old('pais') == 'Madagascar' ? 'selected' : ''); ?>>Madagascar</option>
                                            <option value="Malasia" <?php echo e(old('pais') == 'Malasia' ? 'selected' : ''); ?>>Malasia</option>
                                            <option value="Malaui" <?php echo e(old('pais') == 'Malaui' ? 'selected' : ''); ?>>Malaui</option>
                                            <option value="Maldivas" <?php echo e(old('pais') == 'Maldivas' ? 'selected' : ''); ?>>Maldivas</option>
                                            <option value="Malí" <?php echo e(old('pais') == 'Malí' ? 'selected' : ''); ?>>Malí</option>
                                            <option value="Malta" <?php echo e(old('pais') == 'Malta' ? 'selected' : ''); ?>>Malta</option>
                                            <option value="Marruecos" <?php echo e(old('pais') == 'Marruecos' ? 'selected' : ''); ?>>Marruecos</option>
                                            <option value="Mauricio" <?php echo e(old('pais') == 'Mauricio' ? 'selected' : ''); ?>>Mauricio</option>
                                            <option value="Mauritania" <?php echo e(old('pais') == 'Mauritania' ? 'selected' : ''); ?>>Mauritania</option>
                                            <option value="México" <?php echo e(old('pais') == 'México' ? 'selected' : ''); ?>>México</option>
                                            <option value="Micronesia" <?php echo e(old('pais') == 'Micronesia' ? 'selected' : ''); ?>>Micronesia</option>
                                            <option value="Moldavia" <?php echo e(old('pais') == 'Moldavia' ? 'selected' : ''); ?>>Moldavia</option>
                                            <option value="Mónaco" <?php echo e(old('pais') == 'Mónaco' ? 'selected' : ''); ?>>Mónaco</option>
                                            <option value="Mongolia" <?php echo e(old('pais') == 'Mongolia' ? 'selected' : ''); ?>>Mongolia</option>
                                            <option value="Montenegro" <?php echo e(old('pais') == 'Montenegro' ? 'selected' : ''); ?>>Montenegro</option>
                                            <option value="Mozambique" <?php echo e(old('pais') == 'Mozambique' ? 'selected' : ''); ?>>Mozambique</option>
                                            <option value="Namibia" <?php echo e(old('pais') == 'Namibia' ? 'selected' : ''); ?>>Namibia</option>
                                            <option value="Nauru" <?php echo e(old('pais') == 'Nauru' ? 'selected' : ''); ?>>Nauru</option>
                                            <option value="Nepal" <?php echo e(old('pais') == 'Nepal' ? 'selected' : ''); ?>>Nepal</option>
                                            <option value="Nicaragua" <?php echo e(old('pais') == 'Nicaragua' ? 'selected' : ''); ?>>Nicaragua</option>
                                            <option value="Níger" <?php echo e(old('pais') == 'Níger' ? 'selected' : ''); ?>>Níger</option>
                                            <option value="Nigeria" <?php echo e(old('pais') == 'Nigeria' ? 'selected' : ''); ?>>Nigeria</option>
                                            <option value="Noruega" <?php echo e(old('pais') == 'Noruega' ? 'selected' : ''); ?>>Noruega</option>
                                            <option value="Nueva Zelanda" <?php echo e(old('pais') == 'Nueva Zelanda' ? 'selected' : ''); ?>>Nueva Zelanda</option>
                                            <option value="Omán" <?php echo e(old('pais') == 'Omán' ? 'selected' : ''); ?>>Omán</option>
                                            <option value="Países Bajos" <?php echo e(old('pais') == 'Países Bajos' ? 'selected' : ''); ?>>Países Bajos</option>
                                            <option value="Pakistán" <?php echo e(old('pais') == 'Pakistán' ? 'selected' : ''); ?>>Pakistán</option>
                                            <option value="Palaos" <?php echo e(old('pais') == 'Palaos' ? 'selected' : ''); ?>>Palaos</option>
                                            <option value="Panamá" <?php echo e(old('pais') == 'Panamá' ? 'selected' : ''); ?>>Panamá</option>
                                            <option value="Papúa Nueva Guinea" <?php echo e(old('pais') == 'Papúa Nueva Guinea' ? 'selected' : ''); ?>>Papúa Nueva Guinea</option>
                                            <option value="Paraguay" <?php echo e(old('pais') == 'Paraguay' ? 'selected' : ''); ?>>Paraguay</option>
                                            <option value="Perú" <?php echo e(old('pais', 'Perú') == 'Perú' ? 'selected' : ''); ?>>Perú</option>
                                            <option value="Polonia" <?php echo e(old('pais') == 'Polonia' ? 'selected' : ''); ?>>Polonia</option>
                                            <option value="Portugal" <?php echo e(old('pais') == 'Portugal' ? 'selected' : ''); ?>>Portugal</option>
                                            <option value="Reino Unido" <?php echo e(old('pais') == 'Reino Unido' ? 'selected' : ''); ?>>Reino Unido</option>
                                            <option value="República Centroafricana" <?php echo e(old('pais') == 'República Centroafricana' ? 'selected' : ''); ?>>República Centroafricana</option>
                                            <option value="República Checa" <?php echo e(old('pais') == 'República Checa' ? 'selected' : ''); ?>>República Checa</option>
                                            <option value="República del Congo" <?php echo e(old('pais') == 'República del Congo' ? 'selected' : ''); ?>>República del Congo</option>
                                            <option value="República Democrática del Congo" <?php echo e(old('pais') == 'República Democrática del Congo' ? 'selected' : ''); ?>>República Democrática del Congo</option>
                                            <option value="República Dominicana" <?php echo e(old('pais') == 'República Dominicana' ? 'selected' : ''); ?>>República Dominicana</option>
                                            <option value="Ruanda" <?php echo e(old('pais') == 'Ruanda' ? 'selected' : ''); ?>>Ruanda</option>
                                            <option value="Rumania" <?php echo e(old('pais') == 'Rumania' ? 'selected' : ''); ?>>Rumania</option>
                                            <option value="Rusia" <?php echo e(old('pais') == 'Rusia' ? 'selected' : ''); ?>>Rusia</option>
                                            <option value="Samoa" <?php echo e(old('pais') == 'Samoa' ? 'selected' : ''); ?>>Samoa</option>
                                            <option value="San Cristóbal y Nieves" <?php echo e(old('pais') == 'San Cristóbal y Nieves' ? 'selected' : ''); ?>>San Cristóbal y Nieves</option>
                                            <option value="San Marino" <?php echo e(old('pais') == 'San Marino' ? 'selected' : ''); ?>>San Marino</option>
                                            <option value="San Vicente y las Granadinas" <?php echo e(old('pais') == 'San Vicente y las Granadinas' ? 'selected' : ''); ?>>San Vicente y las Granadinas</option>
                                            <option value="Santa Lucía" <?php echo e(old('pais') == 'Santa Lucía' ? 'selected' : ''); ?>>Santa Lucía</option>
                                            <option value="Santo Tomé y Príncipe" <?php echo e(old('pais') == 'Santo Tomé y Príncipe' ? 'selected' : ''); ?>>Santo Tomé y Príncipe</option>
                                            <option value="Senegal" <?php echo e(old('pais') == 'Senegal' ? 'selected' : ''); ?>>Senegal</option>
                                            <option value="Serbia" <?php echo e(old('pais') == 'Serbia' ? 'selected' : ''); ?>>Serbia</option>
                                            <option value="Seychelles" <?php echo e(old('pais') == 'Seychelles' ? 'selected' : ''); ?>>Seychelles</option>
                                            <option value="Sierra Leona" <?php echo e(old('pais') == 'Sierra Leona' ? 'selected' : ''); ?>>Sierra Leona</option>
                                            <option value="Singapur" <?php echo e(old('pais') == 'Singapur' ? 'selected' : ''); ?>>Singapur</option>
                                            <option value="Siria" <?php echo e(old('pais') == 'Siria' ? 'selected' : ''); ?>>Siria</option>
                                            <option value="Somalia" <?php echo e(old('pais') == 'Somalia' ? 'selected' : ''); ?>>Somalia</option>
                                            <option value="Sri Lanka" <?php echo e(old('pais') == 'Sri Lanka' ? 'selected' : ''); ?>>Sri Lanka</option>
                                            <option value="Suazilandia" <?php echo e(old('pais') == 'Suazilandia' ? 'selected' : ''); ?>>Suazilandia</option>
                                            <option value="Sudáfrica" <?php echo e(old('pais') == 'Sudáfrica' ? 'selected' : ''); ?>>Sudáfrica</option>
                                            <option value="Sudán" <?php echo e(old('pais') == 'Sudán' ? 'selected' : ''); ?>>Sudán</option>
                                            <option value="Sudán del Sur" <?php echo e(old('pais') == 'Sudán del Sur' ? 'selected' : ''); ?>>Sudán del Sur</option>
                                            <option value="Suecia" <?php echo e(old('pais') == 'Suecia' ? 'selected' : ''); ?>>Suecia</option>
                                            <option value="Suiza" <?php echo e(old('pais') == 'Suiza' ? 'selected' : ''); ?>>Suiza</option>
                                            <option value="Surinam" <?php echo e(old('pais') == 'Surinam' ? 'selected' : ''); ?>>Surinam</option>
                                            <option value="Tailandia" <?php echo e(old('pais') == 'Tailandia' ? 'selected' : ''); ?>>Tailandia</option>
                                            <option value="Tanzania" <?php echo e(old('pais') == 'Tanzania' ? 'selected' : ''); ?>>Tanzania</option>
                                            <option value="Tayikistán" <?php echo e(old('pais') == 'Tayikistán' ? 'selected' : ''); ?>>Tayikistán</option>
                                            <option value="Timor Oriental" <?php echo e(old('pais') == 'Timor Oriental' ? 'selected' : ''); ?>>Timor Oriental</option>
                                            <option value="Togo" <?php echo e(old('pais') == 'Togo' ? 'selected' : ''); ?>>Togo</option>
                                            <option value="Tonga" <?php echo e(old('pais') == 'Tonga' ? 'selected' : ''); ?>>Tonga</option>
                                            <option value="Trinidad y Tobago" <?php echo e(old('pais') == 'Trinidad y Tobago' ? 'selected' : ''); ?>>Trinidad y Tobago</option>
                                            <option value="Túnez" <?php echo e(old('pais') == 'Túnez' ? 'selected' : ''); ?>>Túnez</option>
                                            <option value="Turkmenistán" <?php echo e(old('pais') == 'Turkmenistán' ? 'selected' : ''); ?>>Turkmenistán</option>
                                            <option value="Turquía" <?php echo e(old('pais') == 'Turquía' ? 'selected' : ''); ?>>Turquía</option>
                                            <option value="Tuvalu" <?php echo e(old('pais') == 'Tuvalu' ? 'selected' : ''); ?>>Tuvalu</option>
                                            <option value="Ucrania" <?php echo e(old('pais') == 'Ucrania' ? 'selected' : ''); ?>>Ucrania</option>
                                            <option value="Uganda" <?php echo e(old('pais') == 'Uganda' ? 'selected' : ''); ?>>Uganda</option>
                                            <option value="Uruguay" <?php echo e(old('pais') == 'Uruguay' ? 'selected' : ''); ?>>Uruguay</option>
                                            <option value="Uzbekistán" <?php echo e(old('pais') == 'Uzbekistán' ? 'selected' : ''); ?>>Uzbekistán</option>
                                            <option value="Vanuatu" <?php echo e(old('pais') == 'Vanuatu' ? 'selected' : ''); ?>>Vanuatu</option>
                                            <option value="Vaticano" <?php echo e(old('pais') == 'Vaticano' ? 'selected' : ''); ?>>Vaticano</option>
                                            <option value="Venezuela" <?php echo e(old('pais') == 'Venezuela' ? 'selected' : ''); ?>>Venezuela</option>
                                            <option value="Vietnam" <?php echo e(old('pais') == 'Vietnam' ? 'selected' : ''); ?>>Vietnam</option>
                                            <option value="Yemen" <?php echo e(old('pais') == 'Yemen' ? 'selected' : ''); ?>>Yemen</option>
                                            <option value="Yibuti" <?php echo e(old('pais') == 'Yibuti' ? 'selected' : ''); ?>>Yibuti</option>
                                            <option value="Zambia" <?php echo e(old('pais') == 'Zambia' ? 'selected' : ''); ?>>Zambia</option>
                                            <option value="Zimbabue" <?php echo e(old('pais') == 'Zimbabue' ? 'selected' : ''); ?>>Zimbabue</option>
                                        </select>
                                        <?php $__errorArgs = ['pais'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="estado_civil" class="form-label">Estado Civil</label>
                                        <select class="form-select <?php $__errorArgs = ['estado_civil'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                id="estado_civil"
                                                name="estado_civil">
                                            <option value="">Seleccionar</option>
                                            <option value="Soltero(a)" <?php echo e(old('estado_civil') == 'Soltero(a)' ? 'selected' : ''); ?>>Soltero(a)</option>
                                            <option value="Casado(a)" <?php echo e(old('estado_civil') == 'Casado(a)' ? 'selected' : ''); ?>>Casado(a)</option>
                                            <option value="Divorciado(a)" <?php echo e(old('estado_civil') == 'Divorciado(a)' ? 'selected' : ''); ?>>Divorciado(a)</option>
                                            <option value="Viudo(a)" <?php echo e(old('estado_civil') == 'Viudo(a)' ? 'selected' : ''); ?>>Viudo(a)</option>
                                            <option value="Conviviente" <?php echo e(old('estado_civil') == 'Conviviente' ? 'selected' : ''); ?>>Conviviente</option>
                                        </select>
                                        <?php $__errorArgs = ['estado_civil'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="direccion" class="form-label">Dirección</label>
                                    <textarea class="form-control <?php $__errorArgs = ['direccion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                              id="direccion"
                                              name="direccion"
                                              rows="2"><?php echo e(old('direccion')); ?></textarea>
                                    <?php $__errorArgs = ['direccion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Información de Documentos -->
                    <div class="col-lg-6 mb-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-header bg-cesodo-black text-white">
                                <h5 class="mb-0">
                                    <i class="fas fa-id-card me-2"></i>
                                    Documentos e Identificación
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="tipo_documento" class="form-label">Tipo de Documento <span class="text-danger">*</span></label>
                                        <select class="form-select <?php $__errorArgs = ['tipo_documento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                id="tipo_documento"
                                                name="tipo_documento"
                                                required>
                                            <option value="">Seleccionar tipo</option>
                                            <option value="dni" <?php echo e(old('tipo_documento') == 'dni' ? 'selected' : ''); ?>>DNI</option>
                                            <option value="ce" <?php echo e(old('tipo_documento') == 'ce' ? 'selected' : ''); ?>>Carnet de Extranjería</option>
                                            <option value="pasaporte" <?php echo e(old('tipo_documento') == 'pasaporte' ? 'selected' : ''); ?>>Pasaporte</option>
                                            <option value="ruc" <?php echo e(old('tipo_documento') == 'ruc' ? 'selected' : ''); ?>>RUC</option>
                                            <option value="otros" <?php echo e(old('tipo_documento') == 'otros' ? 'selected' : ''); ?>>Otros</option>
                                        </select>
                                        <?php $__errorArgs = ['tipo_documento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="numero_documento" class="form-label">Número de Documento <span class="text-danger">*</span></label>
                                        <input type="text"
                                               class="form-control <?php $__errorArgs = ['numero_documento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               id="numero_documento"
                                               name="numero_documento"
                                               value="<?php echo e(old('numero_documento')); ?>"
                                               required>
                                        <?php $__errorArgs = ['numero_documento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>

                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Información:</strong>
                                    <ul class="mb-0 mt-2">
                                        <li><strong>DNI:</strong> 8 dígitos para peruanos</li>
                                        <li><strong>CE:</strong> Carnet de extranjería</li>
                                        <li><strong>Pasaporte:</strong> Documento internacional</li>
                                        <li><strong>RUC:</strong> 11 dígitos para empresas</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Información de Contacto -->
                    <div class="col-lg-12 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-header bg-cesodo-red text-white">
                                <h5 class="mb-0">
                                    <i class="fas fa-phone me-2"></i>
                                    Información de Contacto
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="celular" class="form-label">Teléfono/Celular</label>
                                        <input type="tel"
                                               class="form-control <?php $__errorArgs = ['celular'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               id="celular"
                                               name="celular"
                                               value="<?php echo e(old('celular')); ?>">
                                        <?php $__errorArgs = ['celular'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="correo" class="form-label">Correo Electrónico</label>
                                        <input type="email"
                                               class="form-control <?php $__errorArgs = ['correo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               id="correo"
                                               name="correo"
                                               value="<?php echo e(old('correo')); ?>">
                                        <?php $__errorArgs = ['correo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="<?php echo e(route('personas.index')); ?>" class="btn btn-secondary">
                                        <i class="fas fa-times me-1"></i>
                                        Cancelar
                                    </a>
                                    <button type="reset" class="btn btn-outline-warning">
                                        <i class="fas fa-undo me-1"></i>
                                        Limpiar
                                    </button>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save me-1"></i>
                                        Guardar Persona
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Validación de DNI
    const tipoDocumento = document.getElementById('tipo_documento');
    const numeroDocumento = document.getElementById('numero_documento');

    function validarDocumento() {
        const tipo = tipoDocumento.value;
        numeroDocumento.removeAttribute('maxlength');
        numeroDocumento.removeAttribute('pattern');

        switch(tipo) {
            case 'dni':
                numeroDocumento.setAttribute('maxlength', '8');
                numeroDocumento.setAttribute('pattern', '[0-9]{8}');
                numeroDocumento.setAttribute('placeholder', '12345678');
                break;
            case 'ruc':
                numeroDocumento.setAttribute('maxlength', '11');
                numeroDocumento.setAttribute('pattern', '[0-9]{11}');
                numeroDocumento.setAttribute('placeholder', '12345678901');
                break;
            case 'ce':
                numeroDocumento.setAttribute('maxlength', '12');
                numeroDocumento.setAttribute('placeholder', '001234567');
                break;
            case 'pasaporte':
                numeroDocumento.setAttribute('maxlength', '15');
                numeroDocumento.setAttribute('placeholder', 'ABC123456');
                break;
            default:
                numeroDocumento.setAttribute('placeholder', 'Número de documento');
        }
    }

    tipoDocumento.addEventListener('change', validarDocumento);

    // Validación de solo números para DNI y RUC
    numeroDocumento.addEventListener('input', function() {
        const tipo = tipoDocumento.value;
        if (tipo === 'dni' || tipo === 'ruc') {
            this.value = this.value.replace(/\D/g, '');
        }
    });

    // Validación de teléfono
    const celularInput = document.getElementById('celular');
    celularInput.addEventListener('input', function() {
        this.value = this.value.replace(/\D/g, '').slice(0, 9);
    });

    // Confirmación antes de enviar
    document.getElementById('createPersonaForm').addEventListener('submit', function(e) {
        if (!confirm('¿Está seguro de crear esta persona?')) {
            e.preventDefault();
        }
    });
});

// Funciones para mejorar la fecha de nacimiento
function calcularEdad() {
    const fechaNacimiento = document.getElementById('fecha_nacimiento').value;
    const edadDisplay = document.getElementById('edad_display');
    const edadTexto = document.getElementById('edad_texto');

    if (fechaNacimiento) {
        const hoy = new Date();
        const nacimiento = new Date(fechaNacimiento);
        let edad = hoy.getFullYear() - nacimiento.getFullYear();
        const mes = hoy.getMonth() - nacimiento.getMonth();

        if (mes < 0 || (mes === 0 && hoy.getDate() < nacimiento.getDate())) {
            edad--;
        }

        if (edad >= 0 && edad <= 120) {
            let textoEdad = `Edad: ${edad} años`;
            let categoria = '';

            if (edad < 18) {
                categoria = ' (Menor de edad - No permitido)';
                edadDisplay.className = 'form-text text-danger mt-1';
                document.getElementById('fecha_nacimiento').setCustomValidity('Debe ser mayor de 18 años');
            } else if (edad >= 65) {
                categoria = ' (Adulto mayor)';
                edadDisplay.className = 'form-text text-cesodo-black mt-1 edad-feedback';
                document.getElementById('fecha_nacimiento').setCustomValidity('');
            } else {
                edadDisplay.className = 'form-text text-cesodo-black mt-1 edad-feedback';
                document.getElementById('fecha_nacimiento').setCustomValidity('');
            }

            edadTexto.textContent = textoEdad + categoria;
            edadDisplay.style.display = 'block';
        } else if (edad < 0) {
            edadTexto.textContent = 'Fecha futura no válida';
            edadDisplay.style.display = 'block';
            edadDisplay.className = 'form-text text-danger mt-1';
            document.getElementById('fecha_nacimiento').setCustomValidity('La fecha no puede ser futura');
        } else {
            edadTexto.textContent = 'Edad no realista (más de 120 años)';
            edadDisplay.style.display = 'block';
            edadDisplay.className = 'form-text text-danger mt-1';
            document.getElementById('fecha_nacimiento').setCustomValidity('Edad no válida');
        }
    } else {
        edadDisplay.style.display = 'none';
        document.getElementById('fecha_nacimiento').setCustomValidity('');
    }
}

// Auto-ocultar mensajes de error después de 3 segundos
document.addEventListener('DOMContentLoaded', function() {
    const errorMessages = document.querySelectorAll('.invalid-feedback');

    errorMessages.forEach(function(message) {
        if (message.style.display !== 'none' && message.textContent.trim() !== '') {
            setTimeout(function() {
                message.style.transition = 'opacity 0.5s ease-out';
                message.style.opacity = '0';
                setTimeout(function() {
                    message.style.display = 'none';
                }, 500);
            }, 3000);
        }
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cesodo4\resources\views/personas/create.blade.php ENDPATH**/ ?>