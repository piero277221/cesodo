/**
 * Mejoras de UX/UI para CESODO2
 * Archivo de JavaScript para animaciones y interacciones modernas
 */

document.addEventListener('DOMContentLoaded', function() {

    // Inicializar todas las mejoras
    initModernInteractions();
    initAnimations();
    initTooltips();
    initSmartTables();
    initFormEnhancements();

    console.log('✨ CESODO2 Modern UI iniciado correctamente');
});

/**
 * Inicializar interacciones modernas
 */
function initModernInteractions() {
    // Efecto de loading en botones
    document.querySelectorAll('.btn').forEach(button => {
        button.addEventListener('click', function() {
            if (this.type === 'submit' || this.classList.contains('btn-loading')) {
                this.classList.add('loading');

                // Quitar loading después de 2 segundos si no se hace submit
                setTimeout(() => {
                    this.classList.remove('loading');
                }, 2000);
            }
        });
    });

    // Hover effects mejorados para cards
    document.querySelectorAll('.card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px) scale(1.02)';
            this.style.boxShadow = '0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)';
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
            this.style.boxShadow = '0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)';
        });
    });

    // Mejorar selects
    document.querySelectorAll('.form-select').forEach(select => {
        select.addEventListener('focus', function() {
            this.parentElement.style.transform = 'scale(1.02)';
        });

        select.addEventListener('blur', function() {
            this.parentElement.style.transform = 'scale(1)';
        });
    });
}

/**
 * Inicializar animaciones de entrada
 */
function initAnimations() {
    // Animación de fade-in para elementos
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in-up');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Observar elementos que deben animarse
    document.querySelectorAll('.card, .btn-group, .alert').forEach(el => {
        observer.observe(el);
    });

    // Animación de contadores
    animateCounters();
}

/**
 * Animar contadores numéricos
 */
function animateCounters() {
    document.querySelectorAll('.h4').forEach(counter => {
        const target = parseInt(counter.textContent);
        if (!isNaN(target)) {
            counter.textContent = '0';
            const increment = target / 50;
            const timer = setInterval(() => {
                const current = parseInt(counter.textContent);
                if (current < target) {
                    counter.textContent = Math.ceil(current + increment);
                } else {
                    counter.textContent = target;
                    clearInterval(timer);
                }
            }, 20);
        }
    });
}

/**
 * Inicializar tooltips
 */
function initTooltips() {
    // Inicializar tooltips de Bootstrap
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Agregar tooltips automáticos a botones con iconos
    document.querySelectorAll('.btn[title]').forEach(btn => {
        new bootstrap.Tooltip(btn);
    });
}

/**
 * Mejorar tablas con funcionalidades inteligentes
 */
function initSmartTables() {
    document.querySelectorAll('.table').forEach(table => {
        // Agregar efecto de hover mejorado
        table.querySelectorAll('tbody tr').forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.style.backgroundColor = '#f8fafc';
                this.style.transform = 'scale(1.01)';
                this.style.boxShadow = '0 4px 6px -1px rgba(0, 0, 0, 0.1)';
            });

            row.addEventListener('mouseleave', function() {
                this.style.backgroundColor = '';
                this.style.transform = 'scale(1)';
                this.style.boxShadow = '';
            });
        });

        // Ordenamiento visual de columnas
        table.querySelectorAll('thead th').forEach(header => {
            header.style.cursor = 'pointer';
            header.addEventListener('click', function() {
                // Efecto visual de ordenamiento
                this.style.backgroundColor = '#667eea';
                this.style.color = 'white';

                setTimeout(() => {
                    this.style.backgroundColor = '';
                    this.style.color = '';
                }, 300);
            });
        });
    });
}

/**
 * Mejoras en formularios
 */
function initFormEnhancements() {
    // Efecto focus mejorado en inputs
    document.querySelectorAll('.form-control, .form-select').forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.style.transform = 'scale(1.02)';
            this.style.borderColor = '#667eea';
            this.style.boxShadow = '0 0 0 3px rgba(102, 126, 234, 0.1)';
        });

        input.addEventListener('blur', function() {
            this.parentElement.style.transform = 'scale(1)';
            this.style.borderColor = '';
            this.style.boxShadow = '';
        });
    });

    // Validación visual mejorada
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function(e) {
            const inputs = this.querySelectorAll('.form-control[required], .form-select[required]');
            let isValid = true;

            inputs.forEach(input => {
                if (!input.value.trim()) {
                    input.style.borderColor = '#ef4444';
                    input.style.animation = 'shake 0.5s ease-in-out';
                    isValid = false;

                    setTimeout(() => {
                        input.style.animation = '';
                    }, 500);
                } else {
                    input.style.borderColor = '#10b981';
                }
            });

            if (!isValid) {
                e.preventDefault();
                showNotification('Por favor, completa todos los campos requeridos', 'error');
            }
        });
    });
}

/**
 * Sistema de notificaciones modernas
 */
function showNotification(message, type = 'info', duration = 5000) {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type} notification-modern`;
    notification.innerHTML = `
        <div class="d-flex align-items-center">
            <i class="fas fa-${getIconForType(type)} me-2"></i>
            <span>${message}</span>
            <button type="button" class="btn-close ms-auto" onclick="this.parentElement.parentElement.remove()"></button>
        </div>
    `;

    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 1060;
        min-width: 300px;
        border: none;
        border-radius: 0.75rem;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        animation: slideInRight 0.3s ease-out;
    `;

    document.body.appendChild(notification);

    setTimeout(() => {
        notification.style.animation = 'slideOutRight 0.3s ease-in';
        setTimeout(() => notification.remove(), 300);
    }, duration);
}

function getIconForType(type) {
    const icons = {
        'success': 'check-circle',
        'error': 'exclamation-triangle',
        'warning': 'exclamation-triangle',
        'info': 'info-circle'
    };
    return icons[type] || 'info-circle';
}

/**
 * Mejoras en la navegación
 */
function enhanceNavigation() {
    const nav = document.querySelector('.horizontal-nav');
    if (nav) {
        // Mejorar scroll horizontal
        let isDown = false;
        let startX;
        let scrollLeft;

        nav.addEventListener('mousedown', (e) => {
            isDown = true;
            startX = e.pageX - nav.offsetLeft;
            scrollLeft = nav.scrollLeft;
            nav.style.cursor = 'grabbing';
        });

        nav.addEventListener('mouseleave', () => {
            isDown = false;
            nav.style.cursor = 'grab';
        });

        nav.addEventListener('mouseup', () => {
            isDown = false;
            nav.style.cursor = 'grab';
        });

        nav.addEventListener('mousemove', (e) => {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX - nav.offsetLeft;
            const walk = (x - startX) * 2;
            nav.scrollLeft = scrollLeft - walk;
        });
    }
}

/**
 * Tema oscuro automático
 */
function initThemeToggle() {
    // Detectar preferencia del usuario
    if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
        document.body.classList.add('dark-mode');
    }

    // Escuchar cambios en la preferencia
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
        if (e.matches) {
            document.body.classList.add('dark-mode');
        } else {
            document.body.classList.remove('dark-mode');
        }
    });
}

/**
 * Utilidades adicionales
 */
const CesodoUtils = {
    // Formatear números
    formatNumber: (num) => {
        return new Intl.NumberFormat('es-PE').format(num);
    },

    // Formatear fechas
    formatDate: (date) => {
        return new Intl.DateTimeFormat('es-PE').format(new Date(date));
    },

    // Debounce para búsquedas
    debounce: (func, wait) => {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    },

    // Confirmar acciones peligrosas
    confirmDanger: (message, callback) => {
        if (confirm(`⚠️ ${message}\n\n¿Estás seguro de que deseas continuar?`)) {
            callback();
        }
    }
};

// Agregar animaciones CSS dinámicamente
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInRight {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }

    @keyframes slideOutRight {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(100%); opacity: 0; }
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }

    .notification-modern {
        backdrop-filter: blur(10px);
    }

    .loading::after {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
        animation: loading 1.5s infinite;
    }
`;
document.head.appendChild(style);

// Hacer disponibles las utilidades globalmente
window.CesodoUtils = CesodoUtils;
window.showNotification = showNotification;
