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

// Обработка регистрации
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signup'])) {
    // Проверка CSRF-токена
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('CSRF token validation failed');
    }

    $username = $_POST['signup_username'];
    $name = $_POST['signup_name'];
    $password = $_POST['signup_password'];

    // Защита от SQL-инъекций
    $username = mysqli_real_escape_string($connection, $username);
    $name = mysqli_real_escape_string($connection, $name);
    $password = mysqli_real_escape_string($connection, $password);

    // Хэширование пароля
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Подготовленный запрос к базе данных для добавления нового пользователя
    $stmt = $connection->prepare("INSERT INTO users (Username, Name, Password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $name, $hashed_password);
    $result = $stmt->execute();

    if ($result) {
        // Успешная регистрация
        $_SESSION['username'] = $username;
        header('Location: welcome.php');
        exit();
    } else {
        // Ошибка регистрации
        $_SESSION['error'] = 'Ошибка при регистрации';
        header('Location: form.html');
        exit();
    }
}

// Закрытие соединения с базой данных
$connection->close();
?>
