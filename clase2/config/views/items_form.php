<!DOCTYPE html>
<html lang="es">
<head> //cabecera
    <meta charset="UTF-8">
    <title>Nuevo Item</title> /*el titulo va a hacer lo que pongo dentro*/ 
    <style>    
        body { font-family: Arial, sans-serif; max-width: 500px; margin: 50px auto; padding: 20px; }
        label { display: block; margin-top: 15px; font-weight: bold; }
        input { width: 100%; padding: 8px; margin-top: 5px; border: 1px solid #ddd; border-radius: 4px; }
        button { margin-top: 20px; padding: 10px 20px; background: #87ADFD; color: white; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background: #AAE4FE; }
    </style>
</head>
<body> /*cuerpo*/
    <h1>Crear Nuevo Item</h1>
    <form method="POST" action="/clase2/public/items"> 
        <label>Nombre del Item:
            <input type="text" name="name" required>
        </label>
        
        <label>Cantidad:
            <input type="text" name="qty" min="1" required>
        </label>
        
        <button type="submit">Crear Item</button> /*submit para que lo envie*/
    </form>
</body>
</html>