@extends('layouts.app')

@section('title', 'Editar Persona')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/cesodo-theme.css') }}">
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
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">
                    <i class="fas fa-user-edit text-cesodo-red me-2"></i>
                    Editar Persona
                </h2>
                <a href="{{ route('personas.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i>
                    Volver
                </a>
            </div>

            <form action="{{ route('personas.update', $persona->id) }}" method="POST" id="editPersonaForm">
                @csrf
                @method('PUT')

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
                                               class="form-control @error('nombres') is-invalid @enderror"
                                               id="nombres"
                                               name="nombres"
                                               value="{{ old('nombres', $persona->nombres) }}"
                                               required>
                                        @error('nombres')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="apellidos" class="form-label">Apellidos <span class="text-danger">*</span></label>
                                        <input type="text"
                                               class="form-control @error('apellidos') is-invalid @enderror"
                                               id="apellidos"
                                               name="apellidos"
                                               value="{{ old('apellidos', $persona->apellidos) }}"
                                               required>
                                        @error('apellidos')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
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
                                                   class="form-control fecha-nacimiento-enhanced @error('fecha_nacimiento') is-invalid @enderror"
                                                   id="fecha_nacimiento"
                                                   name="fecha_nacimiento"
                                                   value="{{ old('fecha_nacimiento', $persona->fecha_nacimiento) }}"
                                                   max="{{ date('Y-m-d', strtotime('-18 years')) }}"
                                                   min="{{ date('Y-m-d', strtotime('-120 years')) }}"
                                                   onchange="calcularEdad()"
                                                   title="Selecciona la fecha de nacimiento (debe ser mayor de 18 años)">
                                        </div>
                                        <div id="edad_display" class="form-text text-cesodo-black mt-1" style="display: none;">
                                            <i class="fas fa-info-circle me-1"></i>
                                            <span id="edad_texto"></span>
                                        </div>
                                        @error('fecha_nacimiento')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="sexo" class="form-label">Sexo</label>
                                        <select class="form-select @error('sexo') is-invalid @enderror"
                                                id="sexo"
                                                name="sexo">
                                            <option value="">Seleccionar</option>
                                            <option value="M" {{ old('sexo', $persona->sexo) == 'M' ? 'selected' : '' }}>Masculino</option>
                                            <option value="F" {{ old('sexo', $persona->sexo) == 'F' ? 'selected' : '' }}>Femenino</option>
                                            <option value="O" {{ old('sexo', $persona->sexo) == 'O' ? 'selected' : '' }}>Otro</option>
                                        </select>
                                        @error('sexo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="pais" class="form-label">
                                            <i class="fas fa-globe text-cesodo-red me-1"></i>
                                            País
                                        </label>
                                        <select class="form-select @error('pais') is-invalid @enderror"
                                                id="pais"
                                                name="pais">
                                            <option value="">Seleccionar país</option>
                                            <option value="Afganistán" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Afganistán' ? 'selected' : '' }}>Afganistán</option>
                                            <option value="Albania" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Albania' ? 'selected' : '' }}>Albania</option>
                                            <option value="Alemania" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Alemania' ? 'selected' : '' }}>Alemania</option>
                                            <option value="Andorra" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Andorra' ? 'selected' : '' }}>Andorra</option>
                                            <option value="Angola" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Angola' ? 'selected' : '' }}>Angola</option>
                                            <option value="Antigua y Barbuda" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Antigua y Barbuda' ? 'selected' : '' }}>Antigua y Barbuda</option>
                                            <option value="Arabia Saudita" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Arabia Saudita' ? 'selected' : '' }}>Arabia Saudita</option>
                                            <option value="Argelia" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Argelia' ? 'selected' : '' }}>Argelia</option>
                                            <option value="Argentina" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Argentina' ? 'selected' : '' }}>Argentina</option>
                                            <option value="Armenia" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Armenia' ? 'selected' : '' }}>Armenia</option>
                                            <option value="Australia" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Australia' ? 'selected' : '' }}>Australia</option>
                                            <option value="Austria" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Austria' ? 'selected' : '' }}>Austria</option>
                                            <option value="Azerbaiyán" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Azerbaiyán' ? 'selected' : '' }}>Azerbaiyán</option>
                                            <option value="Bahamas" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Bahamas' ? 'selected' : '' }}>Bahamas</option>
                                            <option value="Bangladés" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Bangladés' ? 'selected' : '' }}>Bangladés</option>
                                            <option value="Barbados" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Barbados' ? 'selected' : '' }}>Barbados</option>
                                            <option value="Baréin" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Baréin' ? 'selected' : '' }}>Baréin</option>
                                            <option value="Bélgica" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Bélgica' ? 'selected' : '' }}>Bélgica</option>
                                            <option value="Belice" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Belice' ? 'selected' : '' }}>Belice</option>
                                            <option value="Benín" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Benín' ? 'selected' : '' }}>Benín</option>
                                            <option value="Bielorrusia" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Bielorrusia' ? 'selected' : '' }}>Bielorrusia</option>
                                            <option value="Birmania" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Birmania' ? 'selected' : '' }}>Birmania</option>
                                            <option value="Bolivia" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Bolivia' ? 'selected' : '' }}>Bolivia</option>
                                            <option value="Bosnia y Herzegovina" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Bosnia y Herzegovina' ? 'selected' : '' }}>Bosnia y Herzegovina</option>
                                            <option value="Botsuana" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Botsuana' ? 'selected' : '' }}>Botsuana</option>
                                            <option value="Brasil" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Brasil' ? 'selected' : '' }}>Brasil</option>
                                            <option value="Brunéi" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Brunéi' ? 'selected' : '' }}>Brunéi</option>
                                            <option value="Bulgaria" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Bulgaria' ? 'selected' : '' }}>Bulgaria</option>
                                            <option value="Burkina Faso" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Burkina Faso' ? 'selected' : '' }}>Burkina Faso</option>
                                            <option value="Burundi" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Burundi' ? 'selected' : '' }}>Burundi</option>
                                            <option value="Bután" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Bután' ? 'selected' : '' }}>Bután</option>
                                            <option value="Cabo Verde" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Cabo Verde' ? 'selected' : '' }}>Cabo Verde</option>
                                            <option value="Camboya" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Camboya' ? 'selected' : '' }}>Camboya</option>
                                            <option value="Camerún" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Camerún' ? 'selected' : '' }}>Camerún</option>
                                            <option value="Canadá" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Canadá' ? 'selected' : '' }}>Canadá</option>
                                            <option value="Catar" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Catar' ? 'selected' : '' }}>Catar</option>
                                            <option value="Chad" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Chad' ? 'selected' : '' }}>Chad</option>
                                            <option value="Chile" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Chile' ? 'selected' : '' }}>Chile</option>
                                            <option value="China" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'China' ? 'selected' : '' }}>China</option>
                                            <option value="Chipre" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Chipre' ? 'selected' : '' }}>Chipre</option>
                                            <option value="Colombia" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Colombia' ? 'selected' : '' }}>Colombia</option>
                                            <option value="Comoras" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Comoras' ? 'selected' : '' }}>Comoras</option>
                                            <option value="Corea del Norte" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Corea del Norte' ? 'selected' : '' }}>Corea del Norte</option>
                                            <option value="Corea del Sur" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Corea del Sur' ? 'selected' : '' }}>Corea del Sur</option>
                                            <option value="Costa de Marfil" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Costa de Marfil' ? 'selected' : '' }}>Costa de Marfil</option>
                                            <option value="Costa Rica" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Costa Rica' ? 'selected' : '' }}>Costa Rica</option>
                                            <option value="Croacia" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Croacia' ? 'selected' : '' }}>Croacia</option>
                                            <option value="Cuba" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Cuba' ? 'selected' : '' }}>Cuba</option>
                                            <option value="Dinamarca" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Dinamarca' ? 'selected' : '' }}>Dinamarca</option>
                                            <option value="Dominica" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Dominica' ? 'selected' : '' }}>Dominica</option>
                                            <option value="Ecuador" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Ecuador' ? 'selected' : '' }}>Ecuador</option>
                                            <option value="Egipto" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Egipto' ? 'selected' : '' }}>Egipto</option>
                                            <option value="El Salvador" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'El Salvador' ? 'selected' : '' }}>El Salvador</option>
                                            <option value="Emiratos Árabes Unidos" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Emiratos Árabes Unidos' ? 'selected' : '' }}>Emiratos Árabes Unidos</option>
                                            <option value="Eritrea" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Eritrea' ? 'selected' : '' }}>Eritrea</option>
                                            <option value="Eslovaquia" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Eslovaquia' ? 'selected' : '' }}>Eslovaquia</option>
                                            <option value="Eslovenia" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Eslovenia' ? 'selected' : '' }}>Eslovenia</option>
                                            <option value="España" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'España' ? 'selected' : '' }}>España</option>
                                            <option value="Estados Unidos" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Estados Unidos' ? 'selected' : '' }}>Estados Unidos</option>
                                            <option value="Estonia" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Estonia' ? 'selected' : '' }}>Estonia</option>
                                            <option value="Etiopía" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Etiopía' ? 'selected' : '' }}>Etiopía</option>
                                            <option value="Filipinas" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Filipinas' ? 'selected' : '' }}>Filipinas</option>
                                            <option value="Finlandia" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Finlandia' ? 'selected' : '' }}>Finlandia</option>
                                            <option value="Fiyi" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Fiyi' ? 'selected' : '' }}>Fiyi</option>
                                            <option value="Francia" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Francia' ? 'selected' : '' }}>Francia</option>
                                            <option value="Gabón" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Gabón' ? 'selected' : '' }}>Gabón</option>
                                            <option value="Gambia" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Gambia' ? 'selected' : '' }}>Gambia</option>
                                            <option value="Georgia" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Georgia' ? 'selected' : '' }}>Georgia</option>
                                            <option value="Ghana" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Ghana' ? 'selected' : '' }}>Ghana</option>
                                            <option value="Granada" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Granada' ? 'selected' : '' }}>Granada</option>
                                            <option value="Grecia" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Grecia' ? 'selected' : '' }}>Grecia</option>
                                            <option value="Guatemala" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Guatemala' ? 'selected' : '' }}>Guatemala</option>
                                            <option value="Guinea" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Guinea' ? 'selected' : '' }}>Guinea</option>
                                            <option value="Guinea Ecuatorial" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Guinea Ecuatorial' ? 'selected' : '' }}>Guinea Ecuatorial</option>
                                            <option value="Guinea-Bisáu" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Guinea-Bisáu' ? 'selected' : '' }}>Guinea-Bisáu</option>
                                            <option value="Guyana" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Guyana' ? 'selected' : '' }}>Guyana</option>
                                            <option value="Haití" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Haití' ? 'selected' : '' }}>Haití</option>
                                            <option value="Honduras" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Honduras' ? 'selected' : '' }}>Honduras</option>
                                            <option value="Hungría" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Hungría' ? 'selected' : '' }}>Hungría</option>
                                            <option value="India" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'India' ? 'selected' : '' }}>India</option>
                                            <option value="Indonesia" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Indonesia' ? 'selected' : '' }}>Indonesia</option>
                                            <option value="Irak" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Irak' ? 'selected' : '' }}>Irak</option>
                                            <option value="Irán" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Irán' ? 'selected' : '' }}>Irán</option>
                                            <option value="Irlanda" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Irlanda' ? 'selected' : '' }}>Irlanda</option>
                                            <option value="Islandia" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Islandia' ? 'selected' : '' }}>Islandia</option>
                                            <option value="Islas Marshall" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Islas Marshall' ? 'selected' : '' }}>Islas Marshall</option>
                                            <option value="Islas Salomón" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Islas Salomón' ? 'selected' : '' }}>Islas Salomón</option>
                                            <option value="Israel" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Israel' ? 'selected' : '' }}>Israel</option>
                                            <option value="Italia" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Italia' ? 'selected' : '' }}>Italia</option>
                                            <option value="Jamaica" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Jamaica' ? 'selected' : '' }}>Jamaica</option>
                                            <option value="Japón" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Japón' ? 'selected' : '' }}>Japón</option>
                                            <option value="Jordania" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Jordania' ? 'selected' : '' }}>Jordania</option>
                                            <option value="Kazajistán" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Kazajistán' ? 'selected' : '' }}>Kazajistán</option>
                                            <option value="Kenia" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Kenia' ? 'selected' : '' }}>Kenia</option>
                                            <option value="Kirguistán" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Kirguistán' ? 'selected' : '' }}>Kirguistán</option>
                                            <option value="Kiribati" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Kiribati' ? 'selected' : '' }}>Kiribati</option>
                                            <option value="Kuwait" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Kuwait' ? 'selected' : '' }}>Kuwait</option>
                                            <option value="Laos" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Laos' ? 'selected' : '' }}>Laos</option>
                                            <option value="Lesoto" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Lesoto' ? 'selected' : '' }}>Lesoto</option>
                                            <option value="Letonia" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Letonia' ? 'selected' : '' }}>Letonia</option>
                                            <option value="Líbano" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Líbano' ? 'selected' : '' }}>Líbano</option>
                                            <option value="Liberia" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Liberia' ? 'selected' : '' }}>Liberia</option>
                                            <option value="Libia" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Libia' ? 'selected' : '' }}>Libia</option>
                                            <option value="Liechtenstein" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Liechtenstein' ? 'selected' : '' }}>Liechtenstein</option>
                                            <option value="Lituania" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Lituania' ? 'selected' : '' }}>Lituania</option>
                                            <option value="Luxemburgo" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Luxemburgo' ? 'selected' : '' }}>Luxemburgo</option>
                                            <option value="Macedonia del Norte" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Macedonia del Norte' ? 'selected' : '' }}>Macedonia del Norte</option>
                                            <option value="Madagascar" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Madagascar' ? 'selected' : '' }}>Madagascar</option>
                                            <option value="Malasia" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Malasia' ? 'selected' : '' }}>Malasia</option>
                                            <option value="Malaui" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Malaui' ? 'selected' : '' }}>Malaui</option>
                                            <option value="Maldivas" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Maldivas' ? 'selected' : '' }}>Maldivas</option>
                                            <option value="Malí" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Malí' ? 'selected' : '' }}>Malí</option>
                                            <option value="Malta" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Malta' ? 'selected' : '' }}>Malta</option>
                                            <option value="Marruecos" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Marruecos' ? 'selected' : '' }}>Marruecos</option>
                                            <option value="Mauricio" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Mauricio' ? 'selected' : '' }}>Mauricio</option>
                                            <option value="Mauritania" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Mauritania' ? 'selected' : '' }}>Mauritania</option>
                                            <option value="México" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'México' ? 'selected' : '' }}>México</option>
                                            <option value="Micronesia" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Micronesia' ? 'selected' : '' }}>Micronesia</option>
                                            <option value="Moldavia" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Moldavia' ? 'selected' : '' }}>Moldavia</option>
                                            <option value="Mónaco" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Mónaco' ? 'selected' : '' }}>Mónaco</option>
                                            <option value="Mongolia" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Mongolia' ? 'selected' : '' }}>Mongolia</option>
                                            <option value="Montenegro" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Montenegro' ? 'selected' : '' }}>Montenegro</option>
                                            <option value="Mozambique" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Mozambique' ? 'selected' : '' }}>Mozambique</option>
                                            <option value="Namibia" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Namibia' ? 'selected' : '' }}>Namibia</option>
                                            <option value="Nauru" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Nauru' ? 'selected' : '' }}>Nauru</option>
                                            <option value="Nepal" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Nepal' ? 'selected' : '' }}>Nepal</option>
                                            <option value="Nicaragua" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Nicaragua' ? 'selected' : '' }}>Nicaragua</option>
                                            <option value="Níger" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Níger' ? 'selected' : '' }}>Níger</option>
                                            <option value="Nigeria" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Nigeria' ? 'selected' : '' }}>Nigeria</option>
                                            <option value="Noruega" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Noruega' ? 'selected' : '' }}>Noruega</option>
                                            <option value="Nueva Zelanda" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Nueva Zelanda' ? 'selected' : '' }}>Nueva Zelanda</option>
                                            <option value="Omán" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Omán' ? 'selected' : '' }}>Omán</option>
                                            <option value="Países Bajos" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Países Bajos' ? 'selected' : '' }}>Países Bajos</option>
                                            <option value="Pakistán" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Pakistán' ? 'selected' : '' }}>Pakistán</option>
                                            <option value="Palaos" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Palaos' ? 'selected' : '' }}>Palaos</option>
                                            <option value="Panamá" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Panamá' ? 'selected' : '' }}>Panamá</option>
                                            <option value="Papúa Nueva Guinea" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Papúa Nueva Guinea' ? 'selected' : '' }}>Papúa Nueva Guinea</option>
                                            <option value="Paraguay" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Paraguay' ? 'selected' : '' }}>Paraguay</option>
                                            <option value="Perú" {{ old('pais', $persona->pais ?? $persona->nacionalidad ?? 'Perú') == 'Perú' ? 'selected' : '' }}>Perú</option>
                                            <option value="Polonia" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Polonia' ? 'selected' : '' }}>Polonia</option>
                                            <option value="Portugal" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Portugal' ? 'selected' : '' }}>Portugal</option>
                                            <option value="Reino Unido" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Reino Unido' ? 'selected' : '' }}>Reino Unido</option>
                                            <option value="República Centroafricana" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'República Centroafricana' ? 'selected' : '' }}>República Centroafricana</option>
                                            <option value="República Checa" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'República Checa' ? 'selected' : '' }}>República Checa</option>
                                            <option value="República del Congo" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'República del Congo' ? 'selected' : '' }}>República del Congo</option>
                                            <option value="República Democrática del Congo" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'República Democrática del Congo' ? 'selected' : '' }}>República Democrática del Congo</option>
                                            <option value="República Dominicana" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'República Dominicana' ? 'selected' : '' }}>República Dominicana</option>
                                            <option value="Ruanda" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Ruanda' ? 'selected' : '' }}>Ruanda</option>
                                            <option value="Rumania" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Rumania' ? 'selected' : '' }}>Rumania</option>
                                            <option value="Rusia" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Rusia' ? 'selected' : '' }}>Rusia</option>
                                            <option value="Samoa" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Samoa' ? 'selected' : '' }}>Samoa</option>
                                            <option value="San Cristóbal y Nieves" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'San Cristóbal y Nieves' ? 'selected' : '' }}>San Cristóbal y Nieves</option>
                                            <option value="San Marino" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'San Marino' ? 'selected' : '' }}>San Marino</option>
                                            <option value="San Vicente y las Granadinas" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'San Vicente y las Granadinas' ? 'selected' : '' }}>San Vicente y las Granadinas</option>
                                            <option value="Santa Lucía" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Santa Lucía' ? 'selected' : '' }}>Santa Lucía</option>
                                            <option value="Santo Tomé y Príncipe" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Santo Tomé y Príncipe' ? 'selected' : '' }}>Santo Tomé y Príncipe</option>
                                            <option value="Senegal" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Senegal' ? 'selected' : '' }}>Senegal</option>
                                            <option value="Serbia" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Serbia' ? 'selected' : '' }}>Serbia</option>
                                            <option value="Seychelles" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Seychelles' ? 'selected' : '' }}>Seychelles</option>
                                            <option value="Sierra Leona" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Sierra Leona' ? 'selected' : '' }}>Sierra Leona</option>
                                            <option value="Singapur" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Singapur' ? 'selected' : '' }}>Singapur</option>
                                            <option value="Siria" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Siria' ? 'selected' : '' }}>Siria</option>
                                            <option value="Somalia" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Somalia' ? 'selected' : '' }}>Somalia</option>
                                            <option value="Sri Lanka" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Sri Lanka' ? 'selected' : '' }}>Sri Lanka</option>
                                            <option value="Suazilandia" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Suazilandia' ? 'selected' : '' }}>Suazilandia</option>
                                            <option value="Sudáfrica" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Sudáfrica' ? 'selected' : '' }}>Sudáfrica</option>
                                            <option value="Sudán" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Sudán' ? 'selected' : '' }}>Sudán</option>
                                            <option value="Sudán del Sur" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Sudán del Sur' ? 'selected' : '' }}>Sudán del Sur</option>
                                            <option value="Suecia" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Suecia' ? 'selected' : '' }}>Suecia</option>
                                            <option value="Suiza" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Suiza' ? 'selected' : '' }}>Suiza</option>
                                            <option value="Surinam" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Surinam' ? 'selected' : '' }}>Surinam</option>
                                            <option value="Tailandia" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Tailandia' ? 'selected' : '' }}>Tailandia</option>
                                            <option value="Tanzania" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Tanzania' ? 'selected' : '' }}>Tanzania</option>
                                            <option value="Tayikistán" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Tayikistán' ? 'selected' : '' }}>Tayikistán</option>
                                            <option value="Timor Oriental" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Timor Oriental' ? 'selected' : '' }}>Timor Oriental</option>
                                            <option value="Togo" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Togo' ? 'selected' : '' }}>Togo</option>
                                            <option value="Tonga" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Tonga' ? 'selected' : '' }}>Tonga</option>
                                            <option value="Trinidad y Tobago" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Trinidad y Tobago' ? 'selected' : '' }}>Trinidad y Tobago</option>
                                            <option value="Túnez" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Túnez' ? 'selected' : '' }}>Túnez</option>
                                            <option value="Turkmenistán" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Turkmenistán' ? 'selected' : '' }}>Turkmenistán</option>
                                            <option value="Turquía" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Turquía' ? 'selected' : '' }}>Turquía</option>
                                            <option value="Tuvalu" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Tuvalu' ? 'selected' : '' }}>Tuvalu</option>
                                            <option value="Ucrania" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Ucrania' ? 'selected' : '' }}>Ucrania</option>
                                            <option value="Uganda" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Uganda' ? 'selected' : '' }}>Uganda</option>
                                            <option value="Uruguay" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Uruguay' ? 'selected' : '' }}>Uruguay</option>
                                            <option value="Uzbekistán" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Uzbekistán' ? 'selected' : '' }}>Uzbekistán</option>
                                            <option value="Vanuatu" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Vanuatu' ? 'selected' : '' }}>Vanuatu</option>
                                            <option value="Vaticano" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Vaticano' ? 'selected' : '' }}>Vaticano</option>
                                            <option value="Venezuela" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Venezuela' ? 'selected' : '' }}>Venezuela</option>
                                            <option value="Vietnam" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Vietnam' ? 'selected' : '' }}>Vietnam</option>
                                            <option value="Yemen" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Yemen' ? 'selected' : '' }}>Yemen</option>
                                            <option value="Yibuti" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Yibuti' ? 'selected' : '' }}>Yibuti</option>
                                            <option value="Zambia" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Zambia' ? 'selected' : '' }}>Zambia</option>
                                            <option value="Zimbabue" {{ old('pais', $persona->pais ?? $persona->nacionalidad) == 'Zimbabue' ? 'selected' : '' }}>Zimbabue</option>
                                        </select>
                                        @error('pais')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="estado_civil" class="form-label">Estado Civil</label>
                                        <select class="form-select @error('estado_civil') is-invalid @enderror"
                                                id="estado_civil"
                                                name="estado_civil">
                                            <option value="">Seleccionar</option>
                                            <option value="Soltero(a)" {{ old('estado_civil', $persona->estado_civil) == 'Soltero(a)' ? 'selected' : '' }}>Soltero(a)</option>
                                            <option value="Casado(a)" {{ old('estado_civil', $persona->estado_civil) == 'Casado(a)' ? 'selected' : '' }}>Casado(a)</option>
                                            <option value="Divorciado(a)" {{ old('estado_civil', $persona->estado_civil) == 'Divorciado(a)' ? 'selected' : '' }}>Divorciado(a)</option>
                                            <option value="Viudo(a)" {{ old('estado_civil', $persona->estado_civil) == 'Viudo(a)' ? 'selected' : '' }}>Viudo(a)</option>
                                            <option value="Conviviente" {{ old('estado_civil', $persona->estado_civil) == 'Conviviente' ? 'selected' : '' }}>Conviviente</option>
                                        </select>
                                        @error('estado_civil')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="direccion" class="form-label">Dirección</label>
                                    <textarea class="form-control @error('direccion') is-invalid @enderror"
                                              id="direccion"
                                              name="direccion"
                                              rows="2">{{ old('direccion', $persona->direccion) }}</textarea>
                                    @error('direccion')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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
                                        <select class="form-select @error('tipo_documento') is-invalid @enderror"
                                                id="tipo_documento"
                                                name="tipo_documento"
                                                required>
                                            <option value="">Seleccionar tipo</option>
                                            <option value="dni" {{ old('tipo_documento', strtolower($persona->tipo_documento)) == 'dni' ? 'selected' : '' }}>DNI</option>
                                            <option value="ce" {{ old('tipo_documento', strtolower($persona->tipo_documento)) == 'ce' ? 'selected' : '' }}>Carnet de Extranjería</option>
                                            <option value="pasaporte" {{ old('tipo_documento', strtolower($persona->tipo_documento)) == 'pasaporte' ? 'selected' : '' }}>Pasaporte</option>
                                            <option value="ruc" {{ old('tipo_documento', strtolower($persona->tipo_documento)) == 'ruc' ? 'selected' : '' }}>RUC</option>
                                            <option value="otros" {{ old('tipo_documento', strtolower($persona->tipo_documento)) == 'otros' ? 'selected' : '' }}>Otros</option>
                                        </select>
                                        @error('tipo_documento')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="numero_documento" class="form-label">Número de Documento <span class="text-danger">*</span></label>
                                        <input type="text"
                                               class="form-control @error('numero_documento') is-invalid @enderror"
                                               id="numero_documento"
                                               name="numero_documento"
                                               value="{{ old('numero_documento', $persona->numero_documento) }}"
                                               required>
                                        @error('numero_documento')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
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
                                               class="form-control @error('celular') is-invalid @enderror"
                                               id="celular"
                                               name="celular"
                                               value="{{ old('celular', $persona->celular) }}">
                                        @error('celular')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="correo" class="form-label">Correo Electrónico</label>
                                        <input type="email"
                                               class="form-control @error('correo') is-invalid @enderror"
                                               id="correo"
                                               name="correo"
                                               value="{{ old('correo', $persona->correo) }}">
                                        @error('correo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
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
                                    <a href="{{ route('personas.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-times me-1"></i>
                                        Cancelar
                                    </a>
                                    <button type="reset" class="btn btn-outline-warning">
                                        <i class="fas fa-undo me-1"></i>
                                        Restablecer
                                    </button>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save me-1"></i>
                                        Actualizar Persona
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

@push('scripts')
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
    document.getElementById('editPersonaForm').addEventListener('submit', function(e) {
        if (!confirm('¿Está seguro de actualizar los datos de esta persona?')) {
            e.preventDefault();
        }
    });

    // Ejecutar validación inicial para mostrar placeholder correcto
    validarDocumento();

    // Calcular edad inicial si hay fecha
    calcularEdad();
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
@endpush
@endsection
