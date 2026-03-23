# BITÁCORA
### ♦ Hecho

Apache está corriendo correctamente en XAMPP.
La estructura de carpetas del proyecto está completa y organizada (public/, src/, config/).
Router.php está implementado y funcional con rutas GET.
Endpoint /health responde correctamente con JSON válido ({"status": "ok"}).
.htaccess configurado para redirigir todas las solicitudes a index.php.
Se entendió y comprobó el flujo request/response en PHP con Front Controller.

### ♠ Falta

Probar el proyecto en otros sistemas operativos (ej: Linux).
Crear un archivo .gitignore para ignorar archivos innecesarios.
Implementar más endpoints o rutas dinámicas para practicar más casos.
No se porqué, pero veo las llaves en la web. 

### ♣ Bloqueo / Dificultades

Al principio Apache daba errores 404 y “Ruta no encontrada” por la inclusión del directorio public/ en el path.
Dificultades con extensiones en Visual Studio Code (PHP Intelephense y archivos sin .php).
Me falta terminar de comprender del todo cómo funciona internamente mod_rewrite en Apache y cómo procesa las URLs antes de llegar a PHP.
¡LO DI TODO!
