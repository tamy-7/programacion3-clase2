// 1. Función para LISTAR los productos con cálculos de precio
async function cargarItems() {
    try {
        const respuesta = await fetch('http://localhost/AuraTerraParcial/public/items');
        const items = await respuesta.json();
        
        const tablaCuerpo = document.getElementById('cuerpo-tabla');
        if (!tablaCuerpo) return; 
        
        tablaCuerpo.innerHTML = ''; 

        items.forEach(item => {
            // 1. Transformamos el texto raro en una fecha real de JS
            const fechaObjeto = new Date(item.updated_at);
    
            // 2. Le damos el formato que nos gusta (Día/Mes/Año Hora:Min)
            const fechaFormateada = fechaObjeto.toLocaleString('es-AR', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
            // Convertimos a números para operar (usamos 0 si el dato no existe)
            const cantidad = parseFloat(item.quantity) || 0;
            const precioUnitario = parseFloat(item.price) || 0;
            const precioTotal = cantidad * precioUnitario;

            const fila = document.createElement('tr');
            fila.innerHTML = `
                <td>${item.id}</td>
                <td>${item.name}</td>
                <td>${item.quantity}</td>
                <td>$${precioUnitario.toFixed(2)}</td>
                <td><strong>$${precioTotal.toFixed(2)}</strong></td>
                <td>${item.updated_at || 'Sin fecha'}</td> 
            `;
            tablaCuerpo.appendChild(fila);
        });
    } catch (error) {
        console.error("Error al conectar con la API:", error);
    }
}

// 2. Función para GUARDAR nuevos productos
document.addEventListener('DOMContentLoaded', () => {
    cargarItems();

    const formulario = document.getElementById('form-producto');
    if (formulario) {
        formulario.addEventListener('submit', async (e) => {
            e.preventDefault(); 

            const formData = new URLSearchParams();
            formData.append('name', document.getElementById('nombre').value);
            formData.append('quantity', document.getElementById('cantidad').value);
            formData.append('price', document.getElementById('precio').value);

            try {
                const respuesta = await fetch('http://localhost/AuraTerraParcial/public/items', {
                    method: 'POST',
                    body: formData
                });

                const resultado = await respuesta.json();

                if (respuesta.ok) {
                    document.getElementById('mensajes').innerHTML = "<span style='color:green'>✅ ¡Guardado con éxito!</span>";
                    formulario.reset(); 
                    cargarItems();    
                } else {
                    document.getElementById('mensajes').innerHTML = "<span style='color:red'>❌ " + (resultado.errors ? resultado.errors.join(", ") : "Error al guardar") + "</span>";
                }
            } catch (error) {
                console.error("Error al enviar datos:", error);
            }
        });
    }
});