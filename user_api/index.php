<?php
// Встановлюємо Content-Type для JSON-відповіді
header('Content-Type: application/json');


$dataFile = 'data/users.json';

$method = $_SERVER['REQUEST_METHOD'];


$uri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));


$resource = $uri[0] ?? null;


$id = $uri[1] ?? null;


function readData($file) {
    if (file_exists($file)) {
        $data = file_get_contents($file);
        return json_decode($data, true);
    }
    return [];
}


function writeData($file, $data) {
    file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
}


if ($method === 'GET') {
    $users = readData($dataFile);
    if ($resource === 'users') {
        if ($id !== null) {
            // Отримання конкретного користувача за ID
            $user = array_filter($users, fn($user) => $user['id'] == $id);
            if (!empty($user)) {
                echo json_encode(array_values($user)[0]);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'Користувача не знайдено']);
            }
        } else {
            // Отримання списку всіх користувачів
            echo json_encode($users);
        }
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Невірний ресурс']);
    }
}


elseif ($method === 'POST' && $resource === 'users') {
    $data = json_decode(file_get_contents('php://input'), true);
    if (isset($data['name']) && isset($data['email'])) {
        $users = readData($dataFile);
        $newId = empty($users) ? 1 : max(array_column($users, 'id')) + 1;
        $newUser = [
            'id' => $newId,
            'name' => $data['name'],
            'email' => $data['email']
        ];
        $users[] = $newUser;
        writeData($dataFile, $users);
        http_response_code(201);
        echo json_encode($newUser);
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Невірні дані для створення користувача']);
    }
}


elseif ($method === 'PUT' && $resource === 'users' && $id !== null) {
    $data = json_decode(file_get_contents('php://input'), true);
    $users = readData($dataFile);
    $updated = false;
    foreach ($users as &$user) {
        if ($user['id'] == $id) {
            if (isset($data['name'])) {
                $user['name'] = $data['name'];
            }
            if (isset($data['email'])) {
                $user['email'] = $data['email'];
            }
            $updated = true;
            break;
        }
    }
    if ($updated) {
        writeData($dataFile, $users);
        echo json_encode($user);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Користувача не знайдено']);
    }
}


elseif ($method === 'DELETE' && $resource === 'users' && $id !== null) {
    $users = readData($dataFile);
    $initialCount = count($users);
    $users = array_filter($users, fn($user) => $user['id'] != $id);
    if (count($users) < $initialCount) {
        writeData($dataFile, array_values($users)); // Переіндексуємо масив після видалення
        http_response_code(204); // No Content - успішне видалення
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Користувача не знайдено']);
    }
}


else {
    http_response_code(404);
    echo json_encode(['error' => 'Невірний запит']);
}
?>