@extends('layouts.app')

@section('title', 'Nueva Persona')

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
                    <i class="fas fa-user-plus text-cesodo-red me-2"></i>
                    Nueva Persona
                </h2>
                <a href="{{ route('personas.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i>
                    Volver
                </a>
            </div>

            <form action="{{ route('personas.store') }}" method="POST" id="createPersonaForm">
                @csrf

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
                                               value="{{ old('nombres') }}"
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
                                               value="{{ old('apellidos') }}"
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
                                                   value="{{ old('fecha_nacimiento') }}"
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
                                            <option value="M" {{ old('sexo') == 'M' ? 'selected' : '' }}>Masculino</option>
                                            <option value="F" {{ old('sexo') == 'F' ? 'selected' : '' }}>Femenino</option>
                                            <option value="O" {{ old('sexo') == 'O' ? 'selected' : '' }}>Otro</option>
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
                                            <option value="Afganistán" {{ old('pais') == 'Afganistán' ? 'selected' : '' }}>Afganistán</option>
                                            <option value="Albania" {{ old('pais') == 'Albania' ? 'selected' : '' }}>Albania</option>
                                            <option value="Alemania" {{ old('pais') == 'Alemania' ? 'selected' : '' }}>Alemania</option>
                                            <option value="Andorra" {{ old('pais') == 'Andorra' ? 'selected' : '' }}>Andorra</option>
                                            <option value="Angola" {{ old('pais') == 'Angola' ? 'selected' : '' }}>Angola</option>
                                            <option value="Antigua y Barbuda" {{ old('pais') == 'Antigua y Barbuda' ? 'selected' : '' }}>Antigua y Barbuda</option>
                                            <option value="Arabia Saudita" {{ old('pais') == 'Arabia Saudita' ? 'selected' : '' }}>Arabia Saudita</option>
                                            <option value="Argelia" {{ old('pais') == 'Argelia' ? 'selected' : '' }}>Argelia</option>
                                            <option value="Argentina" {{ old('pais') == 'Argentina' ? 'selected' : '' }}>Argentina</option>
                                            <option value="Armenia" {{ old('pais') == 'Armenia' ? 'selected' : '' }}>Armenia</option>
                                            <option value="Australia" {{ old('pais') == 'Australia' ? 'selected' : '' }}>Australia</option>
                                            <option value="Austria" {{ old('pais') == 'Austria' ? 'selected' : '' }}>Austria</option>
                                            <option value="Azerbaiyán" {{ old('pais') == 'Azerbaiyán' ? 'selected' : '' }}>Azerbaiyán</option>
                                            <option value="Bahamas" {{ old('pais') == 'Bahamas' ? 'selected' : '' }}>Bahamas</option>
                                            <option value="Bangladés" {{ old('pais') == 'Bangladés' ? 'selected' : '' }}>Bangladés</option>
                                            <option value="Barbados" {{ old('pais') == 'Barbados' ? 'selected' : '' }}>Barbados</option>
                                            <option value="Baréin" {{ old('pais') == 'Baréin' ? 'selected' : '' }}>Baréin</option>
                                            <option value="Bélgica" {{ old('pais') == 'Bélgica' ? 'selected' : '' }}>Bélgica</option>
                                            <option value="Belice" {{ old('pais') == 'Belice' ? 'selected' : '' }}>Belice</option>
                                            <option value="Benín" {{ old('pais') == 'Benín' ? 'selected' : '' }}>Benín</option>
                                            <option value="Bielorrusia" {{ old('pais') == 'Bielorrusia' ? 'selected' : '' }}>Bielorrusia</option>
                                            <option value="Birmania" {{ old('pais') == 'Birmania' ? 'selected' : '' }}>Birmania</option>
                                            <option value="Bolivia" {{ old('pais') == 'Bolivia' ? 'selected' : '' }}>Bolivia</option>
                                            <option value="Bosnia y Herzegovina" {{ old('pais') == 'Bosnia y Herzegovina' ? 'selected' : '' }}>Bosnia y Herzegovina</option>
                                            <option value="Botsuana" {{ old('pais') == 'Botsuana' ? 'selected' : '' }}>Botsuana</option>
                                            <option value="Brasil" {{ old('pais') == 'Brasil' ? 'selected' : '' }}>Brasil</option>
                                            <option value="Brunéi" {{ old('pais') == 'Brunéi' ? 'selected' : '' }}>Brunéi</option>
                                            <option value="Bulgaria" {{ old('pais') == 'Bulgaria' ? 'selected' : '' }}>Bulgaria</option>
                                            <option value="Burkina Faso" {{ old('pais') == 'Burkina Faso' ? 'selected' : '' }}>Burkina Faso</option>
                                            <option value="Burundi" {{ old('pais') == 'Burundi' ? 'selected' : '' }}>Burundi</option>
                                            <option value="Bután" {{ old('pais') == 'Bután' ? 'selected' : '' }}>Bután</option>
                                            <option value="Cabo Verde" {{ old('pais') == 'Cabo Verde' ? 'selected' : '' }}>Cabo Verde</option>
                                            <option value="Camboya" {{ old('pais') == 'Camboya' ? 'selected' : '' }}>Camboya</option>
                                            <option value="Camerún" {{ old('pais') == 'Camerún' ? 'selected' : '' }}>Camerún</option>
                                            <option value="Canadá" {{ old('pais') == 'Canadá' ? 'selected' : '' }}>Canadá</option>
                                            <option value="Catar" {{ old('pais') == 'Catar' ? 'selected' : '' }}>Catar</option>
                                            <option value="Chad" {{ old('pais') == 'Chad' ? 'selected' : '' }}>Chad</option>
                                            <option value="Chile" {{ old('pais') == 'Chile' ? 'selected' : '' }}>Chile</option>
                                            <option value="China" {{ old('pais') == 'China' ? 'selected' : '' }}>China</option>
                                            <option value="Chipre" {{ old('pais') == 'Chipre' ? 'selected' : '' }}>Chipre</option>
                                            <option value="Colombia" {{ old('pais') == 'Colombia' ? 'selected' : '' }}>Colombia</option>
                                            <option value="Comoras" {{ old('pais') == 'Comoras' ? 'selected' : '' }}>Comoras</option>
                                            <option value="Corea del Norte" {{ old('pais') == 'Corea del Norte' ? 'selected' : '' }}>Corea del Norte</option>
                                            <option value="Corea del Sur" {{ old('pais') == 'Corea del Sur' ? 'selected' : '' }}>Corea del Sur</option>
                                            <option value="Costa de Marfil" {{ old('pais') == 'Costa de Marfil' ? 'selected' : '' }}>Costa de Marfil</option>
                                            <option value="Costa Rica" {{ old('pais') == 'Costa Rica' ? 'selected' : '' }}>Costa Rica</option>
                                            <option value="Croacia" {{ old('pais') == 'Croacia' ? 'selected' : '' }}>Croacia</option>
                                            <option value="Cuba" {{ old('pais') == 'Cuba' ? 'selected' : '' }}>Cuba</option>
                                            <option value="Dinamarca" {{ old('pais') == 'Dinamarca' ? 'selected' : '' }}>Dinamarca</option>
                                            <option value="Dominica" {{ old('pais') == 'Dominica' ? 'selected' : '' }}>Dominica</option>
                                            <option value="Ecuador" {{ old('pais') == 'Ecuador' ? 'selected' : '' }}>Ecuador</option>
                                            <option value="Egipto" {{ old('pais') == 'Egipto' ? 'selected' : '' }}>Egipto</option>
                                            <option value="El Salvador" {{ old('pais') == 'El Salvador' ? 'selected' : '' }}>El Salvador</option>
                                            <option value="Emiratos Árabes Unidos" {{ old('pais') == 'Emiratos Árabes Unidos' ? 'selected' : '' }}>Emiratos Árabes Unidos</option>
                                            <option value="Eritrea" {{ old('pais') == 'Eritrea' ? 'selected' : '' }}>Eritrea</option>
                                            <option value="Eslovaquia" {{ old('pais') == 'Eslovaquia' ? 'selected' : '' }}>Eslovaquia</option>
                                            <option value="Eslovenia" {{ old('pais') == 'Eslovenia' ? 'selected' : '' }}>Eslovenia</option>
                                            <option value="España" {{ old('pais') == 'España' ? 'selected' : '' }}>España</option>
                                            <option value="Estados Unidos" {{ old('pais') == 'Estados Unidos' ? 'selected' : '' }}>Estados Unidos</option>
                                            <option value="Estonia" {{ old('pais') == 'Estonia' ? 'selected' : '' }}>Estonia</option>
                                            <option value="Etiopía" {{ old('pais') == 'Etiopía' ? 'selected' : '' }}>Etiopía</option>
                                            <option value="Filipinas" {{ old('pais') == 'Filipinas' ? 'selected' : '' }}>Filipinas</option>
                                            <option value="Finlandia" {{ old('pais') == 'Finlandia' ? 'selected' : '' }}>Finlandia</option>
                                            <option value="Fiyi" {{ old('pais') == 'Fiyi' ? 'selected' : '' }}>Fiyi</option>
                                            <option value="Francia" {{ old('pais') == 'Francia' ? 'selected' : '' }}>Francia</option>
                                            <option value="Gabón" {{ old('pais') == 'Gabón' ? 'selected' : '' }}>Gabón</option>
                                            <option value="Gambia" {{ old('pais') == 'Gambia' ? 'selected' : '' }}>Gambia</option>
                                            <option value="Georgia" {{ old('pais') == 'Georgia' ? 'selected' : '' }}>Georgia</option>
                                            <option value="Ghana" {{ old('pais') == 'Ghana' ? 'selected' : '' }}>Ghana</option>
                                            <option value="Granada" {{ old('pais') == 'Granada' ? 'selected' : '' }}>Granada</option>
                                            <option value="Grecia" {{ old('pais') == 'Grecia' ? 'selected' : '' }}>Grecia</option>
                                            <option value="Guatemala" {{ old('pais') == 'Guatemala' ? 'selected' : '' }}>Guatemala</option>
                                            <option value="Guinea" {{ old('pais') == 'Guinea' ? 'selected' : '' }}>Guinea</option>
                                            <option value="Guinea Ecuatorial" {{ old('pais') == 'Guinea Ecuatorial' ? 'selected' : '' }}>Guinea Ecuatorial</option>
                                            <option value="Guinea-Bisáu" {{ old('pais') == 'Guinea-Bisáu' ? 'selected' : '' }}>Guinea-Bisáu</option>
                                            <option value="Guyana" {{ old('pais') == 'Guyana' ? 'selected' : '' }}>Guyana</option>
                                            <option value="Haití" {{ old('pais') == 'Haití' ? 'selected' : '' }}>Haití</option>
                                            <option value="Honduras" {{ old('pais') == 'Honduras' ? 'selected' : '' }}>Honduras</option>
                                            <option value="Hungría" {{ old('pais') == 'Hungría' ? 'selected' : '' }}>Hungría</option>
                                            <option value="India" {{ old('pais') == 'India' ? 'selected' : '' }}>India</option>
                                            <option value="Indonesia" {{ old('pais') == 'Indonesia' ? 'selected' : '' }}>Indonesia</option>
                                            <option value="Irak" {{ old('pais') == 'Irak' ? 'selected' : '' }}>Irak</option>
                                            <option value="Irán" {{ old('pais') == 'Irán' ? 'selected' : '' }}>Irán</option>
                                            <option value="Irlanda" {{ old('pais') == 'Irlanda' ? 'selected' : '' }}>Irlanda</option>
                                            <option value="Islandia" {{ old('pais') == 'Islandia' ? 'selected' : '' }}>Islandia</option>
                                            <option value="Islas Marshall" {{ old('pais') == 'Islas Marshall' ? 'selected' : '' }}>Islas Marshall</option>
                                            <option value="Islas Salomón" {{ old('pais') == 'Islas Salomón' ? 'selected' : '' }}>Islas Salomón</option>
                                            <option value="Israel" {{ old('pais') == 'Israel' ? 'selected' : '' }}>Israel</option>
                                            <option value="Italia" {{ old('pais') == 'Italia' ? 'selected' : '' }}>Italia</option>
                                            <option value="Jamaica" {{ old('pais') == 'Jamaica' ? 'selected' : '' }}>Jamaica</option>
                                            <option value="Japón" {{ old('pais') == 'Japón' ? 'selected' : '' }}>Japón</option>
                                            <option value="Jordania" {{ old('pais') == 'Jordania' ? 'selected' : '' }}>Jordania</option>
                                            <option value="Kazajistán" {{ old('pais') == 'Kazajistán' ? 'selected' : '' }}>Kazajistán</option>
                                            <option value="Kenia" {{ old('pais') == 'Kenia' ? 'selected' : '' }}>Kenia</option>
                                            <option value="Kirguistán" {{ old('pais') == 'Kirguistán' ? 'selected' : '' }}>Kirguistán</option>
                                            <option value="Kiribati" {{ old('pais') == 'Kiribati' ? 'selected' : '' }}>Kiribati</option>
                                            <option value="Kuwait" {{ old('pais') == 'Kuwait' ? 'selected' : '' }}>Kuwait</option>
                                            <option value="Laos" {{ old('pais') == 'Laos' ? 'selected' : '' }}>Laos</option>
                                            <option value="Lesoto" {{ old('pais') == 'Lesoto' ? 'selected' : '' }}>Lesoto</option>
                                            <option value="Letonia" {{ old('pais') == 'Letonia' ? 'selected' : '' }}>Letonia</option>
                                            <option value="Líbano" {{ old('pais') == 'Líbano' ? 'selected' : '' }}>Líbano</option>
                                            <option value="Liberia" {{ old('pais') == 'Liberia' ? 'selected' : '' }}>Liberia</option>
                                            <option value="Libia" {{ old('pais') == 'Libia' ? 'selected' : '' }}>Libia</option>
                                            <option value="Liechtenstein" {{ old('pais') == 'Liechtenstein' ? 'selected' : '' }}>Liechtenstein</option>
                                            <option value="Lituania" {{ old('pais') == 'Lituania' ? 'selected' : '' }}>Lituania</option>
                                            <option value="Luxemburgo" {{ old('pais') == 'Luxemburgo' ? 'selected' : '' }}>Luxemburgo</option>
                                            <option value="Macedonia del Norte" {{ old('pais') == 'Macedonia del Norte' ? 'selected' : '' }}>Macedonia del Norte</option>
                                            <option value="Madagascar" {{ old('pais') == 'Madagascar' ? 'selected' : '' }}>Madagascar</option>
                                            <option value="Malasia" {{ old('pais') == 'Malasia' ? 'selected' : '' }}>Malasia</option>
                                            <option value="Malaui" {{ old('pais') == 'Malaui' ? 'selected' : '' }}>Malaui</option>
                                            <option value="Maldivas" {{ old('pais') == 'Maldivas' ? 'selected' : '' }}>Maldivas</option>
                                            <option value="Malí" {{ old('pais') == 'Malí' ? 'selected' : '' }}>Malí</option>
                                            <option value="Malta" {{ old('pais') == 'Malta' ? 'selected' : '' }}>Malta</option>
                                            <option value="Marruecos" {{ old('pais') == 'Marruecos' ? 'selected' : '' }}>Marruecos</option>
                                            <option value="Mauricio" {{ old('pais') == 'Mauricio' ? 'selected' : '' }}>Mauricio</option>
                                            <option value="Mauritania" {{ old('pais') == 'Mauritania' ? 'selected' : '' }}>Mauritania</option>
                                            <option value="México" {{ old('pais') == 'México' ? 'selected' : '' }}>México</option>
                                            <option value="Micronesia" {{ old('pais') == 'Micronesia' ? 'selected' : '' }}>Micronesia</option>
                                            <option value="Moldavia" {{ old('pais') == 'Moldavia' ? 'selected' : '' }}>Moldavia</option>
                                            <option value="Mónaco" {{ old('pais') == 'Mónaco' ? 'selected' : '' }}>Mónaco</option>
                                            <option value="Mongolia" {{ old('pais') == 'Mongolia' ? 'selected' : '' }}>Mongolia</option>
                                            <option value="Montenegro" {{ old('pais') == 'Montenegro' ? 'selected' : '' }}>Montenegro</option>
                                            <option value="Mozambique" {{ old('pais') == 'Mozambique' ? 'selected' : '' }}>Mozambique</option>
                                            <option value="Namibia" {{ old('pais') == 'Namibia' ? 'selected' : '' }}>Namibia</option>
                                            <option value="Nauru" {{ old('pais') == 'Nauru' ? 'selected' : '' }}>Nauru</option>
                                            <option value="Nepal" {{ old('pais') == 'Nepal' ? 'selected' : '' }}>Nepal</option>
                                            <option value="Nicaragua" {{ old('pais') == 'Nicaragua' ? 'selected' : '' }}>Nicaragua</option>
                                            <option value="Níger" {{ old('pais') == 'Níger' ? 'selected' : '' }}>Níger</option>
                                            <option value="Nigeria" {{ old('pais') == 'Nigeria' ? 'selected' : '' }}>Nigeria</option>
                                            <option value="Noruega" {{ old('pais') == 'Noruega' ? 'selected' : '' }}>Noruega</option>
                                            <option value="Nueva Zelanda" {{ old('pais') == 'Nueva Zelanda' ? 'selected' : '' }}>Nueva Zelanda</option>
                                            <option value="Omán" {{ old('pais') == 'Omán' ? 'selected' : '' }}>Omán</option>
                                            <option value="Países Bajos" {{ old('pais') == 'Países Bajos' ? 'selected' : '' }}>Países Bajos</option>
                                            <option value="Pakistán" {{ old('pais') == 'Pakistán' ? 'selected' : '' }}>Pakistán</option>
                                            <option value="Palaos" {{ old('pais') == 'Palaos' ? 'selected' : '' }}>Palaos</option>
                                            <option value="Panamá" {{ old('pais') == 'Panamá' ? 'selected' : '' }}>Panamá</option>
                                            <option value="Papúa Nueva Guinea" {{ old('pais') == 'Papúa Nueva Guinea' ? 'selected' : '' }}>Papúa Nueva Guinea</option>
                                            <option value="Paraguay" {{ old('pais') == 'Paraguay' ? 'selected' : '' }}>Paraguay</option>
                                            <option value="Perú" {{ old('pais', 'Perú') == 'Perú' ? 'selected' : '' }}>Perú</option>
                                            <option value="Polonia" {{ old('pais') == 'Polonia' ? 'selected' : '' }}>Polonia</option>
                                            <option value="Portugal" {{ old('pais') == 'Portugal' ? 'selected' : '' }}>Portugal</option>
                                            <option value="Reino Unido" {{ old('pais') == 'Reino Unido' ? 'selected' : '' }}>Reino Unido</option>
                                            <option value="República Centroafricana" {{ old('pais') == 'República Centroafricana' ? 'selected' : '' }}>República Centroafricana</option>
                                            <option value="República Checa" {{ old('pais') == 'República Checa' ? 'selected' : '' }}>República Checa</option>
                                            <option value="República del Congo" {{ old('pais') == 'República del Congo' ? 'selected' : '' }}>República del Congo</option>
                                            <option value="República Democrática del Congo" {{ old('pais') == 'República Democrática del Congo' ? 'selected' : '' }}>República Democrática del Congo</option>
                                            <option value="República Dominicana" {{ old('pais') == 'República Dominicana' ? 'selected' : '' }}>República Dominicana</option>
                                            <option value="Ruanda" {{ old('pais') == 'Ruanda' ? 'selected' : '' }}>Ruanda</option>
                                            <option value="Rumania" {{ old('pais') == 'Rumania' ? 'selected' : '' }}>Rumania</option>
                                            <option value="Rusia" {{ old('pais') == 'Rusia' ? 'selected' : '' }}>Rusia</option>
                                            <option value="Samoa" {{ old('pais') == 'Samoa' ? 'selected' : '' }}>Samoa</option>
                                            <option value="San Cristóbal y Nieves" {{ old('pais') == 'San Cristóbal y Nieves' ? 'selected' : '' }}>San Cristóbal y Nieves</option>
                                            <option value="San Marino" {{ old('pais') == 'San Marino' ? 'selected' : '' }}>San Marino</option>
                                            <option value="San Vicente y las Granadinas" {{ old('pais') == 'San Vicente y las Granadinas' ? 'selected' : '' }}>San Vicente y las Granadinas</option>
                                            <option value="Santa Lucía" {{ old('pais') == 'Santa Lucía' ? 'selected' : '' }}>Santa Lucía</option>
                                            <option value="Santo Tomé y Príncipe" {{ old('pais') == 'Santo Tomé y Príncipe' ? 'selected' : '' }}>Santo Tomé y Príncipe</option>
                                            <option value="Senegal" {{ old('pais') == 'Senegal' ? 'selected' : '' }}>Senegal</option>
                                            <option value="Serbia" {{ old('pais') == 'Serbia' ? 'selected' : '' }}>Serbia</option>
                                            <option value="Seychelles" {{ old('pais') == 'Seychelles' ? 'selected' : '' }}>Seychelles</option>
                                            <option value="Sierra Leona" {{ old('pais') == 'Sierra Leona' ? 'selected' : '' }}>Sierra Leona</option>
                                            <option value="Singapur" {{ old('pais') == 'Singapur' ? 'selected' : '' }}>Singapur</option>
                                            <option value="Siria" {{ old('pais') == 'Siria' ? 'selected' : '' }}>Siria</option>
                                            <option value="Somalia" {{ old('pais') == 'Somalia' ? 'selected' : '' }}>Somalia</option>
                                            <option value="Sri Lanka" {{ old('pais') == 'Sri Lanka' ? 'selected' : '' }}>Sri Lanka</option>
                                            <option value="Suazilandia" {{ old('pais') == 'Suazilandia' ? 'selected' : '' }}>Suazilandia</option>
                                            <option value="Sudáfrica" {{ old('pais') == 'Sudáfrica' ? 'selected' : '' }}>Sudáfrica</option>
                                            <option value="Sudán" {{ old('pais') == 'Sudán' ? 'selected' : '' }}>Sudán</option>
                                            <option value="Sudán del Sur" {{ old('pais') == 'Sudán del Sur' ? 'selected' : '' }}>Sudán del Sur</option>
                                            <option value="Suecia" {{ old('pais') == 'Suecia' ? 'selected' : '' }}>Suecia</option>
                                            <option value="Suiza" {{ old('pais') == 'Suiza' ? 'selected' : '' }}>Suiza</option>
                                            <option value="Surinam" {{ old('pais') == 'Surinam' ? 'selected' : '' }}>Surinam</option>
                                            <option value="Tailandia" {{ old('pais') == 'Tailandia' ? 'selected' : '' }}>Tailandia</option>
                                            <option value="Tanzania" {{ old('pais') == 'Tanzania' ? 'selected' : '' }}>Tanzania</option>
                                            <option value="Tayikistán" {{ old('pais') == 'Tayikistán' ? 'selected' : '' }}>Tayikistán</option>
                                            <option value="Timor Oriental" {{ old('pais') == 'Timor Oriental' ? 'selected' : '' }}>Timor Oriental</option>
                                            <option value="Togo" {{ old('pais') == 'Togo' ? 'selected' : '' }}>Togo</option>
                                            <option value="Tonga" {{ old('pais') == 'Tonga' ? 'selected' : '' }}>Tonga</option>
                                            <option value="Trinidad y Tobago" {{ old('pais') == 'Trinidad y Tobago' ? 'selected' : '' }}>Trinidad y Tobago</option>
                                            <option value="Túnez" {{ old('pais') == 'Túnez' ? 'selected' : '' }}>Túnez</option>
                                            <option value="Turkmenistán" {{ old('pais') == 'Turkmenistán' ? 'selected' : '' }}>Turkmenistán</option>
                                            <option value="Turquía" {{ old('pais') == 'Turquía' ? 'selected' : '' }}>Turquía</option>
                                            <option value="Tuvalu" {{ old('pais') == 'Tuvalu' ? 'selected' : '' }}>Tuvalu</option>
                                            <option value="Ucrania" {{ old('pais') == 'Ucrania' ? 'selected' : '' }}>Ucrania</option>
                                            <option value="Uganda" {{ old('pais') == 'Uganda' ? 'selected' : '' }}>Uganda</option>
                                            <option value="Uruguay" {{ old('pais') == 'Uruguay' ? 'selected' : '' }}>Uruguay</option>
                                            <option value="Uzbekistán" {{ old('pais') == 'Uzbekistán' ? 'selected' : '' }}>Uzbekistán</option>
                                            <option value="Vanuatu" {{ old('pais') == 'Vanuatu' ? 'selected' : '' }}>Vanuatu</option>
                                            <option value="Vaticano" {{ old('pais') == 'Vaticano' ? 'selected' : '' }}>Vaticano</option>
                                            <option value="Venezuela" {{ old('pais') == 'Venezuela' ? 'selected' : '' }}>Venezuela</option>
                                            <option value="Vietnam" {{ old('pais') == 'Vietnam' ? 'selected' : '' }}>Vietnam</option>
                                            <option value="Yemen" {{ old('pais') == 'Yemen' ? 'selected' : '' }}>Yemen</option>
                                            <option value="Yibuti" {{ old('pais') == 'Yibuti' ? 'selected' : '' }}>Yibuti</option>
                                            <option value="Zambia" {{ old('pais') == 'Zambia' ? 'selected' : '' }}>Zambia</option>
                                            <option value="Zimbabue" {{ old('pais') == 'Zimbabue' ? 'selected' : '' }}>Zimbabue</option>
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
                                            <option value="Soltero(a)" {{ old('estado_civil') == 'Soltero(a)' ? 'selected' : '' }}>Soltero(a)</option>
                                            <option value="Casado(a)" {{ old('estado_civil') == 'Casado(a)' ? 'selected' : '' }}>Casado(a)</option>
                                            <option value="Divorciado(a)" {{ old('estado_civil') == 'Divorciado(a)' ? 'selected' : '' }}>Divorciado(a)</option>
                                            <option value="Viudo(a)" {{ old('estado_civil') == 'Viudo(a)' ? 'selected' : '' }}>Viudo(a)</option>
                                            <option value="Conviviente" {{ old('estado_civil') == 'Conviviente' ? 'selected' : '' }}>Conviviente</option>
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
                                              rows="2">{{ old('direccion') }}</textarea>
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
                                            <option value="dni" {{ old('tipo_documento') == 'dni' ? 'selected' : '' }}>DNI</option>
                                            <option value="ce" {{ old('tipo_documento') == 'ce' ? 'selected' : '' }}>Carnet de Extranjería</option>
                                            <option value="pasaporte" {{ old('tipo_documento') == 'pasaporte' ? 'selected' : '' }}>Pasaporte</option>
                                            <option value="ruc" {{ old('tipo_documento') == 'ruc' ? 'selected' : '' }}>RUC</option>
                                            <option value="otros" {{ old('tipo_documento') == 'otros' ? 'selected' : '' }}>Otros</option>
                                        </select>
                                        @error('tipo_documento')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="numero_documento" class="form-label">Número de Documento <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="text"
                                                   class="form-control @error('numero_documento') is-invalid @enderror"
                                                   id="numero_documento"
                                                   name="numero_documento"
                                                   value="{{ old('numero_documento') }}"
                                                   required>
                                            <button class="btn btn-outline-secondary" type="button" id="btn-consultar-reniec"
                                                    style="background-color: #dc2626; color: white; border-color: #dc2626;"
                                                    title="Consultar DNI en RENIEC Perú">
                                                <i class="fas fa-search"></i> RENIEC
                                            </button>
                                        </div>
                                        @error('numero_documento')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">
                                            <i class="fas fa-cloud"></i>
                                            Consultas disponibles hoy: <strong id="consultas-disponibles" class="text-success">-</strong>/100
                                        </small>
                                    </div>
                                </div>

                                <!-- Estado de consulta RENIEC -->
                                <div id="reniec-resultado" class="alert alert-dismissible fade" role="alert" style="display: none;">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    <div id="reniec-mensaje"></div>
                                </div>

                                <div class="alert alert-info"
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
                                               value="{{ old('celular') }}">
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
                                               value="{{ old('correo') }}">
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

/**
 * ============================================
 * FUNCIONES DE RENIEC
 * ============================================
 */

/**
 * Cargar consultas disponibles desde la API
 */
function cargarConsultasDisponibles() {
    fetch('{{ route("reniec.disponibles") }}')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const consultasElement = document.getElementById('consultas-disponibles');
                if (consultasElement) {
                    consultasElement.textContent = data.consultas_disponibles;
                    
                    // Cambiar color según disponibilidad
                    if (data.consultas_disponibles <= 10) {
                        consultasElement.className = 'text-danger';
                    } else if (data.consultas_disponibles <= 30) {
                        consultasElement.className = 'text-warning';
                    } else {
                        consultasElement.className = 'text-success';
                    }
                }
            }
        })
        .catch(error => {
            console.error('Error al cargar consultas:', error);
            const consultasElement = document.getElementById('consultas-disponibles');
            if (consultasElement) {
                consultasElement.textContent = '?';
            }
        });
}

/**
 * Consultar DNI en RENIEC Perú
 */
function consultarReniec() {
    console.log('consultarReniec llamada'); // Debug
    
    const numeroDocumento = document.getElementById('numero_documento').value;
    const tipoDocumento = document.getElementById('tipo_documento').value;
    const btnConsultar = document.getElementById('btn-consultar-reniec');
    
    console.log('DNI:', numeroDocumento, 'Tipo:', tipoDocumento); // Debug

    // Validar tipo de documento
    if (tipoDocumento !== 'dni') {
        mostrarMensajeReniec('warning', 'Por favor selecciona "DNI" como tipo de documento para consultar RENIEC.');
        return;
    }

    // Validar DNI (8 dígitos)
    if (!/^\d{8}$/.test(numeroDocumento)) {
        mostrarMensajeReniec('warning', 'El DNI debe tener exactamente 8 dígitos.');
        return;
    }

    // Deshabilitar botón
    btnConsultar.disabled = true;
    btnConsultar.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Consultando...';

    // Realizar consulta
    fetch('{{ route("reniec.consultar") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            dni: numeroDocumento
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log('Respuesta:', data); // Debug
        
        if (data.success && data.data) {
            // Rellenar campos con los datos obtenidos
            document.getElementById('nombres').value = data.data.nombres || '';
            document.getElementById('apellidos').value = 
                (data.data.apellido_paterno || '') + ' ' + (data.data.apellido_materno || '');

            // Intentar rellenar sexo si está disponible
            if (data.data.sexo) {
                const sexoSelect = document.getElementById('sexo');
                if (sexoSelect) {
                    const sexoNormalizado = data.data.sexo.toLowerCase();
                    if (sexoNormalizado === 'm' || sexoNormalizado === 'masculino' || sexoNormalizado === 'hombre') {
                        sexoSelect.value = 'M';
                    } else if (sexoNormalizado === 'f' || sexoNormalizado === 'femenino' || sexoNormalizado === 'mujer') {
                        sexoSelect.value = 'F';
                    }
                }
            }

            // Intentar rellenar fecha de nacimiento si está disponible
            if (data.data.fecha_nacimiento) {
                const fechaNacimientoInput = document.getElementById('fecha_nacimiento');
                if (fechaNacimientoInput) {
                    // Convertir formato si es necesario (ej: dd/mm/yyyy a yyyy-mm-dd)
                    const fecha = data.data.fecha_nacimiento;
                    if (fecha.includes('/')) {
                        const partes = fecha.split('/');
                        if (partes.length === 3) {
                            fechaNacimientoInput.value = `${partes[2]}-${partes[1]}-${partes[0]}`;
                        }
                    } else {
                        fechaNacimientoInput.value = fecha;
                    }
                }
            }

            // Mensaje de éxito
            let mensajeExtra = '';
            if (!data.data.sexo || !data.data.fecha_nacimiento) {
                const camposFaltantes = [];
                if (!data.data.sexo) camposFaltantes.push('sexo');
                if (!data.data.fecha_nacimiento) camposFaltantes.push('fecha de nacimiento');
                mensajeExtra = `<br><small class="text-warning"><i class="fas fa-info-circle"></i> 
                    Por favor, completa manualmente: ${camposFaltantes.join(' y ')}</small>`;
            }

            mostrarMensajeReniec('success', 
                `<strong><i class="fas fa-check-circle"></i> ¡Consulta Exitosa!</strong><br>
                Se encontró: <strong>${data.data.nombre_completo}</strong>${mensajeExtra}`
            );

            // Actualizar contador
            const consultasElement = document.getElementById('consultas-disponibles');
            if (consultasElement && data.consultas_disponibles !== undefined) {
                consultasElement.textContent = data.consultas_disponibles;
            }
        } else {
            mostrarMensajeReniec('danger', 
                `<strong><i class="fas fa-exclamation-triangle"></i> Error</strong><br>
                ${data.message || 'No se pudo consultar el DNI'}`
            );
        }
    })
    .catch(error => {
        console.error('Error:', error);
        mostrarMensajeReniec('danger', 
            `<strong><i class="fas fa-times-circle"></i> Error de conexión</strong><br>
            No se pudo conectar con el servicio RENIEC. Por favor, intenta nuevamente.`
        );
    })
    .finally(() => {
        // Rehabilitar botón
        btnConsultar.disabled = false;
        btnConsultar.innerHTML = '<i class="fas fa-search"></i> RENIEC';
        
        // Recargar contador de consultas
        cargarConsultasDisponibles();
    });
}

/**
 * Mostrar mensaje de resultado de consulta RENIEC
 */
function mostrarMensajeReniec(tipo, mensaje) {
    const resultadoDiv = document.getElementById('reniec-resultado');
    const mensajeDiv = document.getElementById('reniec-mensaje');
    
    if (resultadoDiv && mensajeDiv) {
        resultadoDiv.className = `alert alert-${tipo} alert-dismissible fade show`;
        mensajeDiv.innerHTML = mensaje;
        resultadoDiv.style.display = 'block';
        
        // Auto-ocultar después de 5 segundos
        setTimeout(() => {
            resultadoDiv.classList.remove('show');
            setTimeout(() => {
                resultadoDiv.style.display = 'none';
            }, 300);
        }, 5000);
    }
}

// Auto-ocultar mensajes de error después de 3 segundos
document.addEventListener('DOMContentLoaded', function() {
    const errorMessages = document.querySelectorAll('.invalid-feedback');
    
    // Auto-ocultar mensajes de error
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

    // Cargar contador de consultas disponibles
    cargarConsultasDisponibles();

    // Configurar botón de consulta RENIEC
    const btnConsultarReniec = document.getElementById('btn-consultar-reniec');
    const numeroDocumentoInput = document.getElementById('numero_documento');
    const tipoDocumentoSelect = document.getElementById('tipo_documento');

    console.log('Botón RENIEC encontrado:', btnConsultarReniec); // Debug

    if (btnConsultarReniec) {
        btnConsultarReniec.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Click en botón RENIEC'); // Debug
            consultarReniec();
        });
    }

    // Permitir consulta con Enter en el campo de documento
    if (numeroDocumentoInput) {
        numeroDocumentoInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter' && tipoDocumentoSelect.value === 'dni') {
                e.preventDefault();
                consultarReniec();
            }
        });
    }
});
</script>
@endpush
@endsection
