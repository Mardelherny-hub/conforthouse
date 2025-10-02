/**
 * Manejo de formularios de contacto con AJAX
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // Seleccionar todos los formularios de contacto
    const forms = document.querySelectorAll('[data-contact-form]');
    
    forms.forEach(form => {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            
            // Deshabilitar botón y mostrar estado de carga
            submitBtn.disabled = true;
            submitBtn.textContent = 'Enviando...';
            
            // Obtener datos del formulario
            const formData = new FormData(form);
            const action = form.getAttribute('action');
            
            try {
                const response = await fetch(action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });
                
                const data = await response.json();
                
                if (data.success) {
                    // Mostrar mensaje de éxito
                    showNotification(data.message, 'success');
                    
                    // Limpiar formulario
                    form.reset();
                    
                    // Cerrar modal si existe
                    const modal = form.closest('[x-show]');
                    if (modal) {
                        // Buscar el botón de cerrar o disparar evento Alpine
                        const closeBtn = modal.querySelector('[x-on\\:click*="false"]');
                        if (closeBtn) closeBtn.click();
                    }
                    
                } else {
                    // Mostrar error
                    showNotification(data.message || 'Error al enviar el formulario', 'error');
                }
                
            } catch (error) {
                console.error('Error:', error);
                showNotification('Error al enviar el formulario. Por favor, inténtelo nuevamente.', 'error');
            } finally {
                // Rehabilitar botón
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            }
        });
    });
});

/**
 * Mostrar notificación toast
 */
function showNotification(message, type = 'success') {
    // Crear elemento de notificación
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 px-6 py-4 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full ${
        type === 'success' 
            ? 'bg-green-500 text-white' 
            : 'bg-red-500 text-white'
    }`;
    notification.innerHTML = `
        <div class="flex items-center space-x-3">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                ${type === 'success' 
                    ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>'
                    : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>'
                }
            </svg>
            <span class="font-medium">${message}</span>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Animar entrada
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);
    
    // Ocultar después de 5 segundos
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 5000);
}