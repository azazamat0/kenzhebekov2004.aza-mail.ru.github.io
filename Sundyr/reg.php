<?php
// Инициализация базы данных SQLite
$database = new SQLite3('database.db');

// Создание таблицы, если её нет
$database->exec('
    CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        login TEXT,
        password TEXT,
        secret INTEGER
    )
');

// Добавление тестовых данных
$database->exec("
    INSERT INTO users (login, password, secret) VALUES
    ('root', 'VLS*jsvds09dv', 875423),
    ('user1', 'Bjkay8A(jl', 698346),
    ('user2', 'Nsvpo97px11#', 927492)
");

// Обработка формы
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'];
    $password = $_POST['password'];

    // Уязвимый запрос, поддерживающий SQL-инъекцию
    $query = "SELECT * FROM users WHERE login = '$login' AND password = '$password'";
    $result = $database->query($query);

    $user = $result->fetchArray(SQLITE3_ASSOC);

    if ($user) {
        $secret = $user['secret'];
        echo "Secret: $secret";
    } else {
        echo 'Login Failed';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SQL Injection Demo</title>
</head>
<body>
    <form method="post" action="">
        <label for="login">Login:</label>
        <input type="text" id="login" name="login" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>

        <input type="submit" value="Login">
    </form>
</body>
</html>
