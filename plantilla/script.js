// Ejemplo de microinteracción (puedes expandir esto)
const btn = document.querySelector('.btn');

btn.addEventListener('mouseover', () => {
    btn.style.backgroundColor = '#0056b3';
});

btn.addEventListener('mouseout', () => {
    btn.style.backgroundColor = '#007bff';
});

// Puedes agregar más funcionalidad interactiva aquí