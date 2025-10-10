{{-- Componente de Campo de Formulario --}}
@props([
    'label' => '',
    'name' => '',
    'type' => 'text',
    'value' => '',
    'placeholder' => '',
    'required' => false,
    'readonly' => false,
    'disabled' => false,
    'help' => '',
    'icon' => '',
    'options' => [], // Para select
    'rows' => 4, // Para textarea
    'accept' => '', // Para file input
    'min' => '',
    'max' => '',
    'step' => ''
])

<div class="form-group">
    @if($label)
        <label for="{{ $name }}" class="form-label {{ $required ? 'required' : '' }}">
            @if($icon)<i class="{{ $icon }} me-1"></i>@endif
            {{ $label }}
        </label>
    @endif

    @if($type === 'select')
        <select
            name="{{ $name }}"
            id="{{ $name }}"
            class="form-select @error($name) is-invalid @enderror"
            {{ $required ? 'required' : '' }}
            {{ $disabled ? 'disabled' : '' }}
        >
            <option value="">{{ $placeholder ?: 'Seleccionar...' }}</option>
            @foreach($options as $key => $option)
                <option
                    value="{{ is_array($option) ? $option['value'] : $key }}"
                    {{ (old($name, $value) == (is_array($option) ? $option['value'] : $key)) ? 'selected' : '' }}
                >
                    {{ is_array($option) ? $option['label'] : $option }}
                </option>
            @endforeach
        </select>

    @elseif($type === 'textarea')
        <textarea
            name="{{ $name }}"
            id="{{ $name }}"
            class="form-textarea @error($name) is-invalid @enderror"
            rows="{{ $rows }}"
            placeholder="{{ $placeholder }}"
            {{ $required ? 'required' : '' }}
            {{ $readonly ? 'readonly' : '' }}
            {{ $disabled ? 'disabled' : '' }}
        >{{ old($name, $value) }}</textarea>

    @elseif($type === 'file')
        <input
            type="file"
            name="{{ $name }}"
            id="{{ $name }}"
            class="form-input @error($name) is-invalid @enderror"
            {{ $accept ? "accept={$accept}" : '' }}
            {{ $required ? 'required' : '' }}
            {{ $disabled ? 'disabled' : '' }}
        >

    @elseif($type === 'checkbox')
        <div class="form-check">
            <input
                type="checkbox"
                name="{{ $name }}"
                id="{{ $name }}"
                class="form-check-input @error($name) is-invalid @enderror"
                value="1"
                {{ old($name, $value) ? 'checked' : '' }}
                {{ $disabled ? 'disabled' : '' }}
            >
            <label class="form-check-label" for="{{ $name }}">
                {{ $label }}
            </label>
        </div>

    @else
        <div class="input-group">
            @if($icon)
                <span class="input-group-text">
                    <i class="{{ $icon }}"></i>
                </span>
            @endif

            <input
                type="{{ $type }}"
                name="{{ $name }}"
                id="{{ $name }}"
                class="form-input @error($name) is-invalid @enderror"
                value="{{ old($name, $value) }}"
                placeholder="{{ $placeholder }}"
                {{ $required ? 'required' : '' }}
                {{ $readonly ? 'readonly' : '' }}
                {{ $disabled ? 'disabled' : '' }}
                {{ $min ? "min={$min}" : '' }}
                {{ $max ? "max={$max}" : '' }}
                {{ $step ? "step={$step}" : '' }}
            >
        </div>
    @endif

    @if($help)
        <div class="form-help">
            <i class="bi bi-info-circle me-1"></i>
            {{ $help }}
        </div>
    @endif

    @error($name)
        <div class="form-error">
            <i class="bi bi-exclamation-triangle me-1"></i>
            {{ $message }}
        </div>
    @enderror
</div>
