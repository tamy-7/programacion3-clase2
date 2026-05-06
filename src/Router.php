<?php
namespace Src;

use Src\models\Item;

class Router {
    public function run() {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = $_SERVER['REQUEST_URI'];
        
        // Limpiar la URL de subcarpetas
        $scriptDir = str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']);
        $path = substr($path, strlen($scriptDir));
        $path = '/' . ltrim($path, '/');

        // 1. PERMITIR ARCHIVOS ESTÁTICOS (HTML, JS, CSS)
        // Si la ruta termina en estas extensiones, dejamos que el servidor los entregue normalmente
        if (preg_match('/\.(?:png|jpg|jpeg|gif|js|css|html)$/', $path)) {
            return false; 
        }

        // 2. RUTA RAÍZ (HOME)
        // Si entras a /public/ sin especificar nada, intentamos mostrar el index.html
        if ($path === '/' && $method === 'GET') {
            if (file_exists(__DIR__ . '/../public/index.html')) {
                require __DIR__ . '/../public/index.html';
                exit;
            }
            // Si no existe el HTML, mostramos el estado de la API como respaldo
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(["status" => "ok", "message" => "API AuraTerra funcionando 🚀"]);
            exit;
        }

        // 3. GET /items (LISTAR TODO)
        if ($method === 'GET' && ($path === '/items' || $path === '/items/')) {
            try {
                $items = Item::all();
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode($items, JSON_UNESCAPED_UNICODE);
            } catch (\Exception $e) {
                http_response_code(500);
                echo json_encode(['error' => 'Error de base de datos: ' . $e->getMessage()]);
            }
            exit;
        }

        // 4. POST /items (CREAR CON VALIDACIONES CLASE 4)
        if ($method === 'POST' && ($path === '/items' || $path === '/items/')) {
            $name = isset($_POST['name']) ? trim($_POST['name']) : '';
            $quantity = isset($_POST['quantity']) ? trim($_POST['quantity']) : '';
            $price = isset($_POST['price']) ? trim($_POST['price']) : null;

            $errors = [];

            if ($name === '') {
                $errors[] = "El nombre es obligatorio.";
            } elseif (strlen($name) < 3) {
                $errors[] = "El nombre debe tener al menos 3 caracteres.";
            }

            if (!ctype_digit($quantity) || (int)$quantity <= 0) {
                $errors[] = "La cantidad debe ser un número entero mayor a cero.";
            }

            if (count($errors) > 0) {
                http_response_code(400);
                header('Content-Type: application/json');
                echo json_encode(['ok' => false, 'errors' => $errors], JSON_UNESCAPED_UNICODE);
                exit;
            }

            try {
                $item = Item::create([
                    'name'     => $name,
                    'quantity' => (int)$quantity,
                    'price'    => $price
                ]);

                http_response_code(201);
                header('Content-Type: application/json');
                echo json_encode(['ok' => true, 'item' => $item], JSON_UNESCAPED_UNICODE);
            } catch (\Exception $e) {
                http_response_code(500);
                echo json_encode(['error' => 'No se pudo guardar: ' . $e->getMessage()]);
            }
            exit;
        }

        // 5. 404 NOT FOUND
        http_response_code(404);
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Ruta no encontrada', 'path' => $path]);
        exit;
    }
}