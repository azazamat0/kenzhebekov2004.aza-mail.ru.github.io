<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получение данных из формы
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $text = $_POST['text'];

    $to = "ospanhann@gmail.com";
    $subject = "Заявка с сайта";
    $from = $email;
    
    $msg = "
    Имя: $name\n
    Фамилия: $surname\n
    Телефон: $phone\n
    Почта: $email\n
    Текст: $text";

    if (mail("ospanhann@gmail.com",
    "Новое письмо с сайта",
    "Имя: ".$name. "\n"
    "Фамилия: ".$surname. "\n"
    "Телефон: ".$phone. "\n"
    "Текст: ". $text,
    "From: no-reply@mydomain.ru \r\n")
    ) } 
    {
        echo ('Письмо успешно отправлено')
    }
    else {
       echo ('Есть ошибки! Проверьте данные...');
    }
    
    
?>
