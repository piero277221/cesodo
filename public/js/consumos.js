// Agregar este script al final del archivo o en una sección de scripts
document.addEventListener('DOMContentLoaded', function() {
    // Manejo de selección de tipo de comida
    const tipoComidaOptions = document.querySelectorAll('.tipo-comida-option');
    const tipoComidaInputs = document.querySelectorAll('input[name="tipo_comida"]');

    tipoComidaInputs.forEach(input => {
        input.addEventListener('change', function() {
            // Remover clase seleccionada de todas las opciones
            tipoComidaOptions.forEach(opt => {
                opt.classList.remove('border-indigo-500', 'bg-indigo-50');
            });

            // Agregar clase seleccionada a la opción elegida
            if (this.checked) {
                this.parentElement.querySelector('.tipo-comida-option').classList.add(
                    'border-indigo-500',
                    'bg-indigo-50'
                );
            }
        });
    });
});
