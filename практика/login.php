<?php
session_start();

// Подключение к базе данных
$connection = new mysqli("localhost", "root", "", "nur");

// Проверка соединения
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Генерация CSRF-токена, если его нет
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Обработка входа в систему
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signin'])) {
    // Проверка CSRF-токена
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('CSRF token validation failed');
    }

    $username = $_POST['username'];
    $password = $_POST['password'];

    // Защита от SQL-инъекций
    $stmt = $connection->prepare("SELECT * FROM users WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Проверка пароля с использованием password_verify
        if (password_verify($password, $row['password'])) {
            // Успешный вход в систему
            $_SESSION['username'] = $username;
            header('Location: welcome.php');
            exit();
        }
    }

    // Неверные учетные данные
    $_SESSION['error'] = 'Неверное имя пользователя или пароль';
    header('Location: form.html');
    exit();
}

// Закрытие соединения с базой данных
$connection->close();
?>
