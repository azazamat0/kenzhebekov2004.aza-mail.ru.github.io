<?php
// Пароль, который необходимо проверить
$expectedPassword = "nur"; // Замените "your_password" на реальный пароль

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получение данных из формы
    $name = md5( $_POST['name']); // Хешируем имя с использованием SHA-256
    $email = md5( $_POST['email']); // Хешируем email с использованием SHA-256
    $enteredPassword = $_POST['password']; // Добавляем поле для ввода пароля

    // Проверяем введенный пароль
    if ($enteredPassword != $expectedPassword) {
        $status = "error"; // Устанавливаем статус ошибки
        $message = "Неверный пароль. Заявка не отправлена.";
    } else {
        // Если пароль верен, сохраняем данные в файл
        $dataToSave = "Имя: $name\nФамилия: $email\nТекст: $enteredPassword\nПароль";
        $filename = "заявки.txt"; // Имя файла, куда будем сохранять данные

        // Открываем файл для записи (или создаем, если он не существует)
        $file = fopen($filename, "a");

        // Записываем данные в файл
        fwrite($file, $dataToSave);

        // Закрываем файл
        fclose($file);

        // Остальной код для отправки почты и установки статуса
    }

    // Возвращаем JSON-ответ на страницу
    echo json_encode(array("status" => $status, "message" => $message));
}

?>
